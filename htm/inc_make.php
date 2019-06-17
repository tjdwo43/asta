<?php 
include "../inc/function.inc.php";

if($_POST[type] == "UserAdd"){
	

				$P_DIR = "/home/control";
				$H_DIR = "/home/samba";

				$user_id=trim($_POST[user_id]);
				$pass=trim($user_id);
				$user_name=trim($_POST[user_name]);

			   // $hashed_pass= openssl_digest($pass, 'sha512');
				$hashed_pass=crypt($pass,5000);

				global $P_DIR;
				global $H_DIR;

				$cmd=sprintf("%s/useradd  %s -g docu -p %s",$P_DIR, $user_id,$hashed_pass); 

				exec($cmd,$arr,$returnvar); 


	   if($returnvar !=9) {
                  //삼바계정 설정하기
					  $cmd = 'sudo echo -e "'.$user_id.'\n'.$user_id.'" | sudo smbpasswd -s -a '.$user_id;
					  exec($cmd);


				   // 계정정보 DB에 저장하기
				   
				   $today=date("Y-m-d");
				 
				   ########## 신청한 아이디와 동일한 아이디가 존재하는지 확인한다. ########## 
				   $qry = " select id from member where id ='$user_id' ";
				   $res = mysqli_query($qry);
					if (!$res) {
						 $result = 5;
						 echo $result;
					     exit;
				    }
				   $rows = mysqli_result($res,0,0);
				   if ($rows) {
					     $result = 6;
						 echo $result;
				         exit;
					}else{

					   ########## 신규아이디/이름 DB insert  ########## 
					   $qry = " insert into member set id='$user_id', name='$user_name' , pwd='$pass' , reg_date='$today', regdate=now() ,busu='$_POST[busu]', phone='$_POST[phone]', email='$_POST[email]' ";
					   $res = mysqli_query($qry);
						if (!$res) {
						$result = 5;
						echo $result;
					   exit;
					   }		
					}

					//fax 디렉토리 설정
						$cmd2=sprintf("%s/mkdir  -p %s/%s/fax",$P_DIR,$H_DIR,$user_id); 
						system($cmd2);
 					   $cmd="sudo chmod 777  /home/samba/".$user_id."/fax";
                        system($cmd);

					//scan 디렉토리 설정
						$cmd3=sprintf("%s/mkdir   %s/%s/scan",$P_DIR,$H_DIR,$user_id); 
						system($cmd3); 					  
					   $cmd="sudo chmod 777  /home/samba/".$user_id."/scan";
                       system($cmd);


					

					// 삼바 환경설정 
					  $cmd="sudo touch /etc/samba/config/".$user_id.".txt";
                       system($cmd);

					  $cmd="sudo chmod 777  /etc/samba/config/".$user_id.".txt";
                       system($cmd);

					  $cmd="echo [".$user_id."] >> /etc/samba/config/".$user_id.".txt";
					  system($cmd);
						$cmd="echo  comment = ".$user_id." >> /etc/samba/config/".$user_id.".txt";
					  system($cmd);
						$cmd="echo path = /home/samba/".$user_id."/  >> /etc/samba/config/".$user_id.".txt";
					  system($cmd);
						$cmd="echo valid users =".$user_id." >> /etc/samba/config/".$user_id.".txt";
					  system($cmd);
						$cmd="echo writable = yes >> /etc/samba/config/".$user_id.".txt";
					  system($cmd);
						$cmd="echo browseable = yes >> /etc/samba/config/".$user_id.".txt";
					  system($cmd);
						$cmd="echo create mask = 0777 >> /etc/samba/config/".$user_id.".txt";
					  system($cmd);
						$cmd="echo directory mask = 0777 >> /etc/samba/config/".$user_id.".txt";
					  system($cmd);
						$cmd="echo  read only = no >> /etc/samba/config/".$user_id.".txt";
					  system($cmd);

           // smb.conf 에 include	    	  
				       $cmd="echo    include = /etc/samba/config/".$user_id.".txt  >> /etc/samba/smb.conf";
					  exec($cmd);

	        //삼바 리스타트			
     				  $cmd="sudo /etc/init.d/samba restart";
					  exec($cmd);

		             $result = 1;
					 echo $result;
					 exit;

			}else 	 if($returnvar==9) {
					$result = 0;  
					 echo $result;
					 exit;
			}


}else if($_POST[type] == 'ChangePass'){

              $user_id =trim($_POST[id]);
              $new_pass = trim($_POST[new_pass]);
			  $now_pass = trim($_POST[now_pass]);
           
                   // 계정정보 DB에서 비번 변경하기
		   

			$qry = " select pwd from member where id='$user_id' ";
		    $result = mysqli_query($qry);
			if (!$result) {
				  $result=0;
				  echo $result;
		      exit;
		   }else {
				  $row = mysqli_fetch_array($result);
				  if(!$row[0]){
					   $result=0;
						echo $result;
					   exit;
					}else if($now_pass==$row[0]) {
				 
						   ########## 패스워드 변경. ########## 
						   $qry = " update member set pwd='$new_pass' where id ='$user_id' ";
						   $res = mysqli_query($qry);
							if (!$res) {
								 $result = 0;
								 echo $result;
								 exit;
							}
					}else{
						 $result=4;
						 echo $result;
					    exit;        
					}
							sleep(1);
							   //삼바계정 패스워드 변경하기
							  $cmd="./ch_pass.sh ".$user_id." ".$new_pass;
							  exec($cmd);
							sleep(1);
							
							   //리눅스계정 패스워드 변경하기
							  $cmd="./ch_pass2.sh ".$user_id." ".$new_pass;
							   exec($cmd);
	 	 }
                 
		           $result = 1;
	  	           echo $result;
                   exit;


}else if($_POST[type] == 'Stop'){
	$member_idx = $_POST['member_idx'];
	$stop = $_POST['stop'];
	
	$sql = "
SELECT
	*
FROM
	tblMemberInfo
WHERE
	member_idx = ".$member_idx."
	";
	$result = db_query( $sql );
	$row = db_fetch_array( $result );
	if( $row['member_idx'] ) {
		$sql = "
UPDATE
	tblMemberInfo
SET
	stop = '".$stop."'
WHERE
	member_idx = ".$member_idx;
		db_query( $sql );
	} else {
		$sql = "
INSERT INTO
	tblMemberInfo
(
	member_idx, stop
)
VALUES
(
	".$member_idx.", 'Y'
)
		";
		db_query( $sql );
	}
	
	echo '{"result":"success"}';
}else if($_POST[type] == 'DeleteId'){

                $user_id=$_POST[id];

              // 계정정보 DB에서 삭제하기
				   
				   $today=date("Y-m-d");
				 
				   ########## 계정 삭제. ########## 
				   $qry = " delete from member where id ='$user_id' ";
				   $res = mysqli_query($qry);
					if (!$res) {
						 $result = 5;
						 echo $result;
					     exit;
					}else{
					
					   //삼바계정 삭제하기
					   $cmd="sudo smbpasswd -x ".$user_id;
					   exec($cmd);  sleep(2);
                       
                      //리눅스계정 삭제하기
					   $cmd="sudo userdel  ".$user_id;
					   exec($cmd);  sleep(1);
									 
                      //디렉토리 삭제하기
					   $cmd="sudo rm -r /home/samba/".$user_id;
					   exec($cmd);  sleep(1);
					
					  //설정화일 삭제하기
					   $cmd="sudo rm /etc/samba/config/".$user_id.".txt";
					   exec($cmd);  sleep(1);
					
				      //삼바 리스타트			
     				  $cmd="sudo /etc/init.d/samba restart";
					  exec($cmd);
				
				
						 $result = 1;
						 echo $result;
					     exit;
					 }		
					

}else if($_POST[type] == 'AdminChange'){
         
		if($_POST[new_pass]){
						$user_id =trim($_POST[id]);
						$new_pass = trim($_POST[new_pass]);
			   
					   // 계정정보 DB에서 비번 변경하기
					   
					   $today=date("Y-m-d");
					 
					   ########## 비번변경. ########## 
					   $qry = " update member set pwd='$new_pass' ,busu='$_POST[busu]', phone='$_POST[phone]' , email='$_POST[email]'  where id ='$user_id' ";
					   $res = mysqli_query($qry);
						if (!$res) {
							 $result = "5";
							 echo $result;
							 exit;
						}
						
					   //삼바계정 패스워드 변경하기
						  $cmd="./ch_pass.sh ".$user_id." ".$new_pass;
						   exec($cmd);
						sleep(1);
						
						   //리눅스계정 패스워드 변경하기
						  $cmd="./ch_pass2.sh ".$user_id." ".$new_pass;
						   exec($cmd);
			  
					   

					   $result= "1";
					   echo "1";
					   exit;
		}else{
   			           
					   $qry = " update member set  busu='$_POST[busu]', phone='$_POST[phone]' , email='$_POST[email]'  where id ='$_POST[id]' ";
					   $res = mysqli_query($qry);
						if (!$res) {
							 $result = "5";
							 echo $result;
							 exit;
						}
						
					   $result= "1";
					   echo "1";
					   exit;

		  }
}

    exit;

?>
