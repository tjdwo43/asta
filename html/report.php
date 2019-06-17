<?php
	include "db.php";

	//$tmp="0025C2827E8F_IF1000_IF1000_0_1_T1.5.4_192.168.000.215_192.168.000.001_255.255.255.000_Off_사용안함_None<br>";

	//echo $tmp;

	$list = explode ("_", $_POST[tmp]);
	//$list = explode("_", $tmp);


	if(count($list) == 6)
	{
		$MAC			=iconv("euckr","utf-8",$list[0]); // MAC
		$MODEL			=iconv("euckr","utf-8",$list[1]); // MODEL
		$NAME			=iconv("euckr","utf-8",$list[2]); // 리더기 이름
		$VERSION 		=iconv("euckr","utf-8",$list[3]); // 버전 
		$STATUS 		=iconv("euckr","utf-8",$list[4]); // 상태 
		$FAIL_REASON	=iconv("euckr","utf-8",$list[5]); // 상태 
	}
	else if(count($list) == 7)
	{
		$MAC			=iconv("euckr","utf-8",$list[0]); // MAC
		$MODEL			=iconv("euckr","utf-8",$list[1]); // MODEL

		$NAME			=iconv("euckr","utf-8",$list[2]); // 리더기 이름
		$NAME			=$NAME."_".iconv("euckr","utf-8",$list[3]); // 리더기 이름

		$VERSION 		=iconv("euckr","utf-8",$list[4]); // 버전 
		$STATUS 		=iconv("euckr","utf-8",$list[5]); // 상태 
		$FAIL_REASON	=iconv("euckr","utf-8",$list[6]); // 상태 

	}
	else if(count($list) == 8)
	{
		$MAC			=iconv("euckr","utf-8",$list[0]); // MAC
		$MODEL			=iconv("euckr","utf-8",$list[1]); // MODEL

		$NAME			=iconv("euckr","utf-8",$list[2]); // 리더기 이름
		$NAME			=$NAME."_".iconv("euckr","utf-8",$list[3]); // 리더기 이름
		$NAME			=$NAME."_".iconv("euckr","utf-8",$list[4]); // 리더기 이름

		$VERSION 		=iconv("euckr","utf-8",$list[5]); // 버전 
		$STATUS 		=iconv("euckr","utf-8",$list[6]); // 상태 
		$FAIL_REASON	=iconv("euckr","utf-8",$list[7]); // 상태 

	}
	else
	{
		echo "Fail list count";
		exit;
	}

	$Connection = mysqli_connect($DB_HOST,$DB_USER,$DB_USER_PASS, $DB_NAME);
	if(!$Connection)
	{
		$error = mysqli_connect_error(); 
		$errno = mysqli_connect_errno(); 
		echo "$errno: $error\n";
		exit();
	}

	if( $STATUS == $UPDATE_STATUS_START)
	{
		echo $UPDATE_STATUS_START;

	}
	else if( $STATUS == $UPDATE_STATUS_END_SUCCESS)
	{
		echo $UPDATE_STATUS_END_SUCCESS;
	}
	else if( $STATUS == $UPDATE_STATUS_UPDATE)
	{
		echo $UPDATE_STATUS_UPDATE;
	}
	else if( $STATUS == $UPDATE_STATUS_END_FAIL)
	{
		echo $UPDATE_STATUS_END_FAIL;
	}
	else
	{
		echo "Fail Unknow";
		mysqli_close($Connection);
		exit;
	}

	// (tmp=0025C2827E8F_IF1000_IF1000_0_1_T1.5.4_192.168.000.215_192.168.000.001_255.255.255.000_Off_사용안함_None)
	$select_sql ="select * from Table_Update_List where Reader_Conf_Mac='".$MAC."'";
	$result=mysqli_query($Connection, $select_sql);
	$FILENAME="-";
	if($result)
	{
		$Count=mysqli_num_rows($result);
		if($Count == 1)
		{
			$row=mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			$FILENAME=$row[FileName];

			$sql = "update Table_Update_List  set Reader_Status='".$STATUS."' where Reader_Conf_Mac='".$MAC."'";
			echo "@Success Update";
			$result=mysqli_query($Connection, $sql);
		}
		else
		{
			// pass
			echo "@Success PASS";
		}

		// Update
		$SQL = "insert into Table_History_Update(Reader_Conf_Mac, Reader_Conf_Model, Reader_Conf_Name, Reader_Conf_Version, Reader_Status, Fail_Reason, FileName, UserId, UpdateDate) values('";
		$insert_sql=$SQL.$MAC."','".$MODEL."','".$NAME."', '".$VERSION."','".$STATUS."','".$FAIL_REASON."','".$FILENAME."','-', now())";
		$result=mysqli_query($Connection, $insert_sql);
		if($result)
		{
			echo "@Success History";

		}
	}

	
	if( $STATUS == $UPDATE_STATUS_END_SUCCESS)
	{
		$delete_sql ="delete from Table_Update_List where Reader_Conf_Mac='".$MAC."'";
		$result=mysqli_query($Connection, $delete_sql);


		unlink($TARGET_DIR.$MAC);
		echo "@delete ".$MAC;
	}
	 
	mysqli_close($Connection);
?>
