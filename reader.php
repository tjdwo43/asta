<?php  session_start(); ?>
<?php
	if( $_SESSION['login_id'] =='') 
	{
		echo "<meta http-equiv='refresh' content='0; url=./index.php'>"; 
		exit;
	}
	include "db.php";
?>

<?php
	$Connection = mysqli_connect($DB_HOST,$DB_USER,$DB_USER_PASS, $DB_NAME);
	if(!$Connection)
	{
		$error = mysqli_connect_error(); 
		$errno = mysqli_connect_errno(); 
		echo "$errno: $error\n";
		exit();
	}

	$sql ="select * from Table_Reader where Reader_Conf_Mac='".$_SESSION['select_mac']."'";
	$result=mysqli_query($Connection, $sql);
	if($result)
		$row=mysqli_fetch_assoc($result);

	$Count=mysqli_num_rows($result);
?>

<table height=100% cellspacing=0 cellpadding=0 border=0 style='border:1px solid #c8c8c8;margin:0 0 0 20px;'>
<tr>
<td background='./img/title_bg.png' height=49px>
<img src='./img/title_view_device_info.png' style='margin-top:-3px;margin-left:10px'>
</td>
<td background='./img/title_bg.png' height=49px align=right>

<a href="main.php?menu=2&sub=1" >
<img style="cursor:pointer" src='./img/btn_view_device list_n.png' 
		onmouseover="this.src='./img/btn_view_device list_h.png'" onmousedown="this.src='./img/btn_view_device list_p.png'" onmouseout="this.src='./img/btn_view_device list_n.png'">
</a>
&nbsp;
</tr>
</tr>

<tr>
<td colspan=2>

<table cellspacing=0 cellpadding=10px border=0 style='padding:0 20px 20px 20px;'>
<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>모델명</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
		echo $row[Reader_Conf_Model];
	else
		echo "unknow";
?>
</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>MAC</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
		echo $row[Reader_Conf_Mac];
	else
		echo "unknow";
?>
</td>
</tr>


<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>단말기 이름</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
		echo $row[Reader_Conf_Name];
	else
		echo "unknow";
?>
</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>단말기 ID</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
		echo $row[Reader_Conf_Id];
	else
		echo "unknow";
?>
</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>SYS ID</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
	{
		echo $row[Reader_Dms_sysid];
	}
	else
		echo "unknow";
?>
</td>
</tr>



<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>버전정보</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
		echo $row[Reader_Conf_Version];
	else
		echo "unknow";
?>

</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>마지막 접속 일자</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
		echo "<font color=red>".$row[UpdateDate]."</font>";
	else
		echo "unknow";
?>
</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>STATIC IP</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
		echo $row[Reader_Net_StaticIp];
	else
		echo "unknow";
?>
</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>IP</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
		echo $row[Reader_Net_Ip];
	else
		echo "unknow";
?>
</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>GATEWAY</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
		echo $row[Reader_Net_Gateway];
	else
		echo "unknow";
?>

</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>SUBNET MASK</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
		echo $row[Reader_Net_Subnet];
	else
		echo "unknow";
?>

</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>DHCP</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	
	if($Count=="1")
		echo $row[Reader_Net_Dhcp];
	else
		echo "unknow";
?>
</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>주장치 타입</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	if($Count=="1")
		echo $row[Reader_Cms];
	else
		echo "unknow";
?>

</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>경/해제 상태</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	if($Count=="1")
		echo $row[Reader_Cms_Status];
	else
		echo "unknow";
?>
</td>
</tr>

<tr>
<td width=200px style='padding:5px;border-bottom:1px solid #c8c8c8'><b>업그레이드 상태</b></td>
<td style='border-bottom:1px solid #c8c8c8'>
<?php
	mysqli_free_result($result);

	$STATUS = "-";
	$FILENAME ="";

	$sql ="select * from Table_Update_List where Reader_Conf_Mac='".$_SESSION['select_mac']."'";
	$result=mysqli_query($Connection, $sql);
	if($result)
	{
		$row=mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result)=="1")
		{
			$STATUS=$row[Reader_Status];
			$FILENAME=$row[FileName];
		}
		mysqli_free_result($result);
	}

	if($FILENAME=="")
		echo $STATUS;
	else
		echo $STATUS." ( ".$FILENAME." )";
?>
</td>
</tr>

</table>

<!--
<table width=100% cellspacing=10px cellpadding=0 border=0>
<tr><td height=40px>
<input name="upgrade" type="image" style="cursor:pointer" src='./img/btn_upgrade_run_n.png' 
		onmouseover="this.src='./img/btn_upgrade_run_h.png'" onmousedown="this.src='./img/btn_upgrade_run_p.png'" onmouseout="this.src='./img/btn_upgrade_run_n.png'">

</td></tr>
</table>
-->
</form>

</td>
</tr>
</table>

<?php
mysqli_close($Connection);
?>
