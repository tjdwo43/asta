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

	$Connection = mysqli_connect($DB_HOST,$DB_USER,$DB_USER_PASS, $DB_NAME);
	if(!$Connection)
	{
		$error = mysqli_connect_error(); 
		$errno = mysqli_connect_errno(); 
		echo "$errno: $error\n";
		exit();
	}

	$delete_sql ="delete from Table_History_Update";
	$result=mysqli_query($Connection, $delete_sql);
	mysqli_close($Connection);

	
	echo "<meta http-equiv='refresh' content='0; url=./main.php?menu=4&sel=0'>";
	exit;
?>	
