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
	function String2Hex($string){
		$hex='';
		for ($i=0; $i < strlen($string); $i++){
				$hex .= dechex(ord($string[$i]));
		}
		return $hex;
	}

	if($_GET[rule] !="on")
	{
		$MAC =$_POST[MAC]; 
		if($MAC=="")
		{
			echo "<script type='text/javascript'>alert('MAC이 세팅되어 있지 않습니다');</script>";
			echo "<meta http-equiv='refresh' content='0; url=./main.php?menu=1'>";
			exit;
		}
	}
	   	
    $upfile_name=$_FILES['upfile']['name'];
    $upfile_tmp=$_FILES['upfile']['tmp_name'];

	if($upfile_name == "")
	{
		echo "<script type='text/javascript'>alert('업로드 파일을 선택해 주세요');history.go(-1);</script>";
		exit;
	}

	$upfile_ext=substr(strrchr($upfile_name,"."),1); //파일확장자를 구한다

	if($upfile_ext!="HEAD" && $upfile_ext!="head") //파일확장자를 체크하여 업로드를 제한한다
	{
		echo "<script type='text/javascript'>alert('파일 업로드가 제한된 파일입니다.');history.go(-1);</script>";
		exit;
	}					           

	$upfile_size = $_FILES['upfile']['size'];

	if($upfile_size > 20*1024*1024)
	{
		echo "<script type='text/javascript'>alert('파일 업로드 최대 크기는 20M 입니다.');history.go(-1);</script>";
		exit;
	}
	if($upfile_size < 72)
	{
		echo "<script type='text/javascript'>alert('파일 업로드 사이즈가 아닙니다');history.go(-1);</script>";
		exit;
	}
	$fp= fopen($upfile_tmp, 'r');
	$msg_magic = fread($fp,10);
	$msg_model = fread($fp,6);
	fread($fp,12+6);
	$msg_version = fread($fp,12);
	fclose($fp);
	$hex_magic =String2Hex($msg_magic);
	$hex_model =String2Hex($msg_model);
	
	if($hex_magic != $HEAD_MAGIC)
	{
		echo "<script type='text/javascript'>alert('올바른 헤드가 아닙니다');history.go(-1);</script>";
		exit;
	}

	if($hex_model != $HEAD_MODEL_IF1000
		&& $hex_model != $HEAD_MODEL_IF2000
		&& $hex_model != $HEAD_MODEL_IPG100
		&& $hex_model != $HEAD_MODEL_ACU100
		&& $hex_model != $HEAD_MODEL_OTR620
	)
	{
		echo "<script type='text/javascript'>alert('지원하지 않는 모델입니다');history.go(-1);</script>";
		exit;
	}

	//echo "버전: /".$msg_version."/<br>";
	//echo "모델명: ".$msg_model."<br>";
	//echo "업로드 파일명: ".$upfile_name."<br>";
	//echo "tmp 파일명: ".$upfile_tmp."<br>";
	//echo "확장자명: ".$upfile_ext."<br>";
	//echo "파일사이즈: ".$upfile_size."<br>"; 

	if($_GET[rule] =="on")
	{
		//echo "RULE ON<br>";
		echo "단말기 타입 :".$_POST[model]."<br>";
		echo "주장치 종류 :".$_POST[cms]."<br>";
		echo "버전 :".$_POST[version]."<br>";

		if($msg_model != $_POST[model])
		{
			echo "<script type='text/javascript'>alert('모델이 일치하지 않습니다');history.go(-1);</script>";
			exit;
		}
		if($msg_version[0] != "V")
		{
			echo "<script type='text/javascript'>alert('V 버전만올릴수 있습니다');history.go(-1);</script>";
			exit;
		}

		$target_file = $TARGET_DIR.$msg_model;
	}
	else
	{
		//echo "RULE OFF<br>";
		$target_file = $TARGET_DIR.$MAC;
	}

	//echo "타켓파일명: ".$target_file."<br>"; 
	$Connection = mysqli_connect($DB_HOST,$DB_USER,$DB_USER_PASS, $DB_NAME);
	if(!$Connection)
	{
		$error = mysqli_connect_error(); 
		$errno = mysqli_connect_errno(); 
		echo "$errno: $error\n";
		exit();
	}

	if($_GET[rule] !="on")
	{
		$limit_check_sql ="select * from Table_Update_List";
		$result=mysqli_query($Connection, $limit_check_sql);
		$Count=mysqli_num_rows($result);

		if(($Count + 1) >  $FTP_MAX_CLIENT)
		{
			mysqli_close($Connection);
			echo "<script type='text/javascript'>alert('예약 최대 갯수를 넘었습니다.');history.go(-1);</script>";
			exit;

		}
	}

	if (move_uploaded_file($upfile_tmp, $target_file))
	{
		echo "<font color=red>Upload Success!!!</font><br>";

		$FileName=$upfile_name;
		$UserId = $_SESSION['login_id'];

		if($_GET[rule] =="on")
		{
			$select_sql ="select * from Table_Update_Rule_List where Rule_Model='".$msg_model."'";
			$result=mysqli_query($Connection, $select_sql);
			if($result)
			{
				$RuleVersion = $_POST[version];
				if($RuleVersion == "")
					$RuleVersion = "-";
						
				$Count=mysqli_num_rows($result);
				if($Count == 1)
				{
					$select_sql ="select * from Table_Update_List where FileName='".$_POST[model]."'";
					$result=mysqli_query($Connection, $select_sql);
					if($result)
					{
						if(mysqli_num_rows($result)!="0")
						{
							mysqli_close($Connection);
							echo "<script type='text/javascript'>alert('업데이트 중입니다');history.go(-1);</script>";
							exit;
						}
					}


					echo "<font color=red>Update !!!</font><br>";
					$sql ="update Table_Update_Rule_List set Rule_Cms='".$_POST[cms]."', Rule_Version='".$RuleVersion."', FileName='".$FileName."', FileSize='".$upfile_size."', FileVersion='".$msg_version."', UserId='".$UserId."', UpdateDate=now() where Rule_Model='".$_POST[model]."'";
				}
				else
				{
					echo "<font color=red>Insert !!!</font><br>";
					$sql ="insert into Table_Update_Rule_List values('".$_POST[model]."','".$_POST[cms]."','".$RuleVersion."','".$FileName."','".$upfile_size."','".$msg_version."','".$UserId."', now())";		
				}	
				//echo $sql;
				$result=mysqli_query($Connection, $sql);
				if($result)
					echo "<font color=red>query Success!!!</font><br>";

			}
		}
		else
		{
			$select_sql ="select * from Table_Update_List where Reader_Conf_Mac='".$MAC."'";
			$result=mysqli_query($Connection, $select_sql);
			if($result)
			{
				$Reader_Conf_Mac = $MAC;
				$Count=mysqli_num_rows($result);
				if($Count == 1)
				{
					$row=mysqli_fetch_assoc($result);
					mysqli_free_result($result);
					if($row[Reader_Status] != $UPDATE_STATUS_PREADY && $row[Reader_Status] != $UPDATE_STATUS_UPDATE)
					{
						mysqli_close($Connection);
						echo "<script type='text/javascript'>alert('업데이트 중입니다');history.go(-1);</script>";
						exit;	
					}

					echo "<font color=red>Update !!!</font><br>";
					$sql ="update Table_Update_List set Reader_Conf_Model='".$msg_model."', Reader_Conf_Version='".$msg_version."', Reader_Status='".$UPDATE_STATUS_PREADY."', FileName='".$FileName."', FileSize='".$upfile_size."', UserId='".$UserId."', UpdateDate=now() where Reader_Conf_Mac='".$Reader_Conf_Mac."'";
				}
				else
				{
					echo "<font color=red>Insert !!!</font><br>";
					$sql ="insert into Table_Update_List values('".$Reader_Conf_Mac."','".$msg_model."','".$msg_version."','".$UPDATE_STATUS_PREADY."','".$FileName."','".$upfile_size."','".$UserId."', now())";		
				}

				$result=mysqli_query($Connection, $sql);
				if($result)
					echo "<font color=red>query Success!!!</font><br>";
			}

			$insert_sql = "insert into Table_History_Update(Reader_Conf_Mac, Reader_Conf_Model, Reader_Conf_Name, Reader_Conf_Version, Reader_Status, Fail_Reason, FileName, UserId, UpdateDate) values('".$MAC."','".$msg_model."', '-', '-','".$UPDATE_STATUS_PREADY."', '-', '".$FileName."','".$UserId."', now())";
			$result=mysqli_query($Connection, $insert_sql);
			if($result)
				echo "<font color=red>history query Success!!!</font><br>";
		}
	}
	else
	{
		echo "<font color=red>Upload Fail!!!</font>";
	}


	mysqli_close($Connection);
	echo "<meta http-equiv='refresh' content='0; url=./main.php?menu=3'>";
	exit;

?>
