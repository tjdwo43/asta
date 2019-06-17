<?php  session_start(); ?>
<?php
	if( $_SESSION['login_id'] =='') 
	{
		echo "<meta http-equiv='refresh' content='0; url=./index.php'>"; 
		exit;
	}

    $_SESSION['select_mac']=$_GET[MAC];
    $_SESSION['view_mac']=$_GET[MAC][0].$_GET[MAC][1].":".$_GET[MAC][2].$_GET[MAC][3].":".$_GET[MAC][4].$_GET[MAC][5].":";
    $_SESSION['view_mac']= $_SESSION['view_mac'].$_GET[MAC][6].$_GET[MAC][7].":".$_GET[MAC][8].$_GET[MAC][9].":".$_GET[MAC][10].$_GET[MAC][11];

	 echo "<script type='text/javascript'>history.go(-1);</script>";
	exit;
?>

