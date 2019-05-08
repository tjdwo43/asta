<?php  session_start(); ?>
<?php
	if( $_SESSION['login_id'] =='') 
	{
		echo "<meta http-equiv='refresh' content='0; url=./index.php'>"; 
		exit;
	}
	include "db.php";

	$Connection = mysqli_connect($DB_HOST,$DB_USER,$DB_USER_PASS, $DB_NAME);
	if(!$Connection)
	{
		$error = mysqli_connect_error(); 
		$errno = mysqli_connect_errno(); 
		echo "$errno: $error\n";
		exit();
	}

	$select_sql ="select * from Table_Update_List";
	$result=mysqli_query($Connection, $select_sql);
	if($result)
	{
		$Count=mysqli_num_rows($result);
		for($i=0; $i<$Count; $i++)
		{
			$row=mysqli_fetch_assoc($result);
			if( $row[Reader_Status] == $UPDATE_STATUS_END_FAIL)
			{
				unlink($TARGET_DIR.$row[Reader_Conf_Mac]);
				echo "@delete ".$row[Reader_Conf_Mac];
			}
		}
		if($Count >= 1)
		{
			echo "<br>";
			$delete_sql ="delete from Table_Update_List where Reader_Status='".$UPDATE_STATUS_END_FAIL."'";
			#echo $delete_sql;
			$result=mysqli_query($Connection, $delete_sql);
		}
		mysqli_free_result($result);
	}
	echo "<meta http-equiv='refresh' content='0; url=./main.php?menu=2'>";
	exit;
?>
