<html>
<head>
<title> 로그인 </title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<style type="text/css">

	input.login_box{
		height:20px;
		width:140px;
	}

 	body{
		margin: 0;
		padding: 0;
		font-family:'돋움';
	}
	
</style>

<script language='javascript'>
function menulog_check(f)
{
        if (!f.MB_ID.value)
        {
        	alert('아이디를 입력하세요.');
            f.MB_ID.focus();
            return false;
        }
		else if (!f.MB_PW.value)
        {
            alert('비밀번호를 입력하세요.');
            f.MB_PW.focus();
            return false;
        }
		else 
			return true;
}
</script>

</head>
<body style="background: url('./img/login/login_bg.png');background-size:cover;">


<table width=100% height=100% cellspacing=0 cellpadding=0 border=0>
<tr><td valign=middle>

<table style="margin:auto;" width=405px height=217px cellspacing=0 cellpadding=0 border=0 background="./img/login/login_form.png">
<form action=login.php  method=post onsubmit='return menulog_check(this);'>
<tr>
<td colspan=4 height=4%></td>
</tr>

<tr>
<td align=center colspan=4 height=32%> <img src="./img/program_name2.png"></td>
</tr>

<tr>
<td width=9%></td><td>아이디</td><td width=30%><input name="MB_ID" type=text class="login_box"> </td><td rowspan=2 valign=center> 
<input name="login" type="image" style="cursor:pointer" src='./img/login/login_btn_n.png' 
		onmouseover="this.src='./img/login/login_btn_h.png'" onmousedown="this.src='./img/login/login_btn_p.png'" onmouseout="this.src='./img/login/login_btn_n.png'"></td>
</tr>

<tr>
<td width=9%></td><td>패스워드</td><td><input name="MB_PW" type=password class="login_box"> </td>
</tr>

<tr>
<td colspan=4 align=right height=24% style="padding-right:30px"><font size="2"> Copyright(C) Sunghyun system All right reserved.</font></td>
</tr>

<tr>
<td colspan=4 height=4%></td>
</tr>

</table>
</form>

</td></tr>
</table>

</body>
</html>
