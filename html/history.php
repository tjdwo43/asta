<?php  session_start(); ?>
<?php
	if( $_SESSION['login_id'] =='') 
	{
		echo "<meta http-equiv='refresh' content='0; url=./index.php'>"; 
		exit;
	}
	include "db.php";
?>
<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr>
<td colspan=2 height=20px></td>
</td>
<tr>
<td width=20px></td>
<td bgcolor="#f8dbdb" height=40px style="padding-left:20px;">
<b>업그레이드 이력조회</b>
</td>
<td colspan=4 height=20px></td>
</tr>
</table>




<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr>
<td height=40px width=150px style="padding-left:25px;" align=left valign=center>

<form action="main.php?menu=4"  method=post onsubmit='return menumac_check(this);'>
<select name='model' style='margin-top:10px;'>
<?php
	if($_POST[model] != "")
	{
		echo "<option value=''>--단말기 타입(ALL)--</option>";
		if($_POST[model] == "IF1000")
			echo "<option value='IF1000' selected='selected'>IF1000</option>";
		else
			echo "<option value='IF1000'>IF1000</option>";

		if($_POST[model] == "IF2000")
			echo "<option value='IF2000' selected='selected'>IF2000</option>";
		else
			echo "<option value='IF2000'>IF2000</option>";

		if($_POST[model] == "IPG100")
			echo "<option value='IPG100' selected='selected'>IPG100</option>";
		else
			echo "<option value='IPG100'>IPG100</option>";

		if($_POST[model] == "ACU100")
			echo "<option value='ACU100' selected='selected'>ACU100</option>";
		else
			echo "<option value='ACU100'>ACU100</option>";

		if($_POST[model] == "OTR620")
			echo "<option value='OTR620' selected='selected'>OTR620</option>";
		else
			echo "<option value='OTR620'>OTR620</option>";
	}	
	else
	{
?>
	<option value="" selected="selected">--단말기 타입(ALL)--</option>
	<option value="IF1000">IF1000</option>
	<option value="IF2000">IF2000</option>
	<option value="IPG100">IPG100</option>
	<option value="ACU100">ACU100</option>
	<option value="OTR620">OTR620</option>
<?php
	}
?>
</select>
</td>
<td height=40px width=100px style="padding-left:5px;" align=left valign=center>
일치하는 MAC :
</td>
<td height=40px width=150px style="padding-left:5px;" align=left valign=center>
<?php
	if($_POST[MAC] != "")
  		echo "<input name='MAC' type=text value='".$_POST[MAC]."' maxlength=12>";
	else
	{
?>
  <input name="MAC" type=text value="" maxlength=12>
<?php
	}
?>

</td>
<td height=40px width=150px style="padding-left:5px;" align=left valign=center>
<input type="image"  style="cursor:pointer;margin-top:-1px;" src='./img/btn_view_all_n.png' 
		onmouseover="this.src='./img/btn_view_all_h.png'" onmousedown="this.src='./img/btn_view_all_p.png'" onmouseout="this.src='./img/btn_view_all_n.png'">
</form>

</td>


<td height=40px style="padding-right:25px;" align=right valign=center>

<form name="status_view" action="main.php?menu=4&sub=0"  method=post>
<input name="excel" type="image" style="cursor:pointer" src='./img/btn_save_excel_n.png' 
		onmouseover="this.src='./img/btn_save_excel_h.png'" onmousedown="this.src='./img/btn_save_excel_p.png'" onmouseout="this.src='./img/btn_save_excel_n.png'" onClick="status_view_submit(3)">
</form>
<?php
	if(0)
	{
?>
<form action=historyclear.php  method=post>
<input name="remove" type="image" style="cursor:pointer" src='./img/btn_clear_n.png' 
		onmouseover="this.src='./img/btn_clear_h.png'" onmousedown="this.src='./img/btn_clear_p.png'" onmouseout="this.src='./img/btn_clear_n.png'">
</form>

<?php
	}
?>
</td>
</tr>
</table>

<?php
$Connection = mysqli_connect($DB_HOST,$DB_USER,$DB_USER_PASS, $DB_NAME);
if(!$Connection)
{
	$error = mysqli_connect_error(); 
	$errno = mysqli_connect_errno(); 
	echo "$errno: $error\n";
	exit();
}

$WHERE="";
if($_POST[model] != "")
	$WHERE="where Reader_Conf_Model='".$_POST[model]."' ";

if($_POST[MAC] != "")
{
	if($WHERE == "")
		$WHERE="where Reader_Conf_Mac ='".$_POST[MAC]."' ";
	else
		$WHERE=$WHERE." and Reader_Conf_Mac ='".$_POST[MAC]."' ";
}	

$sql ="select * from Table_History_Update ".$WHERE." order by num desc limit 100";
//echo $sql;
/*
if($_GET[sel] == "1")
{
	if($_SESSION['select_mac']!="")	
		$sql ="select * from Table_History_Update where Reader_Conf_Mac='".$_SESSION['select_mac']."' order by num desc limit 100";
}
 */

$result=mysqli_query($Connection, $sql);
if(!$result)
{
	echo "Error : ".mysqli_error($Connection);
}
else
{

echo "<table width=100% cellspacing=0 cellpadding=0 border=0>";
echo "<tr><td style=padding-left:20px>&nbsp;</td>";
echo "<td>";

//echo "<table width=100% cellspacing=0 cellpadding=0 border=1px bordercolor=#c8c8c8>";
echo "<table width=100% cellspacing=0 cellpadding=0 style='border:1px solid #c8c8c8'>";

echo "<tr><td colspan=8 align=right style=padding-right:20px>";
echo "Total : ".mysqli_num_rows($result);
echo "</td></tr>";

echo "<tr height=30px>";
//echo "<td width=200px bgcolor=#ebebeb align=center><b>Num</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>Date</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>MAC</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>Status</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>FileName</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>UserId</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>Model</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>Name</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>Version</b></td>";

echo "</tr>";

$tag_left="<td width=200px align=center style='border:1px dotted #c8c8c8'>";
$tag_right="</td>";
while($row=mysqli_fetch_assoc($result))
{
	echo "<tr height=30px>";
	//echo $tag_left.$row[num].$tag_right;
	echo $tag_left.$row[UpdateDate].$tag_right;
	echo $tag_left.$row[Reader_Conf_Mac].$tag_right;
	if($row[Reader_Status] == $UPDATE_STATUS_END_FAIL) 
		echo $tag_left.$row[Reader_Status]."(".$row[Fail_Reason].")".$tag_right;
	else
		echo $tag_left.$row[Reader_Status].$tag_right;
	echo $tag_left.$row[FileName].$tag_right;
	echo $tag_left.$row[UserId].$tag_right;
	echo $tag_left.$row[Reader_Conf_Model].$tag_right;
	echo $tag_left.$row[Reader_Conf_Name].$tag_right;
	echo $tag_left.$row[Reader_Conf_Version].$tag_right;

	echo "</tr>";
}
mysqli_free_result($result);

echo "</table>";

echo "</td>";
echo "<td style=padding-right:20px>&nbsp;</td></tr>";
echo "</table>";

mysqli_close($Connection);
}
?>
