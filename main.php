<?php  session_start(); ?>

<?php include("head.php"); ?>

<?php
	if($_GET[menu] == "1")
	{
		include("mac.php");
		include("ip_blocking.php");
	}
	else if($_GET[menu] == "2")
	{
		if($_GET[sub] == "1") 
			include("status_view.php");
		else 
			include("status.php");
	}
	else if($_GET[menu] == "3")
		include("upgrade.php");
	else if($_GET[menu] == "4")
		include("history.php");
	else if($_GET[menu] == "5")
		include("admin.php");
?>

<?php include("tail.php"); ?>
