<?
	header("Content-type: text/html; charset=UTF-8");
	include "../inc/function.inc.php";
	

	$today = date("Y-m-d");
	if(is_uploaded_file($_FILES["upload_file"]["tmp_name"])){

		$dest = "/home/samba/__DBFiles/scanDB/".$_FILES["upload_file"]["name"];
		$file_name=$_FILES["upload_file"]["name"];
		$file_size=$_FILES["upload_file"]["size"];

		//$tmpRanSu = random(10, 10);
		//$realFileName = $tmpRanSu.$file_name;

        //$_FILES["upload_file"]["name"]=$realFileName;
        //$file_name=$_FILES["upload_file"]["name"];

		$file_date = date('Y-m-d H:i:s') ;
		$file_type = filetype($file_name);
		$file_ext = fileExt(getbasename($file_name));
	
		if(!move_uploaded_file($_FILES["upload_file"]["tmp_name"], $dest)){
			popup_msg( "파일을 업로드 하는데 실패 했습니다2.");
		}
		else{
			// 데이터베이스에 입력값을 삽입한다.
			if($_POST[viewMode]=='OPEN'){
				 $qry = " insert  into tblAutoSaveFiles set authid='openfile', filename='$file_name',filenameDisp='$a_file',filesize='$file_size', receive_date='$file_date', type='$file_type', ext='$file_ext', mimie='$file_mime', fromdir='/home/samba/__DBFiles/scanDB/' ,todir='/home/samba/__DBFiles/scanDB/',class='OPEN' ";

		    	db_query($qry);
				echo("<script language=\"javascript\">alert('업로드 하였습니다.');document.location.href='/open/open.php?viewMode=$_POST[viewMode]'</script>");	
			}
			else if($_POST[viewMode]=='MYSCAN'){
				$qry = " insert  into tblAutoSaveFiles set authid='$user_info[MEMID]', filename='$file_name',filenameDisp='$a_file',filesize='$file_size', receive_date='$file_date', type='$file_type', ext='$file_ext', mimie='$file_mime', fromdir='/home/samba/__DBFiles/scanDB/' ,todir='/home/samba/__DBFiles/scanDB/',class='MYSCAN' ";

				db_query($qry);
				echo("<script language=\"javascript\">alert('업로드 하였습니다.');document.location.href='/scan/scan.php?viewMode=$_POST[viewMode]'</script>");
			}
			else if($_POST[viewMode]=='SCAN'){
				$qry = " insert  into tblAutoSaveFiles set authid='scanall', filename='$file_name',filenameDisp='$a_file',filesize='$file_size', receive_date='$file_date', type='$file_type', ext='$file_ext', mimie='$file_mime', fromdir='/home/samba/__DBFiles/scanDB/' ,todir='/home/samba/__DBFiles/scanDB/',class='SCAN' ";

				db_query($qry);
				echo("<script language=\"javascript\">alert('업로드 하였습니다.');document.location.href='/scan/scan.php?viewMode=$_POST[viewMode]'</script>");
			}
		}
	}
	else{
		popup_msg( "파일을 업로드 하는데 실패 했습니다1.");
	}

	
?>
