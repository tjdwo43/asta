<?
include $_SERVER['DOCUMENT_ROOT']."/inc/function.inc.php";
include $_SERVER['DOCUMENT_ROOT']."/inc/auth.inc.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/files.inc.php";
db_connect() ;

if($_POST[mode] == 'update_memo') {
	if($_POST[memo]){
		$memoSection = " memo = '" . $_POST[memo] . "' ";
	}
	else{
		$memoSection = " memo = memo";
	}

	if($_POST[receiver]){
		$receiverSection = ", receiver = '" . $_POST[receiver] . "' ";
	}
	else{
		$receiverSection = ", receiver = receiver ";
	}

	if($_POST[filenameDisp]){
		$filenameDispSection = ", filenameDisp = '" . $_POST[filenameDisp] . "' ";
	}
	else{
		$filenameDispSection = ", filenameDisp = filenameDisp ";
	}

	$qry = "update  tblAutoSaveFiles set " . $memoSection . $receiverSection . $filenameDispSection . " where seq='$_POST[seq]' "; 

	//$qry ="update  tblAutoSaveFiles set memo='$_POST[memo]' , receiver='$_POST[receiver]',filenameDisp='$_POST[filenameDisp]' where seq='$_POST[seq]' ";
	db_query($qry);

	echo "Y";

}else if($_POST[mode] == 'update_name') {
	//원소유자 여부확인

				$qry = "select id from namebook where seq='$_POST[seq]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);
				$id = $row[id];

				if($id == $user_info[MEMID]){
					$qry ="update  namebook set name='$_POST[name]' ,com='$_POST[com]' ,position='$_POST[position]' ,phone='$_POST[phone]' ,memo='$_POST[memo]' ,email='$_POST[email]' ,fax_num='$_POST[fax_num]' , open='$_POST[open]' ,mphone='$_POST[mphone]' where seq='$_POST[seq]' ";
					db_query($qry);
				}else{
                    echo "N";
					exit;
				}

				echo "Y";

}else if($_POST[mode] == 'myfax') {
	//My팩스로  전달
	$fromId = $_POST[fromId];
	//$viewfs = $_POST[viewfs];
	$seq = $_POST[seq];
	$seq = explode(',',$seq);
	$mid = explode(',',$mid);
	foreach($mid as $val){
		$auth = explode(':',$val);
		if($auth[0]=='D'){
			$authEFD[] = $auth[2];
		}else{
			$query = "SELECT mSeq FROM tblPartMember where pIdx=".$auth[1]."";
			$res = db_query($query);
			while($row = db_fetch_array($res)){
				$authEFD[] = $row['mSeq'];
			}
		}
	}
		$authEFD = array_unique($authEFD);
		/*
		$qry= "select id from member  where seq='$mid[0]' ";
		$res = db_query($qry);
		$row =mysqli_fetch_array($res);
		$id = $row[id];
		*/
		$sql= "select name from member  where seq='$fromId' ";
		$res1 = db_query($sql);
		$row1 = db_fetch_array($res1);
		$name = $row1[name];

		for($i=0; $i< count($seq); $i++){
				$seqExp = explode(":", $seq[$i]);
				$sql = "SELECT * FROM tblAutoSaveFiles WHERE seq = ".$seqExp[0]."";
				$res = db_query( $sql );
				$row = db_fetch_array( $res );
			if(substr($seqExp[1],0,3) == 'FAX'){
		//		$qry1 ="update  tblAutoSaveFiles set authid='".$id."' , fromName='".$name."' , class='MYFAX', mayfaxCount = 'Y'  where seq=".$seq[$i];
				$cls='MYFAX';
			}else if(substr($seqExp[1],0,4) == 'SCAN' || substr($seqExp[1],0,2) == "re"){
		//		$qry1 ="update  tblAutoSaveFiles set authid='".$id."' , fromName='".$name."' , class='MYSCAN', mayfaxCount = 'Y'  where seq='$seq[$i]' ";
				$cls='MYSCAN';
			}
			foreach($authEFD as $val){
			$qryCopy="insert into tblAutoSaveFiles (authid,class,filename,filenameDisp,filesize,
									receive_date,type,ext,mimie,fromdir,todir,memo
									,receiver,regDate,deleteIdx,deleteDate,
									deleteMemIdx,fromName,mayfaxCount,fwDate
									) values (
									'".getSeqToId($val)."',
									'".$cls."',
									'".$row['filename']."',
									'".$row['filenameDisp']."',
									".$row['filesize'].",
									'".$row['receive_date']."',
									'".$row['type']."',
									'".$row['ext']."',
									'".$row['mimie']."',
									'".$row['fromdir']."',
									'".$row['todir']."',
									'".$row['memo']."',
									'".$row['receiver']."',
									now(),
									'".$row['deleteIdx']."',
									'".$row['deleteDate']."',
									".(($row['deleteMemIdx'])?$row['deleteMemIdx']:0).",
									'".$name."',
									'Y',NOW())";
				db_query($qryCopy);
			}
				db_query($qry1);
				$fullfile = $row['todir'].$row['filename'];
				$file_ext		= fileExt(getbasename($fullfile));
				$filenameDisp	= ( trim($row['memo']) )? trim($row['memo']).".". $file_ext : trim($row['filenameDisp']) ;

				if(!is_file($fullfile)){
					echo "
						<script>
						alert('".getLabel("/var/www/htm/inc_Process.php?alert1", "존재 하지 않는 파일입니다.")."');
						opener.location.reload();
						window.close();
						</script>";
					exit; 
				}

		$fax_DBPath = $row['todir'];
		if (!file_exists($fax_DBPath)){  //없으면 폴더 새로만들어주기~
			mkdir($fax_DBPath, 0777, true); 
		}
		$realFileName = md5( time()."_".rand( 1, 1000000 ) ).".".$file_ext;
		$dest = $fax_DBPath. "/" .$realFileName;
		copy($fullfile,$dest);
		}
		$result = $viewfs;
		echo $result;

}else if($_POST[mode] == 'delete_name') {

				$qry= "select id from namebook where seq='$_POST[seq]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);
				$id = $row[id];

				if($id == $user_info[MEMID]){
					$qry ="delete from namebook  where seq='$_POST[seq]' ";
					db_query($qry);
				}else{
                    echo "N";
					exit;
				}

				echo "Y";

}else if($_POST[mode] == 'delete_check') {
//원소유자 여부확인

				$qry= "select todir,filename,authid from tblAutoSaveFiles where seq='$_POST[seq]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);
				$filedir = $row[0];
				$filename = $row[1];
				$authid = $row[2];

				
				if($authid==$user_info[MEMID]){
						echo "Y";
		    	}else{
						echo "N";
				}
}else if($_POST[mode] == 'delete_file') {

				$qry= "select todir,filename,authid from tblAutoSaveFiles where seq='$_POST[seq]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);
				$filedir = $row[0];
				$filename = $row[1];
				$authid = $row[2];

				
				if($authid==$user_info[MEMID]){
					if (str_replace("/", "", $filedir) != "" && str_replace("/", "", $filename) != "") {
					    //DB 삭제하기
						$qry ="delete from tblAutoSaveFiles where seq='$_POST[seq]' ";
						db_query($qry);

						$qry ="delete from tblAutoSaveFileAuth  where seq='$_POST[seq]' ";
						db_query($qry);

					   //화일 삭제하기
						$cmd="sudo rm ".$filedir.$filename ;
						system($cmd);

						echo "Y";
					}
		    	}else{
					    //readID 삭제하기
						$qry ="delete from tblAutoSaveFileAuth  where seq='$_POST[seq]' and readID='$user_info[MEMID]' ";
						db_query($qry);

						echo "Y";
				}
}else if($_POST[mode] == 'delete_open') {
				$qry= "select todir,filename,authid from tblAutoSaveFiles where seq='$_POST[seq]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);
				$filedir = $row[0];
				$filename = $row[1];
				$authid = $row[2];

				if (str_replace("/", "", $filedir) != "" && str_replace("/", "", $filename) != "") {

				    //readID 삭제하기
					$qry ="delete from tblAutoSaveFiles  where seq='$_POST[seq]' and authID='openfile' ";
					db_query($qry);

					//화일 삭제하기
					$cmd="sudo rm ".$filedir.$filename ;
					system($cmd);
				}

				echo "Y";
				
}else if($_POST[mode] == 'delete_top') {
	//공용FAX, 공용SCAN 에서 삭제
	$seq = $_POST[seq];
	$seq = explode(',',$seq);
	if($deleteMode != null){
		for($i=0; $i< count($seq); $i++){
			$qry= "select * from tblAutoSaveFiles where seq='$seq[$i]' ";
			$res = db_query($qry);
			$row = db_fetch_array($res);
			$filedir = $row[todir];
			$filename = $row[filename];
			$authid = $row[authid];
			
			if (str_replace("/", "", $filedir) != "" && str_replace("/", "", $filename) != "") {
				$qry ="UPDATE tblAutoSaveFiles SET deleteIdx = '".$user_info[MEMNAME]."', deleteMemIdx = '".$deleteMode."' , deleteDate = NOW() where seq='$seq[$i]' ";
				db_query($qry);
			}
		}
		echo "Y";
	}else{
		//FAX, SCAN 관리자에서 삭제
		$seq = $_POST['seq'];
		for($i=0; $i< count($seq); $i++){
			$qry= "select * from tblAutoSaveFiles where seq='$seq[$i]' ";
			$res = db_query($qry);
			$row = db_fetch_array($res);
			$filedir = $row[todir];
			$filename = $row[filename];
			$authid = $row[authid];
			//DB 삭제하기
			if (str_replace("/", "", $filedir) != "" && str_replace("/", "", $filename) != "") {
				$qry ="delete from tblAutoSaveFiles where seq='$seq[$i]' ";
				db_query($qry);

				$qry ="delete from tblAutoSaveFileAuth  where seq='$seq[$i]' ";
				db_query($qry);

				//화일 삭제하기
				$cmd="sudo rm ".$filedir.$filename;
				system($cmd);
			}
		}
		echo "<script>document.location.href=\"/faxall/deleteList.php?viewMode='".$_POST[viewMode]."'\"</script>";
	}
	
}else if($_POST[mode] == 'move_myfax') {
				$qry ="update  tblAutoSaveFiles set authid='".$user_info[MEMID]."' , class='MYFAX'  where seq='$_POST[seq]' ";
				db_query($qry);
				echo "Y";
}else if($_POST[mode] == 'move_open') {
				$qry ="update  tblAutoSaveFiles set authid='openfile' , class='OPEN'  where seq='$_POST[seq]' ";
				db_query($qry);
				echo "Y";
}else if($_POST[mode] == 'move_myscan') {
				$qry ="update  tblAutoSaveFiles set authid='".$user_info[MEMID]."' , class='MYSCAN'  where seq='$_POST[seq]' ";
				db_query($qry);
				echo "Y";

}else if($_POST[mode] == 'move_fax') {

				$qry ="update  tblAutoSaveFiles set authid='faxall' , class='FAX'  where seq='$_POST[seq]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'move_scan') {

				$qry ="update  tblAutoSaveFiles set authid='scanall' , class='SCAN'  where seq='$_POST[seq]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'share_save') {


				$chked_val =explode("," ,$_POST[chked_val]);  

			 if($_POST[add] =='N'){
        		$qry = " delete from tblAutoSaveFileAuth where seq='$_POST[seq]' ";
				db_query($qry);
			 }
				
				if(count($chked_val)>0 && $chked_val[0]){
						for($i=0;$i<count($chked_val);$i++){
								$qry = " insert into tblAutoSaveFileAuth set readID='$chked_val[$i]',seq='$_POST[seq]' ";
								db_query($qry);
						}
				}


	echo "Y";

}else if($_POST[mode] == 'env_set') {

			$qry=" update env set company='$_POST[company]',line_num='$_POST[line_num]',line_num2='$_POST[line_num2]',as_phone='$_POST[as_phone]' ,as_email='$_POST[as_email]',customer='$_POST[customer]' ";

			db_query($qry);
		
	echo "Y";

}else if($_POST[mode] == 'copy_fax') {

                $qry ="select * from tblAutoSaveFiles where  seq='$_POST[seq]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);


				$qry ="insert into  tblAutoSaveFiles set authid='$user_info[MEMID]',class='MYFAX',filename='$row[filename]',filesize='$row[filesize]',receive_date='$row[receive_date]',type='$row[type]',ext='$row[ext]',mimie='$row[mimie]',fromdir='$row[fromdir]',todir='$row[todir]',memo='$row[memo]',receiver='$row[receiver]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'copy_scan') {

                $qry ="select * from tblAutoSaveFiles where  seq='$_POST[seq]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);


				$qry ="insert into  tblAutoSaveFiles set authid='$user_info[MEMID]',class='MYSCAN',filename='$row[filename]',filesize='$row[filesize]',receive_date='$row[receive_date]',type='$row[type]',ext='$row[ext]',mimie='$row[mimie]',fromdir='$row[fromdir]',todir='$row[todir]',memo='$row[memo]',receiver='$row[receiver]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'fax_alert') {

          	$cmd="du -sh /home/samba/faxall/fax/";
	        $arr = exec($cmd);

			for($i=0;$i<10;$i++){
					$str .= $arr[$i];
			}

			$pos=strpos($str,'K');

			$value = substr($str,0,3);

			if($value>4) echo 'Y';
			else  echo 'N';

}else if($_POST[mode] == 'driver_delete') {
//드라이버 삭제

				$qry= "select * from driverfile where uid='$_POST[seq]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);
				$filename = $row[userfile1];

				if (str_replace("/", "", $filename) != "") {
					//DB 삭제하기
					$qry ="delete from driverfile where uid='$_POST[seq]' ";
					db_query($qry);
	
					//화일 삭제하기
					$cmd="sudo rm  /home/samba/driver/".$filename ;
					system($cmd);
				}

			   echo "Y";
	
}else if($_POST[mode] == 'board_delete') {
//게시판 삭제
   
				$qry = "select uid, id, b_ref, userfile1 from board where uid='". trim($uid)."' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);
				$filename = $row[userfile1];
                $id=$row[id];

				$groupQue = "
							SELECT
								uid, b_ref, brd_relevel, brd_restep
							FROM board 
							WHERE b_ref > 0 AND uid IS NOT NULL AND b_ref = ". trim($row['b_ref']) ."
							ORDER BY b_ref DESC, brd_restep ASC, reg_date DESC
					";
				$groupres = db_query($groupQue);
				$groupLevelChk = array();
				$gi = 0 ;
				while( $grouprow = db_fetch_array($groupres) ) {
					$groupLevelChk[$gi] = $grouprow['brd_relevel'] ;
					if ( $grouprow['uid'] == $_POST[uid] ) $nowLevelNum = $gi;
					$gi ++ ;
				}

				if ( $groupLevelChk[$nowLevelNum] < $groupLevelChk[$nowLevelNum+1]  ) {
					echo getLabel("/var/www/htm/inc_Process.php?err1","하위 답글이 있으면 삭제할 수 없습니다.");
					exit;
				}

				if($id !=$user_info[MEMID] && $user_info[MEMID] !=$user_info["ISADMINYN"]) {				
						echo 'noid';
						exit;
				}

				//DB 삭제하기 (댓글 포함)
				$qry ="delete from board where uid ='". $_POST['uid'] ."' or cmt_uid = '". $_POST['uid'] ."' ";
				db_query($qry);

				//기존 첨부파일 삭제
                if (str_replace("/", "", $filename) != "") {
					//화일 삭제하기
					$cmd="sudo rm  /home/samba/board/".$filename ;
					exec($cmd);
				}

				//멀티플 첨부파일 삭제
				$qry ="delete from tblFilesMap where document='board' and document_idx=".$_POST['uid']." ";
				db_query($qry);

				//
				$sql = "DELETE FROM tblCategoryBoard WHERE document_idx = ".$_POST['uid']." ";
				db_query( $sql );
			
				// 권한 삭제
				$auth = new Auth();
				$auth -> del( Array( 'clsNum' => 2, 'idx' => $_POST['uid'] ) );

				echo "Y";

}else if($_POST[mode] == 'docu_delete') {
// 삭제
   
			$qry = "select * from docu where uid='$_POST[uid]' ";
			$res = db_query($qry);
			$row = db_fetch_array($res);
			$filename = $row[userfile1];
            $id=$row[id];

			if($id !=$user_info[MEMID] && $user_info[MEMID] !=$user_info["ISADMINYN"]) {
			
					echo 'noid';
					exit;

			}

			if (str_replace("/", "", $filename) != "") {
				//DB 삭제하기
				$qry ="delete from docu where b_ref='$row[b_ref]' ";
				db_query($qry);
	
			   //화일 삭제하기
				$cmd="sudo rm  /home/samba/document/".$filename ;
				exec($cmd);

				$sql = "DELETE FROM tblCategoryDocu WHERE document_idx = ".$_POST['uid']." ";
				db_query( $sql );
			
				// 권한 삭제
				$auth = new Auth();
				$auth -> del( Array( 'clsNum' => 3, 'idx' => $_POST['uid'] ) );
            }
			echo "Y";
	
}else if($_POST[mode] == 'order_delete') {
//업무협조 삭제
   
				$qry = "select * from orders where uid='$_POST[uid]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);
				$filename = $row[userfile1];
                $id=$row[id];

				if($id !=$user_info[MEMID] && $user_info[MEMID] !=$user_info["ISADMINYN"]) {
				
						echo 'noid';
						exit;

				}

				if (str_replace("/", "", $filename) != "") {
					//DB 삭제하기
					$qry ="delete from orders where b_ref='$row[b_ref]' ";
					db_query($qry);
	
					//수신자 삭제하기
					$qry ="delete from OrderAuth  where uid='$_POST[uid]' ";
					db_query($qry);
	
				   //화일 삭제하기
					$cmd="sudo rm  /home/samba/orders/".$filename ;
					exec($cmd);
					$sql = "DELETE FROM tblCategoryOrders WHERE document_idx = ".$_POST['uid']." ";
					db_query( $sql );
				
					// 권한 삭제
					$auth = new Auth();
					$auth -> del( Array( 'clsNum' => 1, 'idx' => $_POST['uid'] ) );
				}

				echo "Y";
	
}else if($_POST[mode] == 'fax_update') {

				$qry ="update  fax set fax_num='$_POST[fax_num]' , fax_busu='$_POST[fax_busu]', sort='$_POST[fax_sort]' where seq='$_POST[seq]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'FaxAdd') {

				$qry = "select IFNULL(max(num), 0)+1 as num from fax";
                $res = db_query($qry);
                $row = db_fetch_array($res);
			
				if($row[num] == 1){
					$fax_folder="faxall";
				}
				else{
					$fax_folder="faxall".$row[num];
				}

				$is_rassberrypi = false;
				exec( 'cat /etc/issue', $output );
				$result_issue = implode( "", $output );
				if( preg_match( '/Raspbian/i', $result_issue ) ) {
					$is_rassberrypi = true;
				}

                $P_DIR = "/home/control";
				$H_DIR = "/home/samba";

               //리눅스계정생성
				$user_id=$fax_folder;
				$pass=$fax_folder;

				$hashed_pass=crypt($pass,5000);

				global $P_DIR;
				global $H_DIR;

				//$cmd=sprintf("%s/userdel -r %s",$P_DIR, $user_id ); 
				//exec($cmd,$arr,$returnvar); 

				// rassberrypi
				if( $is_rassberrypi == true ) {
					$cmd=sprintf("%s/useradd  %s -g docu -p %s -s /bin/nologin",$P_DIR, $user_id,$hashed_pass);
				}
				// PC version
				else {
					$cmd=sprintf("echo useradd  %s -g docu -p %s -s /bin/nologin",$user_id,$hashed_pass); 
				}

				exec($cmd,$arr,$returnvar); 


	         if($returnvar !=9) {
                  //삼바계정 설정하기
					$cmd = 'echo -e "'.$user_id.'\n'.$user_id.'" | smbpasswd -s -a '.$user_id;
					exec($cmd);

				   // 계정정보 DB에 저장하기
				   
				   $today=date("Y-m-d");
				 
				   ########## 신청한 아이디와 동일한 아이디가 존재하는지 확인한다. ########## 
				   $qry = " select fax_folder from fax where fax_folder ='$user_id' ";
				   $res = db_query($qry);
					if (!$res) {
						 $result = 5;
						 echo $result;
					     exit;
				    }
				   $rows = mysqli_data_seek($res,0);
				   if ($rows) {
					     $result = 6;
						 echo $result;
				         exit;
					}else{
						########## 신규폴더(faxall.../이름 DB insert  ########## 
						$qry ="insert into fax set fax_num='$_POST[fax_num]' , fax_folder='$fax_folder', fax_busu='$_POST[fax_busu]', num='$row[num]' ,reg_date=now() ";
						$res=db_query($qry);
						if (!$res) {
							$result = 5;
							echo $result;
							exit;
						}
					}

					//fax 디렉토리 설정
					// rassberrypi
					if( $is_rassberrypi == true ) {
						$cmd2=sprintf("%s/mkdir  -p %s/%s/fax",$P_DIR,$H_DIR,$user_id); 
					}
					// PC version
					else {
						$cmd2=sprintf("mkdir  -p %s/%s/fax",$H_DIR,$user_id); 
					}
					@system($cmd2);
					$cmd="chmod 777  /home/samba/".$user_id."/fax";
					system($cmd);

					//scan 디렉토리 설정

					// rassberrypi
					if( $is_rassberrypi == true ) {
						$cmd3=sprintf("%s/mkdir   %s/%s/scan",$P_DIR,$H_DIR,$user_id); 
					}
					// PC version
					else {
						$cmd3=sprintf("mkdir   %s/%s/scan",$H_DIR,$user_id); 
					}
					system($cmd3);
					$cmd="chmod 777  /home/samba/".$user_id."/scan";
					system($cmd);

					

					// 삼바 환경설정 
					$cmd="touch /etc/samba/config/".$user_id.".txt";
						system($cmd);
					$cmd="chmod 777  /etc/samba/config/".$user_id.".txt";
						system($cmd);
					$cmd="echo [".$user_id."] >> /etc/samba/config/".$user_id.".txt\n";
						system($cmd);
					$cmd="echo comment = ".$user_id." >> /etc/samba/config/".$user_id.".txt\n";
						system($cmd);
					$cmd="echo path = /home/samba/".$user_id."/  >> /etc/samba/config/".$user_id.".txt\n";
						system($cmd);
					$cmd="echo valid users = ".$user_id." >> /etc/samba/config/".$user_id.".txt\n";
						system($cmd);
					$cmd="echo writable = yes >> /etc/samba/config/".$user_id.".txt\n";
						system($cmd);
					$cmd="echo browseable = yes >> /etc/samba/config/".$user_id.".txt\n";
						system($cmd);
					$cmd="echo create mask = 0777 >> /etc/samba/config/".$user_id.".txt\n";
						system($cmd);
					$cmd="echo directory mask = 0777 >> /etc/samba/config/".$user_id.".txt\n";
						system($cmd);
					$cmd="echo read only = no >> /etc/samba/config/".$user_id.".txt\n";
						system($cmd);

           // smb.conf 에 include	    	  
					$cmd="echo   include = /etc/samba/config/".$user_id.".txt  >> /etc/samba/smb.conf\n";
						exec($cmd);

	        //삼바 리스타트			
     				  $cmd="/etc/init.d/samba restart";
					  exec($cmd);

		             $result = "Y";
					 echo $result;
					 exit;

			}else if($returnvar==9) {
					$result = 0;  
					 echo $result;
					 exit;
			}

}else if($_POST[mode] == 'fax_delete'){

			    $qry = "select fax_folder from fax  where seq='$_POST[seq]' ";
                $res = db_query($qry);
                $row = db_fetch_array($res);

                $user_id=$row[fax_folder];
                if (str_replace("/", "", $user_id) != "") {
				// fax정보 DB에서 삭제하기
				   
				   $today=date("Y-m-d");
				 
				   ########## 계정 삭제. ########## 
				   $qry = " delete from fax where seq ='$_POST[seq]' ";
				   $res = db_query($qry);
					if (!$res) {
						 $result = 5;
						 echo $result;
					     exit;
					}else{
					
						  //삼바계정 삭제하기
						  $cmd="smbpasswd -x ".$user_id;
						  exec($cmd);  sleep(2);
						   
						  //리눅스계정 삭제하기
						  $cmd="userdel  ".$user_id;
						  exec($cmd);  sleep(1);
										 
						  //디렉토리 삭제하기
						  $cmd="rm -r /home/samba/".$user_id;
						  exec($cmd);  sleep(1);
						
						  //설정화일 삭제하기
						  $cmd="rm /etc/samba/config/".$user_id.".txt";
						  exec($cmd);  sleep(1);
						
						  //삼바 리스타트			
						  $cmd="/etc/init.d/samba restart";
						  exec($cmd);
					
				       
						 $result = "Y";
						 echo $result;
					     exit;
					 }				
				}

}else if($_POST[mode] == 'Addreply') {  // => 계층형 댓글로 변경 

				//원 댓글의 데이터 구하기
				$originQue = "select cmt_ref, cmt_relevel, cmt_restep from board where uid = '". $_POST[uid] ."' ";
				$o_res = db_query( $originQue );
				$o_row = db_fetch_array($o_res);

				//원 댓글들 정렬 업데이트 처리 
				$u_sql = " update board set cmt_restep = cmt_restep + 1 where cmt_uid = '". $_POST[uid] ."' and cmt_ref = ". $o_row["cmt_ref"] ." and cmt_restep > ".$o_row["cmt_restep"] ."";
				$u_res = db_query( $u_sql );

				$queIn ="
						INSERT INTO board (
							id, name, reply, userfile1, filesize1, userfile_origin, reg_date, b_ref, b_restep, cmt_uid, cmt_ref, cmt_relevel, cmt_restep
						) VALUES (
							'". $user_info[MEMID]. "','". $user_info[MEMNAME]. "','" . db_real_escape_string( $_POST[$commentWriteKey] ) . "','". $dest ."','". $file_size ."','". $file_name ."',now() ,
							'". $_POST[b_ref] ."',	'". ( $_POST[b_restep]+1 ) ."', '". $_POST[uid] ."', '". $o_row[cmt_ref] ."', '0', '". ($o_row["cmt_restep"]+1) ."'
						);
					";
				db_query($queIn);

				//리로드시 카운터증가하므로 -1 해준다
				$qry="update board set ref=ref - 1 where uid ='$_POST[uid]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'DocuAddreply') {
                
				$b_restep=$_POST[b_restep] + 1;
			   	$qry=" insert into  docu set  id='$user_info[MEMID]',name='$user_info[MEMNAME]',reply='" . db_real_escape_string($_POST[reply]) . "',reg_date=now()  ,b_ref='$_POST[b_ref]' ,b_restep='$b_restep' ";
				db_query($qry);

				//리로드시 카운터증가하므로 -1 해준다
				$qry="update docu set ref=ref - 1 where uid ='$_POST[uid]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'OrderAddreply') {

	            $qry= "select  max(b_reorder)+1 from orders where b_ref='$_POST[b_ref]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);
				$b_reorder = $row[0];

			   	$qry=" insert into  orders set  id='$user_info[MEMID]',wname='$user_info[MEMNAME]',reply='" . db_real_escape_string($_POST[reply]) . "',reg_date=now() ,b_restep='1',b_ref='$_POST[b_ref]' ,b_reorder='$b_reorder',b_relevel='1' ";
				db_query($qry);

				//리로드시 카운터증가하므로 -1 해준다
				$qry="update orders set ref=ref - 1 where uid ='$_POST[uid]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'OrderAddrereply') {
//답글에 답글

				$qry= "select  b_ref ,b_reorder from orders where uid='$_POST[uid]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);
				$b_ref = $row[0];
				$b_reorder = $row[1];

				$qry= "select  max(b_relevel)+1 from orders where b_ref='$b_ref' and b_reorder='$b_reorder' ";
				$res = db_query($qry);
				$row2 = db_fetch_array($res);
				$b_relevel = $row2[0];

			   	$qry=" insert into  orders set  id='$user_info[MEMID]',wname='$user_info[MEMNAME]',reply='" . db_real_escape_string($_POST[reply]) . "',reg_date=now() ,b_restep='1',b_ref='$b_ref',b_reorder='$b_reorder',b_relevel='$b_relevel' ";
				db_query($qry);

				//리로드시 카운터증가하므로 -1 해준다
				$qry="update orders set ref=ref - 1 where uid ='$_POST[uid]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'Delreply') {

			   	$qry=" delete from board where uid = '$_POST[uid]' ";
				db_query($qry);

				//리로드시 카운터증가하므로 -1 해준다
				$qry="update board set ref=ref - 1 where uid ='$_POST[puid]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'DocuDelreply') {

			   	$qry=" delete from docu where uid = '$_POST[uid]' ";
				db_query($qry);

				//리로드시 카운터증가하므로 -1 해준다
				$qry="update docu set ref=ref - 1 where uid ='$_POST[puid]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'OrderDelreply') {

                $qry= "select * from orders where uid='$_POST[uid]' ";
				$res = db_query($qry);
				$row = db_fetch_array($res);
				$filename = $row[userfile1];
              
				if(str_replace("/", "", $filename) != ""){
					//DB 삭제하기
					$qry ="delete from orders where uid='$_POST[uid]' ";
					db_query($qry);
					
				   //화일 삭제하기
					$cmd="sudo rm  /home/samba/orders/".$filename ;
					exec($cmd);
				}

			    //리로드시 카운터증가하므로 -1 해준다
				$qry="update orders set ref=ref - 1 where uid ='$_POST[puid]' ";
				db_query($qry);

				echo "Y";

}else if($_POST[mode] == 'somo_send') {

	        $qry ="select  * from member where id='$user_info[MEMID]' ";
			$res = db_query($qry);
			$row = db_fetch_array($res);

			if(!$row[email]) {
				echo "empty";
				exit;
			}

          require_once("../inc/PHPMailer/PHPMailerAutoload.php");
          if($_POST[type]=='as'){
				$subjectOri = "AS 신청합니다(".$_POST[customer].")";
		  }else{
				$subjectOri = "소모품 신청합니다(".$_POST[customer].")";
		  }
            $subject = "=?UTF-8?B?".base64_encode($subjectOri)."?=";
			$content =  nl2br($_POST[content]);
	/*	
			$message = "<table>";
			$message .= "<tr><td bgcolor='#AFEEEE'>제목:</td><td bgcolor='#AFEEEE'>".$subjectOri."</td></tr>";
			$message .= "<tr><td >고객명:</td><td>".$_POST[customer]."(".$row[busu].")</td></tr>";
            $message .= "<tr><td bgcolor='#AFEEEE'>신청자:</td><td  bgcolor='#AFEEEE'>".$_POST[name]."</td></tr>";
			$message .= "<tr><td>연락처:</td><td>".$_POST[phone]."</td></tr>";
			$message .= "<tr><td bgcolor='#AFEEEE'>모델명:</td><td bgcolor='#AFEEEE'>".$_POST[model]."</td></tr>";
			$message .= "<tr><td>내용:</td><td> ".$content."</td></tr>";
			$message .= "<tr><td bgcolor='#AFEEEE'>회신메일:</td><td bgcolor='#AFEEEE'> ".$row[email]."</td></tr>";
			$message .= "</table>";
	*/	 			
			 switch($row[fromemail]){
			 case "1":
			     $fromemail="hanmail.net";
				 $host="smtp.daum.net";
			     $port="465";
				 $ssl="ssl";
			 break;

			 case "2":
			     $fromemail="naver.com";
			     $host="smtp.naver.com";
			     $port="465";
				 $ssl="ssl";
			 break;

			  case "3":
			     $fromemail="nate.com";
			     $host="smtp.mail.nate.com";
			     $port="465";
				 $ssl="ssl";
			 break;

			  case "4":
			     $fromemail="gmail.com";
			     $host="smtp.gmail.com";
			     $port="465";
				 $ssl="ssl";
			 break;

			  case "5":
			     $fromemail="docurental.kr";
			     $host="wsmtp.ecounterp.com";
			     $port="587";
				 $ssl="";
			 break;
		   }

		 $email_address=$row[fromid]."@".$fromemail;
        

		 $message = file_get_contents('../mail/mail_template.php'); 
		
		 $message = str_replace('%subject%', $subjectOri, $message); 
		 $message = str_replace('%customer%', $_POST[customer], $message); 
		 $message = str_replace('%busu%', $row[busu], $message); 
		 $message = str_replace('%name%', $_POST[name], $message); 
		 $message = str_replace('%phone%', $_POST[phone], $message); 
		 $message = str_replace('%model%', $_POST[model], $message); 
		 $message = str_replace('%content%', $_POST[content], $message); 
        

	    $mail = new PHPMailer(true);

		//Tell PHPMailer to use SMTP
		$mail->isSMTP();

		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 2;

		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';

		//Set the hostname of the mail server
		$mail->Host = $host;

		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = $port;

		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = $ssl;

		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;

		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = $email_address;

		//Password to use for SMTP authentication
		$mail->Password = $row[frompass];

		//Set who the message is to be sent from
		$mail->setFrom($email_address, 'OfficeHub');

		//Set an alternative reply-to address
		//$mail->addReplyTo('replyto@example.com', 'First Last');

		//Set who the message is to be sent to
		$mail->addAddress('helpdesk@docurental.kr', '');

		//Set the subject line
		$mail->Subject = $subject;

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($message);

		//Replace the plain text body with one created manually
      //$mail->Body = $message;

		//Attach an image file
		//$mail->addAttachment('/images/aaa.gif');

		//send the message, check for errors
		$result=$mail->send();
		if (!$result) {
			echo "N" ;
		} else {
			echo "Y";
		}
	

}else if($_POST[mode] == 'MailSendFile') {

	        $qry ="select  * from member where id='$user_info[MEMID]' ";
			$res = db_query($qry);
			$row = db_fetch_array($res);

			if(!$row[fromid] || !$row[fromemail]  || !$row[frompass]) {
				echo "empty";
				exit;
			}
		          
		   switch($row[fromemail]){
			 case "1":
			     $fromemail="hanmail.net";
				 $host="smtp.daum.net";
			     $port="465";
				 $ssl="ssl";
			 break;

			 case "2":
			     $fromemail="naver.com";
			     $host="smtp.naver.com";
			     $port="465";
				 $ssl="ssl";
			 break;

			  case "3":
			     $fromemail="nate.com";
			     $host="smtp.mail.nate.com";
			     $port="465";
				 $ssl="ssl";
			 break;

			  case "4":
			     $fromemail="gmail.com";
			     $host="smtp.gmail.com";
			     $port="465";
				 $ssl="ssl";
			 break;

			  case "5":
			     $fromemail="docurental.kr";
			     $host="wsmtp.ecounterp.com";
			     $port="587";
				 $ssl="";
			 break;
		   }

		    $email_address=$row[fromid]."@".$fromemail;

			require_once("../inc/PHPMailer/PHPMailerAutoload.php");

			$subjectOri = $user_info[MEMNAME]."님이 발송한 메일입니다.";
		 
			$subject = "=?UTF-8?B?".base64_encode($subjectOri)."?=";

			$message .= $subjectOri."<br/>";
			$message .="부서: ".$row[busu]."<br/>";
			$message .="연락처: ".$row[phone]."<br/>";
			$message .="이메일(회신): ".$row[email]."<br/>";
			$message .="<img border='0' src='http://www.oamart.kr/mail/images/2.jpg' >";
 			
		//Create a new PHPMailer instance
	    $mail = new PHPMailer(true);

		//Tell PHPMailer to use SMTP
		$mail->isSMTP();

		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 2;

		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';

		//Set the hostname of the mail server
		$mail->Host = $host;

		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = $port;

		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = $ssl;

		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;

		//Username to use for SMTP authentication - use full email address for gmail

		$mail->Username = $email_address;
		  
		//Password to use for SMTP authentication
		$mail->Password = $row[frompass];

		//Set who the message is to be sent from
		$mail->setFrom($email_address, 'OfficeHub');

		//Set an alternative reply-to address
		//$mail->addReplyTo('replyto@example.com', 'First Last');

		//Set who the message is to be sent to
		$mail->addAddress($_POST[tomail], '');

		//Set the subject line
		$mail->Subject = $subject;

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($message);

		//Replace the plain text body with one created manually
      //$mail->Body = $message;

		//Attach an image file
		$mail->addAttachment($_POST[filename]);

		//send the message, check for errors
		$result=$mail->send();
		if (!$result) {
			echo "N" ;
		} else {
			echo "Y";
		}
	

}else if($_POST[mode] == 'ChangeMyInfo') { //2015-04-27 윤범식 부서 제거
				//$qry=" update member set  busu='$_POST[busu]', phone='$_POST[phone]', email='$_POST[email]' ,fromid='$_POST[fromid]',fromemail='$_POST[fromemail]',frompass='$_POST[frompass]'  where id='".$user_info[MEMID]."' ";
				$qry=" update member set phone='$_POST[phone]', email='$_POST[email]' ,fromid='$_POST[fromid]',fromemail='$_POST[fromemail]',frompass='$_POST[frompass]'  where id='".$user_info[MEMID]."' ";
				db_query($qry);
				echo "Y";
}else if($_POST[mode] == 'fax_save') {


				$chked_val =explode("," ,$_POST[chked_val]);  
             if($_POST[add] =='N'){
        		$qry = " delete from FaxAuth where num='$_POST[num]' ";
				db_query($qry);
			 }
				
				if(count($chked_val)>0 && $chked_val[0]){
						for($i=0;$i<count($chked_val);$i++){
								$qry = " insert into FaxAuth set readID='$chked_val[$i]',num='$_POST[num]' ";
								db_query($qry);
						}
				}


	echo "Y";

}else if($_POST[mode] == 'board_save') {


				$chked_val =explode("," ,$_POST[chked_val]);  
             if($_POST[add] =='N'){
        		$qry = " delete from BoardAuth where uid='$_POST[uid]' ";
				db_query($qry);
			 }
				
				if(count($chked_val)>0 && $chked_val[0]){
						for($i=0;$i<count($chked_val);$i++){
								$qry = " insert into BoardAuth set readID='$chked_val[$i]',uid='$_POST[uid]' ";
								db_query($qry);
						}
				}


	echo "Y";

}else if($_POST[mode] == 'docu_save') {


				$chked_val =explode("," ,$_POST[chked_val]);  
             if($_POST[add] =='N'){
        		$qry = " delete from DocuAuth where uid='$_POST[uid]' ";
				db_query($qry);
			 }
				
				if(count($chked_val)>0 && $chked_val[0]){
						for($i=0;$i<count($chked_val);$i++){
								$qry = " insert into DocuAuth set readID='$chked_val[$i]',uid='$_POST[uid]' ";
								db_query($qry);
						}
				}


	echo "Y";

}else if($_POST[mode] == 'orders_save') {


				$chked_val =explode("," ,$_POST[chked_val]);  
             if($_POST[add] =='N'){
        		$qry = " delete from OrderAuth where uid='$_POST[uid]' ";
				db_query($qry);
			 }
				
				if(count($chked_val)>0 && $chked_val[0]){
						for($i=0;$i<count($chked_val);$i++){
								$qry = " insert into OrderAuth set readID='$chked_val[$i]',uid='$_POST[uid]' ";
								db_query($qry);
						}
				}


	echo "Y";

}else if($_POST[mode] == 'FaxSend') {

	/*
   if($_POST[viewMode]=="SCAN"){                   
		$mode = "scanDB";
	}else if($_POST[viewMode]=="MYSCAN"){
		$mode = "scanDB";
	}else if($_POST[viewMode]=="OPEN"){
		$mode = "scanDB";
	}else {
		$mode = "faxDB";
	}

	$qry ="select  memo from  tblAutoSaveFiles  where seq='$_POST[seq]' ";
	$res = db_query($qry);
	$row =mysqli_fetch_array($res);

	
	$temp = strstr($_POST[filename],$mode);
	$temp=strstr($temp,'/');
    $filename=substr($temp,1,30);
	$temp = strstr($filename,'.');
	$ext = substr($temp,1,5);
	$ext = trim($ext);
	*/
					
	$filename_division = explode(',,,,,',$_POST[filename]);
	for($j=0; $j< count($filename_division); $j++){
		$filename = basename($filename_division[$j]);
		$ext = substr($filename, strrpos($filename, ".") + 1); 
		$filesize = filesize($filename_division[$j]);
		
		if(!$filesize){
			echo 'F';
			exit;
		}

		if($ext == 'jpg' || $ext =='png' || $ext =='gif' || $ext =='jpeg' ) {
			echo 'N';
			exit;
		}
		$filename_division_real = $filename_division_real.' '.$filename_division[$j];
		//팩스발송
	}
	
 	    $cmd = "sudo sendfax -n -d  ".$_POST[tofax].$filename_division_real;
 	    db_query("insert into tbl_test(f_memo) value ('".$cmd."')");
		exec($cmd, $arr, $returnvar); 

		for($i = 0; $i < 10; $i++){
			$str .= $arr[$i];
		}
		//jobid 찾기
		$str = strstr($str, 'is');
		$str = strstr($str, ' ');
		$jobid = substr($str, 1, strpos($str,'(')-1);
		$jobid = trim($jobid);
		
	for($j=0; $j< count($filename_division); $j++){
		$filename = basename($filename_division[$j]);
		$ext = substr($filename, strrpos($filename, ".") + 1); 
		$filesize = filesize($filename_division[$j]);
		
		if(!$filesize){
			echo 'F';
			exit;
		}
		
		//$qry = " insert into FaxSendInfo set  send_date=now(),sender='$user_info[MEMNAME]', receive_num='$_POST[tofax]', filename='$filename', ext='$ext',authid='$user_info[MEMID]' ,fromdir='$_POST[filename]' ,filesize= '$filesize' ,docuname='$row[memo]',jobid='$jobid' ";

		$qry = " insert into FaxSendInfo set  send_date=now(),sender='$user_info[MEMNAME]', receive_num='$_POST[tofax]', filename='$filename', ext='$ext',authid='$user_info[MEMID]' ,fromdir='$filename_division[$j]' ,filesize= '$filesize' ,docuname='$filename',jobid='$jobid' ";
		db_query($qry);
			
	}
	
	echo "Y";

}else if($_POST[mode] == 'fax_cancel') {

            //팩스 취소
			$cmd="sudo faxrm ".$_POST[jobid];
			system($cmd);
			
	echo "Y";

}else if($_POST[mode] == 'FaxCheck') {

                $cmd="faxstat ";
			    exec($cmd,$arr,$returnvar); 

					for($i=0;$i<110;$i++){
							$str .= $arr[$i];
					}
				 $check1 = strpos($str,'Waiting for modem to come ready' );  
				 $check2 = strpos($str,'Initializing server' ); 
				
				 if($check1) {
					 echo "N";
				 }else if($check2){
					 echo "N";
				 }else{
					 echo "Y";
				 }

}else if($_POST[mode] == 'FaxInit') {

                $cmd="sudo /etc/init.d/hylafax restart ";
			     exec($cmd); 

			     echo "Y";				 
}else if($_POST[mode] == 'read_id') {

	      $rsList="";
		  $rsList1="";
		  $rsList2="";
		  $ids="";
		  
       $qry = "select * from OrderAuth where uid ='$_POST[uid]' " ;
	   $result = db_query($qry);
       while($rows = db_fetch_array($result)) {
				$ids .=$rows[readID]."," ;
	   }
        $ids= str_replace($user_info[MEMID],'',$ids);

	   $qry = " select  id,name, busu from member   where id !='docu' order by busu ";
	   $res = db_query($qry);
	   $rows = db_num_rows($res);

		if (!$res) {
			  $rsList2="쿼리 에러 입니다1";
			  echo $rsList2;
			 exit;
		}else{
			for($i=0;$i<$rows;$i++) {
				$row = db_fetch_array($res);
                
				 $temp=strstr($ids, $row[id]);
				 if($temp) $select='1';
				 else $select='0';

                 $rsList1 =  " 
				   <thead>
                        <tr>
                            <td style='width: 60px;'   align='left'>아이디</td>
                            <td style='width: 70px;'  align='left'>이 름</td>
							<td style='width: 70px;'  align='left'>부 서</td>
                            <td style='width: 80px;' align='center'>공유여부</td>
						 </tr>
                    </thead>";
				 $rsList .= "
						  <tr>
                          <td style=' color:#000' align='left'>$row[id]</td>
                          <td style=' color:#000' align='left'>$row[name]</td>
						  <td style=' color:#000' align='left'>$row[busu]</td>";
				if($select){
						  $rsList .= "<td style='color:#000' align='center'> <input type='checkbox' name='chk' value='$row[name]/$row[id]' checked></td>";
				}else{
   					      $rsList .= "<td style='color:#000' align='center'> <input type='checkbox' name='chk' value='$row[name]/$row[id]' ></td>";
                } 
				  $rsList .= "</tr>";
			}
		 }

           $rsList2=$rsList1.$rsList;

				echo "<table>".$rsList2."</table>";

}else if($_POST[mode] == 'scan_file') {

	      $rsList="";
		  $rsList1="";
		  $rsList2="";
		  $ids="";
		  
       $tmpTable = "select a.authID, a.class, a.seq from tblAutoSaveFiles a left join tblAutoSaveFileAuth b on a.seq = b.seq where (a.authid = '$user_info[MEMID]' or b.readID = '$user_info[MEMID]') and a.class = 'MYSCAN'  group by a.authID, a.class, a.seq ";

	   $qry = " select a.*, c.name as authName from tblAutoSaveFiles a inner join (". $tmpTable .") b on a.authID = b.authID and a.class = b.class and a.seq = b.seq left join member c on a.authID = c.id order by a.receive_date  desc ";
	   $res = db_query($qry);
	   $rows = db_num_rows($res);

		if (!$res) {
			  $rsList2="쿼리 에러 입니다1";
			  echo $rsList2;
			 exit;
		}else{
			for($i=0;$i<$rows;$i++) {
				$row = db_fetch_array($res);
                
				 $receive_date=substr($row[receive_date],'0','10');

				 $imsi="img".$i;
				$imsi2="elem".$i;

				$type=$row[mimie];
				if($type=='image') $temp="	<td>". $row[fromdir] ."</td>";
				else $temp="	<td>". $row[fromdir] ."</td>";

				$fileFullName = $row[todir].$row[filename];
				$filesize=$row[filesize];

                 $rsList1 =  " 
				   <thead>
                        <tr>
                            <td style='width: 100px;'  align='center'>문서명</td>
                            <td style='width: 120px;'  align='center'>생성일</td>
							<td style='width: 100px;'  align='center'>다운로드</td>
                            <td style='width: 100px;' align='center'>선택</td>
						 </tr>
                    </thead>";
				 $rsList .= "
						  <tr>
                          <td style=' color:#000' align='center'>$row[memo]</td>
                          <td style=' color:#000' align='center'>$receive_date</td>
						  <td style=' color:#000' align='center'><input type='button' class='btn btn-info' value='다운로드' onclick=\"fileDownFun('". $fileFullName ."');\"></td>
						 <td style=' color:#000' align='center'><input type='button' class='btn btn-success' value='선택' onclick=\"SelectScan('$fileFullName','$row[filename]','$filesize');\"></td>";
				 $rsList .= "</tr>";
			}
		 }

           $rsList2=$rsList1.$rsList;

				echo "<table>".$rsList2."</table>";

}else if($_POST[mode] == 'scan_add') {

			   	$qry=" update orders set userfile2='$_POST[filename]',fullname='$_POST[fullname]' , filesize2='$_POST[size]'  where uid = '$_POST[uid]' ";
				db_query($qry);

				echo "Y";
}else if($_POST[mode] == 'fax_file') {

	      $rsList="";
		  $rsList1="";
		  $rsList2="";
		  $ids="";
		  
       $tmpTable = "select a.authID, a.class, a.seq from tblAutoSaveFiles a left join tblAutoSaveFileAuth b on a.seq = b.seq where (a.authid = '$user_info[MEMID]' or b.readID = '$user_info[MEMID]') and a.class = 'MYFAX'  group by a.authID, a.class, a.seq ";

	   $qry = " select a.*, c.name as authName from tblAutoSaveFiles a inner join (". $tmpTable .") b on a.authID = b.authID and a.class = b.class and a.seq = b.seq left join member c on a.authID = c.id order by a.receive_date  desc ";
	   $res = db_query($qry);
	   $rows = db_num_rows($res);

		if (!$res) {
			  $rsList2="쿼리 에러 입니다1";
			  echo $rsList2;
			 exit;
		}else{
			for($i=0;$i<$rows;$i++) {
				$row = db_fetch_array($res);
                
				 $receive_date=substr($row[receive_date],'0','10');

				 $imsi="img".$i;
				$imsi2="elem".$i;

				$type=$row[mimie];
				if($type=='image') $temp="	<td>". $row[fromdir] ."</td>";
				else $temp="	<td>". $row[fromdir] ."</td>";

				$fileFullName = $row[todir].$row[filename];
				$filesize=$row[filesize];

                 $rsList1 =  " 
				   <thead>
                        <tr>
                            <td style='width: 100px;'  align='center'>문서명</td>
                            <td style='width: 120px;'  align='center'>생성일</td>
							<td style='width: 100px;'  align='center'>다운로드</td>
                            <td style='width: 100px;' align='center'>선택</td>
						 </tr>
                    </thead>";
				 $rsList .= "
						  <tr>
                          <td style=' color:#000' align='center'>$row[memo]</td>
                          <td style=' color:#000' align='center'>$receive_date</td>
						  <td style=' color:#000' align='center'><input type='button' class='btn btn-info' value='다운로드' onclick=\"fileDownFun('". $fileFullName ."');\"></td>
						 <td style=' color:#000' align='center'><input type='button' class='btn btn-success' value='선택' onclick=\"SelectFax('$fileFullName','$row[filename]','$filesize');\"></td>";
				 $rsList .= "</tr>";
			}
		 }

           $rsList2=$rsList1.$rsList;

				echo "<table>".$rsList2."</table>";

}else if($_POST[mode] == 'fax_add') {

			   	$qry=" update orders set userfile3='$_POST[filename]',fullname='$_POST[fullname]' , filesize3='$_POST[size]'  where uid = '$_POST[uid]' ";
				db_query($qry);

				echo "Y";
}else if($mode=='comment_del'){

	//print_r($_REQUEST); exit;

	$sql = " select fIdx,flowCommentIdx,flowUserIdx,flowCommentDepth,cateIdx from tblFlow_Comment where seq = '".$seq."' ";
	$row = db_fetch_array(db_query($sql));
	$fidx = $row['fIdx'];
	$cateIdx = $row['cateIdx'];

	if($row['flowUserIdx']!=$user_info["MEMSEQ"] && $user_info["ISADMINYN"] != $user_info["MEMID"]){
		echo getLabel("/var/www/flow/flow_a.php?title26","자신의 글이 아니므로 삭제할 수 없습니다.");
		exit;
	}
	
	$len = strlen($row['flowCommentDepth']);
	if ($len < 0) $len = 0;
	$comment_reply = substr($row['flowCommentDepth'], 0, $len);

	$sql = "
	select 
		count(*) as cnt 
	from 
		tblFlow_Comment
	where 
		flowCommentDepth like '".$comment_reply."%'
		and seq <> '".$seq."'
		and fIdx = '".$row[fIdx]."'
		and flowCommentIdx = '".$row[flowCommentIdx]."' 
		and delDate IS NULL";

	$row = db_fetch_array(db_query($sql));

	if($row['cnt'] && ($user_info["ISADMINYN"] != $user_info["MEMID"])){
		echo getLabel("/var/www/flow/flow_a.php?title27","이 코멘트와 관련된 답변코멘트가 존재하므로 삭제 할 수 없습니다.");
		exit;
	}

	//$qry = "UPDATE tblFlow_Comment SET delDate = now() WHERE seq = '".$seq."'";
	$qry = "DELETE FROM tblFlow_Comment WHERE seq = '".$seq."' limit 1";
	if(db_query($qry)){

		//업무일지일 경우 댓글 카운트를 감소
		if($cateIdx==7){
			$sql = "UPDATE tblReport SET comment_cnt = comment_cnt - 1 WHERE report_idx = ".$fidx."";
			db_query( $sql );
		}

		//첨부파일 삭제
		if($document!=null){

			//썸네일 삭제
			$sql = "
				SELECT 
					b.* 
				FROM 
					tblFilesMap AS a
					LEFT JOIN tblFiles AS b ON b.`file_idx` = a.`file_idx`
				WHERE 
					a.document = '".$document."' AND 
					a.document_idx = ".$seq." AND
					b.fileExt IN ('jpg','jpeg','png','gif')
			";
			$res = db_query($sql);
			while($row = db_fetch_array($res)){
				$path = '/home/samba/files/'.$row["upload_path"].'/thumb_'.$row["upload_filename"];
				if(file_exists($path)){ unlink($path); }
			}

			//매핑삭제
			$sql = "DELETE FROM tblFilesMap WHERE document='".$document."' AND document_idx = '".$seq."'";
			db_query($sql);
		}

		echo 'OK';
	}else{
		echo 'FAIL';	
	}
}else if($mode=='comment_update'){	//댓글 첨부파일 정보 가져오는 함수

	//전자결재, 모듈화 댓글
	$sql = "
		SELECT 
			a.*,
			b.picture_file_idx
		FROM 
			tblFlow_Comment as a
			LEFT JOIN tblMemberInfo AS b ON a.flowUserIdx = b.member_idx
		WHERE 
			seq = ".$seq."
		ORDER BY 
			flowCommentIdx,flowCommentDepth
		";
	$res = db_query( $sql );
	if( $row = db_fetch_assoc( $res ) ) {
		$row['newFlag'] = true;
		echo makeComment1($row, $document);
	}else {
		echo '';
	}

}else if($mode=='comment_file'){	//댓글 첨부파일 정보 가져오는 함수

	$files = new files;
	$file_list = $files -> get_file_mapping( $document, $document_idx ) ;

	echo json_encode($file_list);

}else if($mode=='comment_html'){	//댓글 내용을 가져오는 함수
	$sql = " select flowNote from tblFlow_Comment where seq = '".$seq."' ";
	$row = db_fetch_array(db_query($sql));
	if($row){
		echo $row['flowNote'];
	}else {
		echo "";
	}
}else if($mode=='comment_edit'){

	//오류체크
	$sql = " select seq from tblFlow_Comment where seq = '".$seq."' ";
	$reply_array = db_fetch_array(db_query($sql));
	if (!$reply_array['seq']){
		echo "수정할 댓글이 없습니다.\\n\\n답변하는 동안 댓글이 삭제되었을 수 있습니다.";
		exit;
	}

	//수정결과
	$sql = "update tblFlow_Comment set flowNote = '".$comment."' where seq = '".$seq."' limit 1";
	$res = db_query($sql);
	if($res){

		//첨부파일
		if(!($document=="" || $document==null)){

			$files = new Files();
			$fileIdx = json_decode($fileIdx);

			//
			foreach($fileIdx AS $key => $val ) {
				//첨부파일 매핑
				$files -> file_mapping( $document, $seq, $val ); //seq : 문서번호 , val : 파일번호

				//썸네일 생성
				$thum_qry = "SELECT * FROM tblFiles WHERE fileExt IN ('jpg','jpeg','png','gif') AND file_idx = '".$val."'";
				$thum_res = db_query($thum_qry);
				if($thum_row = db_fetch_array($thum_res)){
					$file_path = '/home/samba/files/'.$thum_row["upload_path"].'/'.$thum_row["upload_filename"];
					$save_path = '/home/samba/files/'.$thum_row["upload_path"].'/thumb_'.$thum_row["upload_filename"];
					MakeThumb($file_path, $save_path, '240', '180');
				}
			}
		}

		echo "댓글이 수정 되었습니다.";
	}else {
		echo "댓글 수정에 실패하였습니다.";
	}

}else if($mode=='comment_add'){

	//print_r($_REQUEST); exit;

	if($seq){

		$sql = " select seq, flowCommentIdx, flowCommentDepth from tblFlow_Comment where seq = '".$seq."' ";
		$reply_array = db_fetch_array(db_query($sql));
		if (!$reply_array['seq']){
			echo getLabel("/var/www/flow/flow_a.php?title20","답변할 댓글이 없습니다.\\n\\n답변하는 동안 댓글이 삭제되었을 수 있습니다.");
			exit;
		}

		$tmp_comment = $reply_array['flowCommentIdx'];

		if (strlen($reply_array['flowCommentDepth']) == 5){
			echo getLabel("/var/www/flow/flow_a.php?title21","더 이상 답변하실 수 없습니다.\\n\\n답변은 5단계 까지만 가능합니다.");
			exit;
		}

		$reply_len = strlen($reply_array['flowCommentDepth']) + 1;

		$begin_reply_char = 'A';
		$end_reply_char = 'Z';
		$reply_number = +1;
		$sql = "
			select 
				MAX(SUBSTRING(flowCommentDepth, $reply_len, 1)) as reply
			from 
				tblFlow_Comment
			where 
				fIdx = '".$fidx."'
				and flowCommentIdx = '$tmp_comment'
				and SUBSTRING(flowCommentDepth, $reply_len, 1) <> '' 
		";

		if ($reply_array['flowCommentDepth']){
			$sql .= " and flowCommentDepth like '{$reply_array['flowCommentDepth']}%' ";
		}
		$row = db_fetch_array(db_query($sql));

		if (!$row['reply']){
			$reply_char = $begin_reply_char;
		}else if ($row['reply'] == $end_reply_char){// A~Z은 26 입니다.
			echo getLabel("/var/www/flow/flow_a.php?title22","더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.");
			exit;
		}else{
			$reply_char = chr(ord($row['reply']) + $reply_number);
		}

		$tmp_comment_reply = $reply_array['flowCommentDepth'] . $reply_char;

	}else {
		$sql = "select max(flowCommentIdx) as max_comment from tblFlow_Comment where fIdx = '".$fidx."' ";
		$row = db_fetch_array(db_query($sql));
		$tmp_comment = $row['max_comment'] + 1;
		$tmp_comment_reply = '';
	}

	$qry = "
	INSERT INTO tblFlow_Comment
	(
		fIdx, 
		flowCommentIdx, 
		flowCommentDepth,
		flowNote, 
		flowUserIdx,
		flowUserName,
		flowUserPart, 
		flowUserJicwi, 
		regDate,
		delDate,
		cateIdx
	)
	VALUES
	(
		'".$fidx."',
		'".$tmp_comment."',
		'".$tmp_comment_reply."',
		'".$comment."',
		'".$user_info['MEMSEQ']."',
		'".$user_info['MEMNAME']."',
		'".$user_info['MEMBUSU']."',
		'".$user_info['MEMJICWI']."',
		now(),
		'0000-00-00 00:00:00',
		'".$comment_cate."'
	)";
	
	if(db_query($qry)){
		//첨부파일
		$new_seq = db_insert_id();

		//업무일지일 경우 댓글 카운트를 증가
		if($comment_cate==7){
			$sql = "UPDATE tblReport SET comment_cnt = comment_cnt + 1 WHERE report_idx = ".$fidx."";
			db_query( $sql );
		}


		if(!($document=="" || $document==null)){

			$files = new Files();
			$fileIdx = json_decode($fileIdx);

			//
			foreach($fileIdx AS $key => $val ) {
				//첨부파일 매핑
				$files -> file_mapping( $document, $new_seq, $val ); //seq : 문서번호 , val : 파일번호
				//썸네일 생성
				$thum_qry = "SELECT * FROM tblFiles WHERE fileExt IN ('jpg','jpeg','png','gif') AND file_idx = '".$val."'";
				$thum_res = db_query($thum_qry);
				if($thum_row = db_fetch_array($thum_res)){
					$file_path = '/home/samba/files/'.$thum_row["upload_path"].'/'.$thum_row["upload_filename"];
					$save_path = '/home/samba/files/'.$thum_row["upload_path"].'/thumb_'.$thum_row["upload_filename"];
					MakeThumb($file_path, $save_path, '240', '180');
				}
			}
		}

		echo getLabel("/var/www/board/board_view.php?alert3","댓글이 등록 됐습니다.");

		//댓글등록시 메신저 발송

		$commentTitle = array();
		$reportIdx = 0;
		$titleUser = "";
		if( $comment_cate == 1 ){
			//전자결재
			$clsNum = 13;
			$sql = "SELECT docTitle, docUserName FROM tblFlow WHERE idx = ".$fidx;
		}else if( $comment_cate == 2){
			//사내게시판
			$clsNum = 2;
			$sql = "SELECT subject, name FROM board WHERE uid = ".$fidx;
		}else if( $comment_cate == 3){
			//일정관리
			$clsNum = 4;
			$sql = "SELECT title ,name FROM schedules WHERE uid = ".$fidx;
		}else if( $comment_cate == 4 ){
			//업무요청
			$clsNum = 10;
			$sql = "SELECT orderTitle, orderUserName FROM tblOrder WHERE idx = ".$fidx;
		}else if( $comment_cate == 5 ){
			//회의관리
			$clsNum = 6;
			$sql = "SELECT conf_title, member_seq FROM tblConference WHERE conf_idx = ".$fidx;
		}else if( $comment_cate == 6 ){
			//인맥관리
			$clsNum = 5;
			$sql = "SELECT com, id FROM namebook WHERE seq = ".$fidx;
		}else if( $comment_cate == 7 ){
			//업무일지
			$clsNum = 9;
			$sql = "SELECT work_year, work_month, work_day, member_idx FROM tblReport WHERE report_idx = ".$fidx;
		}

		$res = db_query($sql);
		while($row = db_fetch_array($res)){
			if($comment_cate == 7){
				$commentTitle = $row[0]."-".$row[1]."-".$row[2]."일[업무일지]";
				$sql = "SELECT name FROM member WHERE seq = ".$row['member_idx'];
				$res = db_query($sql);
				$memberRow = db_fetch_array($res);
				$titleUser = $memberRow[0];
			}else if($comment_cate == 5){
				$commentTitle = $row[0];
				$sql = "SELECT name FROM member WHERE seq = ".$row[1];
				$res = db_query($sql);
				$memberRow = db_fetch_array($res);
				$titleUser = $memberRow[0];
			}else if($comment_cate == 6){
				$commentTitle = $row[0];
				$sql = "SELECT name FROM member WHERE id = '".$row[1]."'";
				$res = db_query($sql);
				$memberRow = db_fetch_array($res);
				$titleUser = $memberRow[0];
			}else{
				$commentTitle = $row[0];
				$titleUser = $row[1];
			}
		}
		//$memberSeqList = Array();

		//보낼 userIdx 값 넣기
		if($comment_cate == 1){
			$sql = "SELECT lineUserIdx FROM tblFlow_Line WHERE fidx = ".$fidx."
					UNION
					SELECT lineUserIdx FROM tblFlow_Line2 WHERE fidx = ".$fidx."
					UNION
					SELECT seeUserIdx FROM tblFlow_See WHERE fidx = ".$fidx;
			$res = db_query($sql);
			while($row = db_fetch_array($res)){
				$memberSeqList[] = $row['lineUserIdx'];
			}
		}else{
			if($comment_cate == 4){
				$orderCount = 2;
			}else{
				$orderCount = 1;
			}

			for($i = 0; $i < $orderCount; $i++){
				if($i == 1){
					$clsNum = 16;
				}
				$qry = "SELECT
							SPLIT_STR(authVal, ':', 1) AS authTop,
							SPLIT_STR(authVal, ':', 2) AS authMid,
							SPLIT_STR(authVal, ':', 3) AS authBottom,
							authVal
						FROM
							tblAuthTotal
						WHERE
							clsNum = ".$clsNum." AND idx=".$fidx;
				$res = db_query($qry);

				//권한이 부서로 등록되어 있을 경우
				while($row = db_fetch_array($res)){
					if($row['authTop'] == "E" || $row['authTop'] == "F"){
						$sql = "
							SELECT
								a.idx, a.partName, a.pIdx, LEVEL, CONCAT( a.levelTxt, a.partName) AS partNameDept, CONCAT( a.levelTxt, c.name ) AS name, c.seq, c.sort
							FROM
								(
									SELECT
										d.idx, d.partName, d.pIdx, func.level, func.rownum, '' AS levelTxt, d.partOrder
									FROM
										(
											SELECT
												".$row['authMid']." idx, 1 LEVEL, 1 rownum UNION ALL SELECT get_lvl_tblPart() AS idx, @level AS LEVEL, @rownum:=@rownum+1 AS rownum
											FROM
												(SELECT @start_with:=".$row['authMid'].", @id:=@start_with, @level:=1, @rownum:=1) vars JOIN tblPart WHERE @id IS NOT NULL
										) func
										JOIN tblPart d ON func.idx = d.idx
								) a
								LEFT JOIN tblPartMember b ON a.idx = b.pIdx
								LEFT JOIN member c ON b.mSeq = c.seq
								LEFT JOIN tblMemberInfo d ON c.seq = d.member_idx
								LEFT JOIN tblJicwi j ON d.position_idx = j.idx
							WHERE
								c.id <> 'docu' AND d.stop <> 'Y' AND c.id <> 'master' AND c.id <> '".$optReportAutoAuthId."'";
						$result = db_query( $sql );
						while( $row = db_fetch_assoc( $result ) ) {
							$memberSeqList[] = $row['seq'];
						}
					//권한이 사용자로 들어가 있을 경우
					}else if($row['authTop'] == "D"){
						$memberSeqList[] = $row['authBottom'];
					}
				}
			}
		}
		//사용자 중복 제거
		$seqList = array_unique($memberSeqList);
		$auth_m1 = implode(",", $seqList);
		$before = array("{titleUser}","{commentUser}","{commentTitle}","{commnetSubject}");
		$after = array($titleUser,$user_info[MEMNAME],$commentTitle,strip_tags($comment));
		//setMessage($user_info[MEMSEQ],$auth_m1,"CC001",str_replace($before,$after,commentAdd));
	}else {
		echo getLabel("/var/www/board/board_view.php?alert4","댓글 실패!");
	}

}else if($mode=='comment_load'){

	$data = array();
	$begin_reply_char = 'A';

	$sql = "
		SELECT 
			a.*,
			b.picture_file_idx
		FROM 
			tblFlow_Comment as a
			LEFT JOIN tblMemberInfo AS b ON a.flowUserIdx = b.member_idx
		WHERE 
			cateIdx = '".$comment_cate."' and fIdx = '".$fidx."' and seq > '".$seq."'
		";
	$res = db_query($sql);
	while($row = db_fetch_array($res)){
		$row['newFlag'] = true;
		if(!$row['flowCommentDepth'])$row['flowCommentDepth']='';
		$last_char = substr($row['flowCommentDepth'], -1, 1);
		
		if($row['flowCommentIdx']==$begin_reply_char){
			$pos = $row['flowCommentIdx'].'_';
		}else if( $last_char == $begin_reply_char ){
			$pos = $row['flowCommentIdx'].'_'.substr($row['flowCommentDepth'], 0, -1);
		}else if($row['flowCommentDepth']){
			$reply_char = chr(ord($last_char) - 1);
			$pos = $row['flowCommentIdx'].'_'.substr($row['flowCommentDepth'], 0, -1).$reply_char;
		}else{
			$pos = '';
		}

		$data[] = array($row['flowCommentIdx'],$row['flowCommentDepth'],$pos,makeComment1($row, $document));
	}

	echo json_encode($data);

}else if($mode=='comment_load2'){

	$data = array();
	$begin_reply_char = 'A';

	$sql = "
		SELECT 
			a.*,
			b.picture_file_idx
		FROM 
			tblFlow_Comment as a
			LEFT JOIN tblMemberInfo AS b ON a.flowUserIdx = b.member_idx
		WHERE 
			cateIdx = '".$comment_cate."' and fIdx = '".$fidx."' and seq > '".$seq."'
		";
	$res = db_query($sql);
	while($row = db_fetch_array($res)){
		$row['newFlag'] = true;

		$last_char = substr($row['flowCommentDepth'], -1, 1);
		
		if($row['flowCommentIdx']==$begin_reply_char){
			$pos = $row['flowCommentIdx'].'_';
		}else if( $last_char == $begin_reply_char ){
			$pos = $row['flowCommentIdx'].'_'.substr($row['flowCommentDepth'], 0, -1);
		}else {
			$reply_char = chr(ord($last_char) - 1);
			$pos = $row['flowCommentIdx'].'_'.substr($row['flowCommentDepth'], 0, -1).$reply_char;
		}

		$data[] = array($row['flowCommentIdx'],$row['flowCommentDepth'],$pos,makeComment2($row, $document,$fidx));
	}

	echo json_encode($data);

}
else if($mode=='comment_index'){

	$sql = "SELECT MAX(seq) AS idx FROM tblFlow_Comment WHERE cateIdx = '".$comment_cate."' AND fIdx = '".$fidx."'";
	$res = db_query($sql);
	$row = db_fetch_array($res);

	if($row['idx']=="" || $row['idx']==null){
		echo 0;
	}else {
		echo $row['idx'];
	}
}



	
	exit;

?>
