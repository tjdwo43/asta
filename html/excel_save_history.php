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
//$sql ="select * from Table_Reader ".$WHERE." order by UpdateDate desc limit 100";
$sql ="select * from Table_History_Update order by UpdateDate desc";
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
$SAVE_FILE ="Content-Disposition: attachment; filename=history.xls";
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
echo "<td width=200px bgcolor=#ebebeb align=center><b>Date</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>MAC</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>Status</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>FileName</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>UserId</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>Model</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>Name</b></td>";
echo "<td width=200px bgcolor=#ebebeb align=center><b>Version</b></td>";

echo "</tr>";

$tag_left="<td align=center style='border:1px dotted #c8c8c8'>";
$tag_right="</td>";
$NUM=1;
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
?>
