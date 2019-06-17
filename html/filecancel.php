<?php  session_start(); ?>
<?php
	if( $_SESSION['login_id'] =='') 
	{
		echo "<meta http-equiv='refresh' content='0; url=./index.php'>"; 
		exit;
	}
	include "db.php";
?>

<?php

	if($_GET[rule] =="on")
	{
		$Connection = mysqli_connect($DB_HOST,$DB_USER,$DB_USER_PASS, $DB_NAME);
		if(!$Connection)
		{
			$error = mysqli_connect_error(); 
			$errno = mysqli_connect_errno(); 
			echo "$errno: $error\n";
			exit();
		}
		$delete_sql ="delete from Table_Update_Rule_List where Rule_Model='".$_POST[model]."'";
		$result=mysqli_query($Connection, $delete_sql);

		unlink($TARGET_DIR.$_POST[model]);
	}
	else
	{
		if($_POST[mac]=="")
		{
			echo "<meta http-equiv='refresh' content='0; url=./main.php'>";
			exit;
		}

		$Connection = mysqli_connect($DB_HOST,$DB_USER,$DB_USER_PASS, $DB_NAME);
		if(!$Connection)
		{
			$error = mysqli_connect_error(); 
			$errno = mysqli_connect_errno(); 
			echo "$errno: $error\n";
			exit();
		}
/*
		$select_sql ="select * from Table_Update_List where Reader_Conf_Mac='".$_POST[mac]."'";
		$result=mysqli_query($Connection, $select_sql);
		if($result)
		{
			if(mysqli_num_rows($result)=="1")
			{
				$row=mysqli_fetch_assoc($result);
				mysqli_free_result($result);
				if($row[Reader_Status] == $UPDATE_STATUS_START)
				{
					mysqli_close($Connection);
					echo "<script type='text/javascript'>alert('업데이트 중입니다');history.go(-1);</script>";
					exit;	
				}
			}
		}
 */
		$delete_sql ="delete from Table_Update_List where Reader_Conf_Mac='".$_POST[mac]."'";
		$result=mysqli_query($Connection, $delete_sql);

		$UserId = $_SESSION['login_id'];
		$insert_sql = "insert into Table_History_Update(Reader_Conf_Mac, Reader_Conf_Model, Reader_Conf_Name, Reader_Conf_Version, Reader_Status, Fail_Reason, FileName, UserId, UpdateDate) values('".$_POST[mac]."','-', '-', '-','".$UPDATE_STATUS_CANCEL."', '-', '".$_POST[filename]."','".$UserId."', now())";
		$result=mysqli_query($Connection, $insert_sql);
		if($result)
			echo "<font color=red>history query Success!!!</font><br>";


		unlink($TARGET_DIR.$_POST[mac]);
	}

	mysqli_close($Connection);
	echo "<meta http-equiv='refresh' content='0; url=./main.php?menu=3'>";
	exit;
?>	
