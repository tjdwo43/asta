<?
	header("Content-type: text/html; charset=UTF-8");
	include "../inc/function.inc.php";

	

	$qry = " select namecard from env LIMIT 1; ";
	$res = db_query($qry);
	$rows = mysqli_num_rows($res);
	if ($rows) {
		$row = mysqli_fetch_array($res);
		$filename = $row[namecard];
	}
	else{
		$qry = " insert into env(isAdminID) values('master'); ";
		db_query($qry);
	}

	if(is_uploaded_file($_FILES["namecard"]["tmp_name"])){
		$dest = "/home/samba/namecard/".$_FILES["namecard"]["name"];
		$file_name=$_FILES["namecard"]["name"];
		$file_size=$_FILES["namecard"]["size"];

		if(!move_uploaded_file($_FILES["namecard"]["tmp_name"], $dest)){
			 popup_msg("파일업로드  실패!");
		}
		else{
			if($filename){
			   //화일 삭제하기
				$cmd="sudo rm  /home/samba/namecard/".$filename ;
				system($cmd);

				$cmd="sudo rm  /var/www/namecards/".$filename ;
				system($cmd);
			 }

			//화일 복사하기
			$cmd="sudo cp  /home/samba/namecard/".$file_name."  /var/www/namecards/" ;
			system($cmd);

			// 데이터베이스에 입력값을 수정한다.
			$qry=" update env set company='$_POST[company]',line_num='$_POST[line_num]',line_num2='$_POST[line_num2]',as_phone='$_POST[as_phone]' ,as_email='$_POST[as_email]',customer='$_POST[customer]',namecard='$file_name',filesize='$file_size',as_name='$_POST[as_name]',todo='$_POST[todo]' ,infostep='$_POST[infostep]', isAdminID = '$_POST[isAdminID]'; ";
			 db_query($qry);

			echo("<script language=\"javascript\">alert('수정하였습니다.');document.location.href='/main.php?viewMode=BOARD'</script>");	
		}
	}
	else if($_POST[delfile]=='yes' ){
		if($filename){
		   //화일 삭제하기
			$cmd="sudo rm  /home/samba/namecard/".$filename ;
			system($cmd);

			$cmd="sudo rm  /var/www/namecards/".$filename ;
			system($cmd);
		 }        

		// 데이터베이스에 입력값을 수정한다.
		$qry=" update env set company='$_POST[company]',line_num='$_POST[line_num]',line_num2='$_POST[line_num2]',as_phone='$_POST[as_phone]' ,as_email='$_POST[as_email]',customer='$_POST[customer]',namecard='',filesize=''  ,as_name='$_POST[as_name]',todo='$_POST[todo]',infostep='$_POST[infostep]', isAdminID = '$_POST[isAdminID]'; ";
		db_query($qry);

		echo("<script language=\"javascript\">alert('수정하였습니다.');document.location.href='/main.php?viewMode=BOARD'</script>");	

	}
	else{
		// 데이터베이스에 입력값을 수정한다.
		$qry=" update env set company='$_POST[company]',line_num='$_POST[line_num]',line_num2='$_POST[line_num2]',as_phone='$_POST[as_phone]' ,as_email='$_POST[as_email]',customer='$_POST[customer]' ,as_name='$_POST[as_name]',todo='$_POST[todo]'  ,infostep='$_POST[infostep]', isAdminID = '$_POST[isAdminID]'; ";
		db_query($qry);

		echo("<script language=\"javascript\">alert('수정하였습니다.'); document.location.href='/main.php?viewMode=BOARD'</script>");	
	}

	
?>
