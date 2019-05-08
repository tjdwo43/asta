<?php  session_start(); ?>
<?php
	if( $_SESSION['login_id'] =='') 
	{
		echo "<meta http-equiv='refresh' content='0; url=./index.php'>"; 
		exit;
	}
	include "db.php";
?>

<table width=100% cellspacing=20px cellpadding=0 border=0>
<tr><td bgcolor="#f8dbdb" height=40px style="padding-left:20px;">
<b>상태조회</b>
</td></tr>
</table>

<table cellspacing=0 cellpadding=0 border=0 style="margin:0 0 0 20px">
<tr>
<td valign=top>
<?php
	include "monitor.php";
?>

</td>
<td valign=top>

<?php
	include "reader.php";
?>

</td>
</tr>
</table>
