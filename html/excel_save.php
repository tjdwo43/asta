<?php
	session_start();
	if( $_SESSION['login_id'] =='') 
	{
		echo "<meta http-equiv='refresh' content='0; url=./index.php'>"; 
		exit;
	}
	include "db.php";

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


header( "Content-type: application/vnd.ms-excel; charset=euc-kr" );
header( "Expires: 0" );
header( "Cache-Control: must-revalidate, post-check=0,pre-check=0" );
header( "Pragma: public" );
$SAVE_FILE ="Content-Disposition: attachment; filename=reader.xls";
//header( "Content-Disposition: attachment; filename=IF1000.xls" );
header( $SAVE_FILE );

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
?>
