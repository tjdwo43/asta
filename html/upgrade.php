<?php  session_start(); ?>
<?php
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

?>

<?php
	if(1)
	{
?>
<table width=100% cellspacing=20px cellpadding=0 border=0>
<tr><td bgcolor="#f8dbdb" height=40px style="padding-left:20px;">
<b>1:N 모델별 업그레이드 규칙 : 정식 배포 버전(V)만 등록 가능합니다</b>
</td></tr>
</table>

<table cellspacing=0 cellpadding=0 border=0 style="padding:0 0 20px 20px">
<form action='fileupload.php?rule=on'  method=post enctype="multipart/form-data">

<tr height=30px>
<td valign=center align=left>
<select name='model'>
	<option value="" selected="selected">--단말기 타입--</option>
	<option value="IF1000">IF1000</option>
	<option value="IF2000">IF2000</option>
	<option value="IPG100">IPG100</option>
	<option value="ACU100">ACU100</option>
	<option value="OTR620">OTR620</option>
</select>
&nbsp;
<select name='cms'>
	<option value="-" selected="selected">--주장치 종류--</option>
	<option value="사용안함">사용안함</option>
	<option value="Ntype">Ntype</option>
	<option value="811 type">811 type</option>
	<option value="AIPC">AIPC</option>
	<option value="SW 주장치">SW 주장치</option>
</select>
</td><td align=right>
&nbsp;일치하는 버전 :
</td><td valign=center style='padding-left:20px;'>
<input name="version" type=text value="" maxlength=12>
</td></tr>

<tr>
<td colspan=2>
<input name="upgrade" type="image" style="cursor:pointer" src='./img/btn_upgrade_run_n.png' 
		onmouseover="this.src='./img/btn_upgrade_run_h.png'" onmousedown="this.src='./img/btn_upgrade_run_p.png'" onmouseout="this.src='./img/btn_upgrade_run_n.png'">

</td>
<td style='padding-left:20px;'>
<input type=file name=upfile accept=".head">
</td>
</tr>


</table>
</form>

<?php

	$select_sql ="select * from Table_Update_Rule_List";
	$result=mysqli_query($Connection, $select_sql);
	if($result)
	{
		$Count=mysqli_num_rows($result);
		
		echo "<table width=100% cellspacing=0 cellpadding=0 border=0>";
		echo "<tr><td style='padding-left:20px;padding-right:20px'>";

		echo "<table width=100% cellspacing=0 cellpadding=0 style='border:1px solid #c8c8c8'>";
		echo "<tr height=30px>";
		echo "<td width=200px bgcolor=#ebebeb align=center ><b><font color=blue>Rule Model</font></b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center ><b><font color=blue>Rule CMS</font></b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center ><b><font color=blue>Rule Version</font></b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center ><b>Filename</b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center ><b>File Version</b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center><b>UserId</b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center><b>Date</b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center><b></b></td>";
		echo "</tr>";
	
		$tag_left="<td align=center style='border:0px dotted #c8c8c8;padding-left:20px;padding-right:20px'>";
		$tag_right="</td>";

		if($Count == "0")
		{
			echo "<tr height=30px>";
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
		}

		while($row=mysqli_fetch_assoc($result))
		{
			echo "<tr height=30px>";
			echo $tag_left."<font color=blue>".$row[Rule_Model]."</font>".$tag_right;
			echo $tag_left."<font color=blue>".$row[Rule_Cms]."</font>".$tag_right;
			echo $tag_left."<font color=blue>".$row[Rule_Version]."</font>".$tag_right;
			echo $tag_left.$row[FileName].$tag_right;
			echo $tag_left.$row[FileVersion].$tag_right;
			echo $tag_left.$row[UserId].$tag_right;
			echo $tag_left.$row[UpdateDate].$tag_right;
			echo $tag_left;
?>
			<form action='filecancel.php?rule=on'  method=post>
			<input name="filename" type=hidden value='<?php echo $row[FileName] ?>'>
			<input name="model" type=hidden value='<?php echo $row[Rule_Model] ?>'>
			<input name="cancel" type="image" style="cursor:pointer" src='./img/btn_cancel_n.png' 
		onmouseover="this.src='./img/btn_cancel_h.png'" onmousedown="this.src='./img/btn_cancel_p.png'" onmouseout="this.src='./img/btn_cancel_n.png'">
			</form>

<?php
			echo $tag_right;

			echo "</tr>";
		}
		
		echo "</table>";
		echo "</td></tr></table>";
		mysqli_free_result($result);
	}
?>

<?php
	}
	else
		echo "<b>&nbsp;&nbsp;&nbsp; 1:N Disable 함, DMS 이용</b>";
