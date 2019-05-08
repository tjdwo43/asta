<?php
	include "db.php";

	//$tmp="0025C2827E8F_IF1000_IF1000_0_1_T1.5.4_192.168.000.215_192.168.000.001_255.255.255.000_Off_사용안함_None<br>";

	//echo $tmp;

	$list = explode ("_", $_POST[tmp]);
	//$list = explode("_", $tmp);

	if(count($list) == 12)
	{
		$MAC		=iconv("euckr","utf-8",$list[0]);
		$MODEL		=iconv("euckr","utf-8",$list[1]); 
		$NAME		=iconv("euckr","utf-8",$list[2]);
		$ID			=iconv("euckr","utf-8",$list[3]);
		$VERSION	=iconv("euckr","utf-8",$list[4]);
		$SYS_ID		=iconv("euckr","utf-8",$list[5]);
		$STATIC_IP	= $_SERVER['REMOTE_ADDR'];
		$IP			=iconv("euckr","utf-8",$list[6]);
		$GATEWAY	=iconv("euckr","utf-8",$list[7]);
		$SUBNET		=iconv("euckr","utf-8",$list[8]);
		$DHCP		=iconv("euckr","utf-8",$list[9]);
		$CMS		=iconv("euckr","utf-8",$list[10]);
		$CMS_STATUS	=iconv("euckr","utf-8",$list[11]);
	}
	else if(count($list) == 13)
	{
		$MAC		=iconv("euckr","utf-8",$list[0]);
		$MODEL		=iconv("euckr","utf-8",$list[1]); 

		$NAME		=iconv("euckr","utf-8",$list[2]);
		$NAME		=$NAME."_".iconv("euckr","utf-8",$list[3]);

		$ID			=iconv("euckr","utf-8",$list[4]);
		$VERSION	=iconv("euckr","utf-8",$list[5]);
		$SYS_ID		=iconv("euckr","utf-8",$list[6]);
		$STATIC_IP	= $_SERVER['REMOTE_ADDR'];
		$IP			=iconv("euckr","utf-8",$list[7]);
		$GATEWAY	=iconv("euckr","utf-8",$list[8]);
		$SUBNET		=iconv("euckr","utf-8",$list[9]);
		$DHCP		=iconv("euckr","utf-8",$list[10]);
		$CMS		=iconv("euckr","utf-8",$list[11]);
		$CMS_STATUS	=iconv("euckr","utf-8",$list[12]);
	}
	else if(count($list) == 14)
	{
		$MAC		=iconv("euckr","utf-8",$list[0]);
		$MODEL		=iconv("euckr","utf-8",$list[1]); 

		$NAME		=iconv("euckr","utf-8",$list[2]);
		$NAME		=$NAME."_".iconv("euckr","utf-8",$list[3]);
		$NAME		=$NAME."_".iconv("euckr","utf-8",$list[4]);

		$ID			=iconv("euckr","utf-8",$list[5]);
		$VERSION	=iconv("euckr","utf-8",$list[6]);
		$SYS_ID		=iconv("euckr","utf-8",$list[7]);
		$STATIC_IP	= $_SERVER['REMOTE_ADDR'];
		$IP			=iconv("euckr","utf-8",$list[8]);
		$GATEWAY	=iconv("euckr","utf-8",$list[9]);
		$SUBNET		=iconv("euckr","utf-8",$list[10]);
		$DHCP		=iconv("euckr","utf-8",$list[11]);
		$CMS		=iconv("euckr","utf-8",$list[12]);
		$CMS_STATUS	=iconv("euckr","utf-8",$list[13]);
	}
	else
	{
		echo "Fail list count";
		exit;
	}
	

	if($MAC == "")
	{
		echo "unknow access";
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

	$select_sql ="select * from Table_Update_List where Reader_Conf_Mac='".$MAC."'";
	$result=mysqli_query($Connection, $select_sql);
	if($result)
	{
		$Count=mysqli_num_rows($result);
		if($Count == 1)
		{
			$row=mysqli_fetch_assoc($result);

			if( $row[Reader_Status] == $UPDATE_STATUS_END_SUCCESS)
			{
				$delete_sql ="delete from Table_Update_List where Reader_Conf_Mac='".$MAC."'";
				$result=mysqli_query($Connection, $delete_sql);

				unlink($TARGET_DIR.$MAC);
				echo "@delete ".$MAC;
			}
			mysqli_free_result($result);
		}
	}

	// (tmp=0025C2827E8F_IF1000_IF1000_0_1_T1.5.4_192.168.000.215_192.168.000.001_255.255.255.000_Off_사용안함_None)
	$select_sql ="select * from Table_Reader where Reader_Conf_Mac='".$MAC."'";
	$result=mysqli_query($Connection, $select_sql);
	if($result)
	{
		$Count=mysqli_num_rows($result);
		if($Count == 1)
		{
			$sql = "update Table_Reader set Reader_Conf_Mac='".$MAC."', Reader_Conf_Model='".$MODEL."', Reader_Conf_Name='".$NAME."', Reader_Conf_Id='".$ID."', Reader_Conf_Version='".$VERSION."', Reader_Dms_sysid='".$SYS_ID."', Reader_Net_StaticIp='".$STATIC_IP."', Reader_Net_Ip='".$IP."', Reader_Net_Gateway='".$GATEWAY."', Reader_Net_Subnet='".$SUBNET."', Reader_Net_Dhcp='".$DHCP."', Reader_Cms='".$CMS."', Reader_Cms_Status='".$CMS_STATUS."',UpdateDate=now() where Reader_Conf_Mac='".$MAC."'";
			echo "sql Update,";
		}
		else
		{
			$sql = "insert into Table_Reader values('".$MAC."','".$MODEL."','".$NAME."','".$ID."','".$VERSION."','".$SYS_ID."','".$STATIC_IP."','".$IP."','".$GATEWAY."','".$SUBNET."','".$DHCP."','".$CMS."','".$CMS_STATUS."', now())";
			echo "sql Insert,";
		}
		$result=mysqli_query($Connection, $sql);

		////////////////////////////////////////////////////////
		$limit_check_sql ="select * from Table_Update_List";
		$result=mysqli_query($Connection, $limit_check_sql);
		$Count=mysqli_num_rows($result);

		echo "Cur=".$Count.",Max=".$FTP_MAX_CLIENT.",";
		if($Count > $FTP_MAX_CLIENT)
		{
			echo "@CMD_Retry:".$RETRY_TIME."\x0";
			mysqli_close($Connection);
			exit;
		}

		// Update Check
		$update_chk_sql ="select * from Table_Update_List where Reader_Conf_Mac='".$MAC."'";
		$result=mysqli_query($Connection, $update_chk_sql);
		if($result)
		{
			$Count=mysqli_num_rows($result);
			if($Count== "1")
			{
				$row=mysqli_fetch_assoc($result);
				//echo "@CMD_File:".$row[FileName]."\x0";
				echo "@CMD_File:".$MAC."\x0";
				echo "@CMD_Size:".$row[FileSize]."\x0";
				mysqli_free_result($result);
				mysqli_close($Connection);
				exit;
			}
			// 모델 체크 
			$rule_chk_sql ="select * from Table_Update_Rule_List where Rule_Model='".$MODEL."'";
			//echo $rule_chk_sql;
			$result=mysqli_query($Connection, $rule_chk_sql);

			$row_Rule=mysqli_fetch_assoc($result);
			$Count=mysqli_num_rows($result);

			if($Count == "0")
			{
				echo "no Rule"; //(".$VERSION."),(".trim($row_Rule[FileVersion]).")";
				mysqli_close($Connection);
				exit;
			}
			if($VERSION[0] == "C")
			{
				echo "Custom pass"; //(".$VERSION."),(".trim($row_Rule[FileVersion]).")";
				mysqli_close($Connection);
				exit;
			}
			echo "Rule,"; //(".$VERSION."),(".trim($row_Rule[FileVersion]).")";

			$RULE_CMS = trim($row_Rule[Rule_Cms]);
			$RULE_VER = trim($row_Rule[Rule_Version]);

			if($VERSION == trim($row_Rule[FileVersion]))
			{
				echo "already Update";
				mysqli_close($Connection);
				exit;
			}
			//echo $VERSION.",".trim($row_Rule[FileVersion]).",".trim($row_Rule[Rule_Version]).",".trim($row_Rule[Rule_Cms]).",".$list[10].",";
			// 주장치 타입 체크 
			if($RULE_CMS != "-")
			{
				echo "CMS(".$RULE_CMS."),";
				if($RULE_CMS != $CMS)
				{
					echo "@EXIT(".$list[10].")";
					mysqli_close($Connection);
					exit;
				}
			}
			if($RULE_VER != "-")
			{
				echo "VER(".$RULE_VER."),";
				if($RULE_VER != $VERSION)
				{
					echo "@EXIT(".$list[4].")";
					mysqli_close($Connection);
					exit;
				}	
			}
			echo "Ready";
			copy( $TARGET_DIR.$row_Rule[Rule_Model],  $TARGET_DIR.$MAC);
			$insert_sql ="insert into Table_Update_List values('".$MAC."','".$MODEL."','".$VERSION."','".$UPDATE_STATUS_PREADY."','".$row_Rule[FileName]."','".$row_Rule[FileSize]."','".$row_Rule[UserId]."', now())";		
			$result=mysqli_query($Connection, $insert_sql);
				
			echo "@CMD_File:".$MAC."\x0";
			echo "@CMD_Size:".$row_Rule[FileSize]."\x0";

			$insert_sql = "insert into Table_History_Update(Reader_Conf_Mac, Reader_Conf_Model, Reader_Conf_Name, Reader_Conf_Version, Reader_Status, Fail_Reason, FileName, UserId, UpdateDate) values('";
			$insert_sql=$insert_sql.$MAC."','".$MODEL."','-','-','".$UPDATE_STATUS_PREADY."', '-', '".$$row_Rule[FileName]."','".$row_Rule[UserId]."', now())";
			$result=mysqli_query($Connection, $insert_sql);

			mysqli_free_result($result);
		}
		mysqli_close($Connection);
	}
?>
