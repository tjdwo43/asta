<?
	header("Content-type: text/html; charset=UTF-8");
	include "../inc/function.inc.php";
    

		$qry="SELECT * FROM board  where uid ='$_GET[uid]' ";

		$res = db_query($qry);
		$row =mysqli_fetch_array($res);

		$content=nl2br($row[content]);
		$content=strip_tags($content);

		$userfile = $row[userfile1];
		$filesize = $row[filesize1];
		$fileFullName = "/home/samba/board/".$userfile;
		$id = $row[id];

		if($id != $_GET[loginid]){

			    echo("<script language=\"javascript\">alert('작성자 본인만 수정할수있습니다!'); history.go(-1)</script>");	
		}

   	
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<!--
<link rel ="stylesheet" href="css/jquery-ui2.css">
<script src="/js/jquery-1.11.2.js"></script>
<script src="/js/jquery-ui_11.2.js"></script> -->

<!-- Bootstrap Core CSS -->
<link href="/css/bootstrap.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- Timeline CSS -->
<link href="/css/plugins/timeline.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="/css/sb-admin-2.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="/css/plugins/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="/images/favicon.ico" rel="shortcut icon"/>

<script language="javascript">
	function fileDownFun(url){
		document.location.href = "/fileDown.php?filepath=" + url;
	}
function Board_Modify(uid){
	var f=document.modifyform;
	f.uid.value=uid;
	f.submit();

}
</script>

<table class="table-responsive" >

	<form name="modifyform"  method="post" action="/board/board_modify.php"  enctype="multipart/form-data">
	<input type='hidden' name = "uid" >
			 <tr>
						<td style="padding:8px 0 5px 8px;" align="right">제 목</td>
						<td style="padding:6px 0 6px 8px;">
									   <input type="text" name="subject"  class="form-control2" size="90" value="<?=$row[subject]?>">
						</td>
				</tr>

				<tr>
						<td style="padding:8px 0 5px 8px;" align="right">내 용</td>
						<td style="padding:6px 0 6px 8px;">
						 <textarea name="content"  class="form-control2"  rows="15" ><?=$content?></textarea>
														</td>
				</tr>
		 
				<tr>
					<td  colspan="2"></td>
	<?if($row[userfile1]){?>
				<tr>
						<td style="padding:8px 0 5px 8px;" align="right"></td>
						<td style="padding:6px 0 6px 8px;"><font color='black'>
							   현재화일명:&nbsp;<?=$row[userfile1]?>&nbsp;&nbsp;(<?=number_format($row[filesize1])?>Byte)&nbsp;&nbsp; 삭제여부<input type="checkbox"  name='delfile' value='yes'><br/></font>대체할 파일등록<input type="file"  name="userfile1" maxlength="8" size="8" ></td>
														</td>
				</tr>
	<?}else{?>
				<tr>
						<td style="padding:8px 0 5px 8px;" align="right"></td>
						<td style="padding:6px 0 6px 8px;" ><font color='black'>
							   파일등록 </font><input type="file"  name="userfile1"   maxlength="8" size="8" ></td>
														</td>
				</tr>

	   <? } ?>

		</tr>
		<tr>
		  <td style="padding:10px 0 0 0;" align="right" colspan="2">
			<input type="button" value="목록" class='btn btn-primary' onClick="history.back()"; /> <input type="button" value="수정" class='btn btn-warning' onClick="Board_Modify('<?=$row[uid]?>')"; />
				</td>
		</tr>
	</form>
</table>