?>
<table width=100% cellspacing=20px cellpadding=0 border=0>
<tr><td bgcolor="#f8dbdb" height=40px style="padding-left:20px;">
<b>1:1 업그레이드 예약 : Max( <?php echo $FTP_MAX_CLIENT; ?> ) : 모든 버전(V/C/T)이 등록 가능합니다.</b>
</td></tr>
</table>

<table cellspacing=0 cellpadding=0 border=0 style="padding:0 0 20px 20px">
<form action=fileupload.php  method=post enctype="multipart/form-data" onsubmit='return menumac_edit(this);'>

<tr>
<td colspan=2>
&nbsp;업그레이드 할 MAC : 
<input name="MAC" type=text value="<?php echo $_SESSION['select_mac']; ?>" maxlength=12>
<p>
</td>
</tr>

<tr>
<td>
<input name="upgrade" type="image" style="cursor:pointer" src='./img/btn_upgrade_run_n.png' 
		onmouseover="this.src='./img/btn_upgrade_run_h.png'" onmousedown="this.src='./img/btn_upgrade_run_p.png'" onmouseout="this.src='./img/btn_upgrade_run_n.png'">

</td>
<td style='padding-left:20px;'>
<input type=file name=upfile accept=".head">
</td>

</tr>
</table>
</form>

<?php

	$select_sql ="select * from Table_Update_List where Reader_Status='".$UPDATE_STATUS_PREADY."' or Reader_Status='".$UPDATE_STATUS_END_FAIL."' or Reader_Status='".$UPDATE_STATUS_START."'";
	$result=mysqli_query($Connection, $select_sql);
	if($result)
	{
		$Count=mysqli_num_rows($result);
		
		echo "<table width=100% cellspacing=0 cellpadding=0 border=0>";
		echo "<tr><td style='padding-left:20px;padding-right:20px'>";

		echo "<table width=100% cellspacing=0 cellpadding=0 style='border:1px solid #c8c8c8'>";
		echo "<tr height=30px>";
		echo "<td width=200px bgcolor=#ebebeb align=center ><b>MAC</b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center ><b>Model</b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center ><b>Filename</b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center ><b>File Version</b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center><b>UserId</b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center><b>Date</b></td>";
		echo "<td width=200px bgcolor=#ebebeb align=center><b></b></td>";
		echo "</tr>";

		$tag_left="<td align=center style='border:0px dotted #c8c8c8;padding-left:20px;padding-right:20px'>";
		$tag_right="</td>";

		if($Count == "0")
		{
			echo "<tr height=30px>";
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
			echo $tag_left."-".$tag_right;
		}

		while($row=mysqli_fetch_assoc($result))
		{
			echo "<tr height=30px>";
			echo $tag_left.$row[Reader_Conf_Mac].$tag_right;
			echo $tag_left.$row[Reader_Conf_Model].$tag_right;
			echo $tag_left.$row[FileName].$tag_right;
			echo $tag_left.$row[Reader_Conf_Version].$tag_right;
			echo $tag_left.$row[UserId].$tag_right;
			echo $tag_left.$row[UpdateDate].$tag_right;
			echo $tag_left;
?>
			<form action=filecancel.php  method=post>
			<input name="filename" type=hidden value='<?php echo $row[FileName] ?>'>
			<input name="mac" type=hidden value='<?php echo $row[Reader_Conf_Mac] ?>'>
			<input name="cancel" type="image" style="cursor:pointer" src='./img/btn_cancel_n.png' 
		onmouseover="this.src='./img/btn_cancel_h.png'" onmousedown="this.src='./img/btn_cancel_p.png'" onmouseout="this.src='./img/btn_cancel_n.png'">
			</form>

<?php
			echo $tag_right;

			echo "</tr>";
		}

		echo "</table>";
		echo "</td></tr></table>";
		
		mysqli_free_result($result);
	}
	mysqli_close($Connection);
	
?>

