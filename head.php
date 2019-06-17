<?php  session_start(); ?>
<?php
	if( $_SESSION['login_id'] =='')
	{
		echo "<meta http-equiv='refresh' content='0; url=./index.php'>";
		exit;
	}
	include "db.php";
?>
<html>
<head>
<title> Welcome to <?php echo $_SESSION['login_id'] ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<style type="text/css">
	body{
		margin: 0;
		padding: 0;
		font-family:'돋움';
	}

   a{
   	text-decoration:none;
   	color: #000;
   }

	input.mac_box{
		border: 1px solid #bcbcbc;
		height:23px;
		width:220px;
		font-size:22px;
	}


   table{
		font-size:12px;
		font-family:'돋움';
   }
</style>
<SCRIPT type="text/javascript">
function menumac_edit(f)
{
        if (!f.MAC.value)
        {
        	alert('변경할 MAC을 입력하세요');
            f.MAC.focus();
            return false;
        }
		if(f.MAC.value.length != 12)
		{
        	alert('12자리 MAC을 입력하세요');
            f.MAC.focus();
            return false;
		}

		f.MAC.value=f.MAC.value.toUpperCase();

		var regex=/[0-9A-F]{12}/;
		if(regex.test(f.MAC.value))
			return true;
		else
	    {
			alert('올바른 MAC이 아닙니다.');
            f.MAC.focus();
            return false;
		}
}
function menumac_check(f)
{
        if (!f.MAC.value)
        {
            return true;
        }

		if(f.MAC.value.length != 12)
		{
        	alert('12자리 MAC을 입력하세요');
            f.MAC.focus();
            return false;
		}

		f.MAC.value=f.MAC.value.toUpperCase();

		var regex=/[0-9A-F]{12}/;
		if(regex.test(f.MAC.value))
			return true;
		else
	    {
			alert('올바른 MAC이 아닙니다.');
			f.MAC.value="";
            f.MAC.focus();
            return false;
		}
}

function status_view_submit(index)
{
	if(index == 1)
		document.status_view.action="excel_save.php";
	else if(index == 3)
		document.status_view.action="excel_save_history.php";
	else
		document.status_view.action="main.php?menu=2&sub=1";

	document.status_view.submit();
}
<?php
	if($_GET[menu] == "2"  $_GET[sub] == "")
		echo 'setTimeout("location.reload()",3000)';
?>
</SCRIPT>
</head>
<body>
<!-- top  -->
<table width=100% cellspacing=0 cellpadding=0 border=0 background="./img/top_bg.png">
<form action=logout.php  method=post>
<tr height=54px>
<td style="padding-left:20px" align=left width=332px><img src="./img/program_name2.png"></td>
<td align=left style="padding-left:15px" width=60px><font size=2 color=red><?php echo $VERSION; ?></font></td>

<td align=right>
<b><?php
	if($_GET[menu] == "2"  $_GET[sub] == "")
	{
		date_default_timezone_set('Asia/Seoul');
		echo date("Y-m-d H:i:s");
	}
	?>
</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=red><?php echo $_SESSION['login_id']."(".$_SERVER['REMOTE_ADDR'].")"; ?></font>님 환영합니다.
</td>

<td style="padding-right:20px;padding-left:10px" align=right width=62px>
<input name="logout" type="image" style="cursor:pointer" src='./img/btn_logout_n.png'
		onmouseover="this.src='./img/btn_logout_h.png'" onmousedown="this.src='./img/btn_logout_p.png'" onmouseout="this.src='./img/btn_logout_n.png'">
</td>
</tr>

<tr height=6px bgcolor="#d83939">
<td colspan=4></td></tr>
</table>
</form>



