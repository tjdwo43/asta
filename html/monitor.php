<?php  session_start(); ?>
<?php
	if( $_SESSION['login_id'] =='') 
	{
		echo "<meta http-equiv='refresh' content='0; url=./index.php'>"; 
		exit;
	}
	include "db.php";

function MakeReader($model, $icon, $mac, $version, $group)
{

	if($mac != '-')
		echo "<a href=mac_change.php?MAC=".$mac.">";

	if($group == '-')
		echo "<table width=74px height=49px cellspacing=0 cellpadding=0 style='border:2px solid #000000;margin:0 0 0 0;'>";
	else
		echo "<table width=74px height=49px cellspacing=0 cellpadding=0 style='border:2px solid #0000ff;margin:0 0 0 0;'>";
	echo "<tr height=40px><td align=center colspan=2 bgcolor='#eaeaea' style='border-bottom:1px solid #c8c8c8'><b>".$model."</b><br>";
	if($mac == '-')
		echo "-";
	else
	{
		echo substr($mac,6,6);
	}
	echo "</td></tr>";

	echo "<tr height=25px style='margin:0'><td width=25px valign=center style='margin:0'>";
	if($icon == "ready")
		echo "<img src='./img/icon_ready_to_upgrade.png' style='margin:-1px'></td>";
	else if($icon == "down")
		echo "<img src='./img/icon_downloading.png' style='margin:-1px'></td>";
	else if($icon == "update")
		echo "<img src='./img/icon_run_upgrade.png' style='margin:-1px'></td>";
	else if($icon == "fail")
		echo "<img src='./img/icon_upgrade_fail.png' style='margin:-1px'></td>";
	else if($icon == "succ")
		echo "<img src='./img/icon_success.png' style='margin:-1px'></td>";
	else
		echo "<img src='./img/icon_stand_by.png' style='margin:-1px'></td>";
		//echo "<img src='./img/icon_empty.png' style='margin:0'></td>";

	echo "<td align=left>&nbsp;".$version;
	echo "</td></tr>";

	echo "</table>";

	if($mac != '-')
		echo "</a>";
}

?>

<table height=100% height=100% cellspacing=0 cellpadding=0 style='border:1px solid #c8c8c8;margin:0 0 0 0;'>
<tr>
<td background='./img/title_bg.png' height=49px>
<img src='./img/title_view_status_upgrade.png' style='margin-top:-3px;margin-left:10px'>
</td>
</tr>

<tr><td align=right> <a href=delete_success.php>Delete Fail Status</a>&nbsp;</td></tr>

<tr><td>

<table height=100% width=100% cellspacing=0 cellpadding=10px border=0 style='padding:20px 20px 30px 20px;'>
<tr>
<?php
	$Connection = mysqli_connect($DB_HOST,$DB_USER,$DB_USER_PASS, $DB_NAME);
	if(!$Connection)
	{
		$error = mysqli_connect_error(); 
		$errno = mysqli_connect_errno(); 
		echo "$errno: $error\n";
		exit();
	}

	$select_sql ="select * from Table_Update_List";
	$result=mysqli_query($Connection, $select_sql);
	if($result)
	{
		$Count=mysqli_num_rows($result);
		if($Count == "0")
		{
			$select_sql = "select * from Table_Reader order by UpdateDate desc";
			$result=mysqli_query($Connection, $select_sql);
			$Count=mysqli_num_rows($result);

			if($Count == "0")
			{
				for($i=0; $i<$FTP_MAX_CLIENT; $i++)
				{
					if($i==10 || $i==20 || $i==30 ||$i==40 ||$i==50 ||$i==60 ||$i==70 || $i==80 || $i==90 || $i==100 || $i==110 || $i==120 || $i==130 || $i==140 || $i==150 || $i==160 || $i==170 || $i==180 || $i== 190 || $i==200) 
						echo "</tr><tr>";
					echo "<td>";
					MakeReader("-", "-", "-", "-", "-");
					echo "</td>";
				}
			}
			else
			{
				for($i=0; $i<$FTP_MAX_CLIENT; $i++)
				{
					if($i==10 || $i==20 || $i==30 ||$i==40 ||$i==50 ||$i==60 ||$i==70 || $i==80 || $i==90 || $i==100 || $i==110 || $i==120 || $i==130 || $i==140 || $i==150 || $i==160 || $i==170 || $i==180 || $i== 190 || $i==200) 
						echo "</tr><tr>";
					echo "<td>";
					if($Count>$i)
					{
						$row=mysqli_fetch_assoc($result);
						$icon = '-';
						$group="-";

						MakeReader($row[Reader_Conf_Model], $icon, $row[Reader_Conf_Mac], $row[Reader_Conf_Version], $group);
					}
					else
						MakeReader("-", "-", "-", "-", "-");

					echo "</td>";
				}
			}
		}
		else
		{
			for($i=0; $i<$FTP_MAX_CLIENT; $i++)
			{
				if($i==10 || $i==20 || $i==30 ||$i==40 ||$i==50 ||$i==60 ||$i==70 || $i==80 || $i==90 || $i==100 || $i==110 || $i==120 || $i==130 || $i==140 || $i==150 || $i==160 || $i==170 || $i==180 || $i== 190 || $i==200) 
					echo "</tr><tr>";
				echo "<td>";
				if($Count>$i)
				{
					$row=mysqli_fetch_assoc($result);
					if($row[Reader_Status] == $UPDATE_STATUS_PREADY)
						$icon = "ready"; // 업데이트 예약 
					else if($row[Reader_Status] == $UPDATE_STATUS_START) 
						$icon = "down"; // 다운로드중 
					else if($row[Reader_Status] == $UPDATE_STATUS_UPDATE)
						$icon = "update"; // 업데이트 중
					else if($row[Reader_Status] == $UPDATE_STATUS_END_FAIL)
						$icon = "fail"; // 업데이트 중 
					else if($row[Reader_Status] == $UPDATE_STATUS_END_SUCCESS)
						$icon = "succ"; // 업데이트 중 
					else
						$icon = '-';

					if($row[FileName] == $MODEL_IF1000
						|| $row[FileName] == $MODEL_IF2000
						|| $row[FileName] == $MODEL_IPG100
						|| $row[FileName] == $MODEL_ACU100
						|| $row[FileName] == $MODEL_OTR620
						)
						$group="enable";
					else	
						$group="-";

					MakeReader($row[Reader_Conf_Model], $icon, $row[Reader_Conf_Mac], $row[Reader_Conf_Version], $group);
				}
				else
					MakeReader("-", "-", "-", "-", "-");

				echo "</td>";
			}
		}
		mysqli_free_result($result);
	}

	mysqli_close($Connection);
?>
</tr>
</table>


</td></tr></table>


