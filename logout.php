<?php  session_start(); ?> 

<?php
	//unset($_SESSION['login_id']);
	session_unset();
	echo "<meta http-equiv='refresh' content='0; url=./index.php'>";
	exit;
?>