<!-- left  -->
<table width=100% height=100% cellspacing=0 cellpadding=0 border=0 style="table-layout:fixed;" >
<tr>
<td width=264px bgcolor="#f1f1f1" valign=top background="./img/menu_bg.png">

	<table width=100% height=100% cellspacing=0 cellpadding=0 border=0>
	<tr valign=top height=50px>
	<td>
		<table width=100% height=100% cellspacing=0 cellpadding=0 border=0>
		<tr>
		<td align=center style="padding-left:5px;padding-right:5px;">
		<font style="font-size:14px;font-family:돋움;">Mac&nbsp;&nbsp; <?php echo "<b><input type=text value='".$_SESSION['view_mac']."' disabled></b>";?> </font>
		</td>
		</tr>
		</table>

	</td></tr>
	<tr valign=top><td align=right>
		<p>&nbsp;
		<table width=100% cellspacing=0 cellpadding=0 border=0>
		<?php
			$TAG_SETTING="<tr><td valign=center height=48px><a href='main.php?menu=1' style=font-size:16px;padding-left:45px;>단말기관리</a></td></tr>";
			$TAG_STATUS="<tr><td valign=center height=48px><a href='main.php?menu=2' style=font-size:16px;padding-left:45px;>상태조회</a></td></tr>";
			$TAG_UPGRADE="<tr><td valign=center height=48px><a href='main.php?menu=3' style=font-size:16px;padding-left:45px;>업그레이드</a></td></tr>";
			$TAG_HISTORY="<tr><td valign=center height=48px><a href='main.php?menu=4&sel=0' style=font-size:16px;padding-left:45px;>통계관리</a></td></tr>";
			$TAG_ADMIN="<tr><td valign=center height=48px><a href='main.php?menu=5&sel=0' style=font-size:16px;padding-left:45px;>관리자메뉴</a></td></tr>";

			if($_GET[menu] == "1") // 맥 변경
			{
				echo '<tr><td align=right>';
				echo '<img src="./img/btn_menu_setting.png">';
				echo "</td></tr>";

				echo $TAG_STATUS;
				echo $TAG_UPGRADE;
				echo $TAG_HISTORY;
				echo $TAG_ADMIN;
			}
			else if($_GET[menu] == "2")
			{
				echo $TAG_SETTING;

				echo '<tr><td align=right>';
				echo '<a href="main.php?menu=2"><img src="./img/btn_menu_status1.png"><a>';
				echo '</td></tr>';

				echo $TAG_UPGRADE;
				echo $TAG_HISTORY;
				echo $TAG_ADMIN;
			}
			else if($_GET[menu] == "3")
			{
				echo $TAG_SETTING;
				echo $TAG_STATUS;

				echo '<tr><td align=right>';
				echo '<img src="./img/btn_menu_upgrade.png">';
				echo '</td></tr>';

				echo $TAG_HISTORY;
				echo $TAG_ADMIN;
			}
			else if($_GET[menu] == "4")
			{
				echo $TAG_SETTING;
				echo $TAG_STATUS;
				echo $TAG_UPGRADE;

				echo '<tr><td align=right>';
				echo '<img src="./img/btn_menu_history.png">';
				echo '</td></tr>';
				echo $TAG_ADMIN;

			}
			else if($_GET[menu] == "5")
			{
				echo $TAG_SETTING;
				echo $TAG_STATUS;
				echo $TAG_UPGRADE;
				echo $TAG_HISTORY;

				echo '<tr><td align=right>';
				echo '<img src="./img/btn_menu_admin.png">';
				echo '</td></tr>';
			}
			else
			{
				echo '<tr><td align=right>';
				echo '<img src="./img/btn_menu_setting.png">';
				echo "</td></tr>";

				echo $TAG_STATUS;
				echo $TAG_UPGRADE;
				echo $TAG_HISTORY;
				echo $TAG_ADMIN;
			}
		?>
		</table>
	</td></tr>
<?php

	if($_GET[menu] == "2"  $_GET[sub] == "")
	{
?>
		<tr valign=top><td align=center>

		<table width=230px height=414px cellspacing=0 cellpadding=0 border=0 background='./img/bg_guide.png'>
		<tr><td colspan=2 height=30%></td></tr>

		<tr><td width=40% align=center> <img src='./img/icon_stand_by.png'> </td><td>작업없음</td></tr>
		<tr><td width=40% align=center> <img src='./img/icon_ready_to_upgrade.png'></td><td> 업그레이드 예약됨</td></tr>
		<tr><td width=40% align=center> <img src='./img/icon_downloading.png'></td><td> 다운로드 진행중 </td></tr>
		<tr><td width=40% align=center> <img src='./img/icon_run_upgrade.png'></td><td> 업그레이드 진행중 </td></tr>
		<tr><td width=40% align=center> <img src='./img/icon_success.png'></td><td> 업그레이드 성공 </td></tr>
		<tr><td width=40% align=center> <img src='./img/icon_upgrade_fail.png'></td><td> 업그레이드 실패 </td></tr>
		</td></tr>
		<tr><td colspan=2 height=10%></td></tr>
		</table>

		</tr></td>

		<tr height=10%><td align=center>
		</td></tr>
<?php
	}
?>
	</table>

</td>

<td valign=top >
<!-- main  -->
