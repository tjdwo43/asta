<?php
$VERSION	= "V 1.1"; // 엑셀 저장 기능 추가함 2018/03/06
////////////////// WEB Login ////////////////////////////
$LOGIN_ADMIN				= "admin1234";
$LOGIN_ADMIN_PASS			= "admin!@#$";
////////////////// DB INFO ///////////////////////////////
$DB_HOST = "localhost";
$DB_USER = "ktug";
$DB_USER_PASS = "KTUG!@#";
$DB_NAME = "KTUGdb";

////////////////// FTP MAX ////////////////////////////
#max_clients=70 로 세팅함
$FTP_MAX_CLIENT				= 200;
$RETRY_TIME					= "3600";

/////////////// EVENT LIST ////////////////////////////
$UPDATE_STATUS_PREADY 		= "Ready";
$UPDATE_STATUS_CANCEL 		= "Cancel";
$UPDATE_STATUS_START 		= "Download";
$UPDATE_STATUS_UPDATE 		= "Update";
$UPDATE_STATUS_END_SUCCESS 	= "Success";
$UPDATE_STATUS_END_FAIL 	= "Fail";

////////////////// valid MODEL ////////////////////////////////////////
$HEAD_MAGIC 				= "bcbac7f6bdc3bdbac5db";
$HEAD_MODEL_IF1000			= "494631303030"; 
$HEAD_MODEL_IF2000			= "494632303030"; 
$HEAD_MODEL_IPG100			= "495047313030"; 
$HEAD_MODEL_ACU100			= "414355313030"; 
$HEAD_MODEL_OTR620			= "4f5452363230"; 

////////////////////////////////////////////////////////////////////
$MODEL_IF1000				= "IF1000";
$MODEL_IF2000				= "IF2000";
$MODEL_IPG100				= "IPG100";
$MODEL_ACU100				= "ACU100";
$MODEL_OTR620				= "OTR620";

////////////////////////////////////////////////////////////////////


$TARGET_DIR = "/home/ftpuser/";
?>
