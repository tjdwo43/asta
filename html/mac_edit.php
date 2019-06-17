<?php  session_start(); ?>
<?php
	if( $_SESSION['login_id'] =='') 
	{
		echo "<meta http-equiv='refresh' content='0; url=./index.php'>"; 
		exit;
	}

    $_SESSION['select_mac']=$_POST[MAC];
    $_SESSION['view_mac']=$_POST[MAC][0].$_POST[MAC][1].":".$_POST[MAC][2].$_POST[MAC][3].":".$_POST[MAC][4].$_POST[MAC][5].":";
    $_SESSION['view_mac']= $_SESSION['view_mac'].$_POST[MAC][6].$_POST[MAC][7].":".$_POST[MAC][8].$_POST[MAC][9].":".$_POST[MAC][10].$_POST[MAC][11];

	echo "<meta http-equiv='refresh' content='0; url=./main.php?menu=1'>";
	exit;
?>


