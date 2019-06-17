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
<b>기본 MAC 변경</b>
</td>
<td colspan=4 height=20px></td>
</tr>
</table>


<table cellspacing=0 cellpadding=0 border=0>
<tr>
<form action=mac_edit.php  method=post onsubmit='return menumac_edit(this);'>
<td height=60px valign=center style="padding-left:25px;">
<input name="MAC" type=text class="mac_box" value="<?php echo $_SESSION['select_mac'];?>" maxlength="12">
</td>
<td height=40px style="padding-left:25px;" align=left valign=center>
<input name="remove" type="image" style="cursor:pointer" src='./img/btn_edit_n.png' 
		onmouseover="this.src='./img/btn_edit_h.png'" onmousedown="this.src='./img/btn_edit_p.png'" onmouseout="this.src='./img/btn_edit_n.png'">
</td>
</tr>

<tr>
<td valign=center style="padding-left:25px;" colspan=2>
맥 12자리를 입력하세요( : 제외) 
</td>
</tr>
<tr>


</table>
</form>
