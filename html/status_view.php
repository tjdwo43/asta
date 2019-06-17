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
<b>연결된 단말 조회</b>
</td></tr>
</table>


<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr>
<td height=40px style="padding-left:25px;" align=left valign=center>

<form name="status_view" action="main.php?menu=2&sub=1"  method=post>

<select name='model'>
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
&nbsp;
<select name='cms'>
<?php
	if($_POST[cms] != "")
	{
		echo "<option value='' selected='selected'>--주장치 종류(ALL)--</option>";
		if($_POST[cms] == "사용안함")
			echo "<option value='사용안함' selected='selected'>사용안함</option>";
		else
			echo "<option value='사용안함'>사용안함</option>";

		if($_POST[cms] == "Ntype")
			echo "<option value='Ntype' selected='selected'>Ntype</option>";
		else
			echo "<option value='Ntype'>Ntype</option>";

		if($_POST[cms] == "811 type")
			echo "<option value='811 type' selected='selected'>811 type</option>";
		else
			echo "<option value='811 type'>811 type</option>";

		if($_POST[cms] == "AIPC")
			echo "<option value='AIPC' selected='selected'>AIPC</option>";
		else
			echo "<option value='AIPC'>AIPC</option>";

		if($_POST[cms] == "SW 주장치")
			echo "<option value='SW 주장치' selected='selected'>SW 주장치</option>";
		else
			echo "<option value='SW 주장치'>SW 주장치</option>";
	
	}
	else
	{
?>
	<option value="" selected="selected">--주장치 종류(ALL)--</option>
	<option value="사용안함">사용안함</option>
	<option value="Ntype">Ntype</option>
	<option value="811 type">811 type</option>
	<option value="AIPC">AIPC</option>
	<option value="SW 주장치">SW 주장치</option>
<?php
	 }
?>
</select>

&nbsp;일치하는 버전 :
<?php
	if($_POST[version] != "")
  		echo "<input name='version' type=text value='".$_POST[version]."' maxlength=12>";
	else
	{
?>
  <input name="version" type=text value="" maxlength=12>
<?php
	}
?>
</td>

<td height=40px style="padding-right:25px;" align=right valign=center>
<input name="excel" type="image" style="cursor:pointer" src='./img/btn_save_excel_n.png' 
		onmouseover="this.src='./img/btn_save_excel_h.png'" onmousedown="this.src='./img/btn_save_excel_p.png'" onmouseout="this.src='./img/btn_save_excel_n.png'" onClick="status_view_submit(1)">

<input name="search" type="image" style="cursor:pointer" src='./img/btn_view_all_n.png' 
		onmouseover="this.src='./img/btn_view_all_h.png'" onmousedown="this.src='./img/btn_view_all_p.png'" onmouseout="this.src='./img/btn_view_all_n.png'" onClick="status_view_submit(2)">

</td>
</tr>
</table>
</form>

<?php
//echo "/".$_POST[cms]."/";
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

if($_POST[cms] != "")
{
	if($WHERE == "")
		$WHERE="where Reader_Cms ='".$_POST[cms]."' ";
	else
		$WHERE=$WHERE." and Reader_Cms ='".$_POST[cms]."' ";
}	
if($_POST[version] != "")
{
	if($WHERE == "")
		$WHERE="where Reader_Conf_Version ='".$_POST[version]."' ";
	else
		$WHERE=$WHERE." and Reader_Conf_Version ='".$_POST[version]."' ";
}

//$sql ="select * from Table_Reader ".$WHERE." order by UpdateDate desc limit 100";
$sql ="select * from Table_Reader ".$WHERE." order by UpdateDate desc";
$result=mysqli_query($Connection, $sql);
if(!$result)
{
	echo "Error : ".mysqli_error($Connection);
	exit;
}

echo "<table width=100% cellspacing=0 cellpadding=0 border=0>";
echo "<tr><td style=padding-left:10px>&nbsp;</td>";
echo "<td>";

echo "<table width=100% cellspacing=0 cellpadding=0 style='border:1px solid #c8c8c8'>";

echo "<tr><td colspan=15 align=right style=padding-right:20px>";
echo "Total : ".mysqli_num_rows($result);
echo "</td></tr>";

echo "<tr height=30px>";
echo "<td bgcolor=#ebebeb align=center><b>Num</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>모델명</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>MAC</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>단말기 이름</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>단말기 ID</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>SYS ID</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>버전정보</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>Static IP</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>IP</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>GATEWAY</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>SUBNET</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>DHCP</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>주장치타입</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>경해제 상태</b></td>";
echo "<td bgcolor=#ebebeb align=center><b>마지막 접속일자</b></td>";
echo "</tr>";

$tag_left="<td align=center style='border:1px dotted #c8c8c8'>";
$tag_right="</td>";
$NUM=1;
while($row=mysqli_fetch_assoc($result))
{
	echo "<tr height=30px>";
	//echo $tag_left.$row[num].$tag_right;
	echo $tag_left.$NUM.$tag_right;
	echo $tag_left.$row[Reader_Conf_Model].$tag_right;
	echo $tag_left.$row[Reader_Conf_Mac].$tag_right;
	echo $tag_left.$row[Reader_Conf_Name].$tag_right;
	echo $tag_left.$row[Reader_Conf_Id].$tag_right;
	echo $tag_left.$row[Reader_Dms_sysid].$tag_right;
	echo $tag_left.$row[Reader_Conf_Version].$tag_right;
	echo $tag_left.$row[Reader_Net_StaticIp].$tag_right;
	echo $tag_left.$row[Reader_Net_Ip].$tag_right;
	echo $tag_left.$row[Reader_Net_Gateway].$tag_right;
	echo $tag_left.$row[Reader_Net_Subnet].$tag_right;
	echo $tag_left.$row[Reader_Net_Dhcp].$tag_right;
	echo $tag_left.$row[Reader_Cms].$tag_right;
	echo $tag_left.$row[Reader_Cms_Status].$tag_right;
	echo $tag_left.$row[UpdateDate].$tag_right;
	$NUM=$NUM+1;
	echo "</tr>";
}
mysqli_free_result($result);

echo "</table>";

echo "</td>";
echo "<td style=padding-right:10px>&nbsp;</td></tr>";
echo "</table>";





mysqli_close($Connection);
?>
