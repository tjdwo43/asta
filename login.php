<?php  session_start(); ?>

<?php
	include "db.php";

    $LOGIN_ID=$_POST[MB_ID];
	$LOGIN_PASS=$_POST[MB_PW];

	if( $LOGIN_ID != '' && $LOGIN_PASS != '')
	{
		if( $LOGIN_ID == $LOGIN_ADMIN && $LOGIN_PASS == $LOGIN_ADMIN_PASS)
		{
			$_SESSION['login_id'] = $LOGIN_ID;
			$_SESSION['select_mac'] = "";
			$_SESSION['view_mac'] = "";
			$_SESSION['menu'] = "upgrade";
			echo "<meta http-equiv='refresh' content='0; url=./main.php?menu=1'>";
			exit;
		}
	}
	session_unset();
	echo "<script>alert('로그인 실패');</script>";
	echo "<meta http-equiv='refresh' content='0; url=./index.php'>";
	exit;
?>
