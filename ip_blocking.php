<?php  session_start(); ?>
<?php
	if( $_SESSION['login_id'] =='') 
	{
		echo "<meta http-equiv='refresh' content='0; url=./index.php'>"; 
		exit;
	}
?>
<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr>
<td colspan=2 height=20px></td>
</td>
<tr>
<td width=20px></td>
<td bgcolor="#f8dbdb" height=40px style="padding-left:20px;">
<b>아이피 차단</b>
</td>
<td colspan=4 height=20px></td>
</tr>
</table>

<table cellspacing=0 cellpadding=0 border=0>
<tr><td style="padding-left:25px;">
<br>not Ready
</td></tr>
</table>
