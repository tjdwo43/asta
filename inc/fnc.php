<?
function p(){ // .... p($COOKIE);
	$args = func_get_args();
	echo "<div><pre>= RESULT =\n";
	if(is_array($args)){
		$i = 0;
		foreach($args as $tgt){
			echo "[param:" . (++$i) . "]\n";
			print_r($tgt);
			echo "\n";
		}
	}
	echo "</pre></div>";
}

function callRestApi( $data = Array(), $pUrl ){	//Rest API 호출
	$frUrl = "http://arms.astaibs.co.kr:8080";
	//$frUrl = "http://58.225.16.36:8080";

	$fullUrl = $frUrl.$pUrl;
	
	// Set the POST data
	$postdata = http_build_query( $data );
 
	// Set the POST options
	$opts = array('http' => 
		array (
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postdata
		)
	);
 
	// Create the POST context
	$context  = stream_context_create($opts);
 
	// POST the data to an api
	$apiResult = file_get_contents($fullUrl, false, $context);

	$apiResultArr = Array();
	$apiResultArr = json_decode($apiResult, true);

	return $apiResultArr;
}

// 암호화함수
function Encrypt($str, $secret_key='secret key', $secret_iv='secret iv')
{
	$key = hash('sha256', $secret_key);

	echo 'key';
	p($key);

	$iv = substr(hash('sha256', $secret_iv), 0, 32);
	echo 'iv';
	p($iv);
	
	echo 'openssl_encrypt';
	p(openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv));

	echo 'base64_encode';
	p( base64_encode(
				 openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv)));

	echo 'str_relace';
	p(str_replace("=", "", base64_encode(
				 openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv))
    ));

	return str_replace("=", "", base64_encode(
				 openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv))
    );
}


function Decrypt($str, $secret_key='secret key', $secret_iv='secret iv')
{
	$key = hash('sha256', $secret_key);

	echo 'key';
	p($key);


	$iv = substr(hash('sha256', $secret_iv), 0, 32);

	echo 'iv';
	p($iv);
	
	echo 'base64';
	p(base64_decode($str));

	echo 'openssl_decrypt';
	p(openssl_decrypt(
			base64_decode($str), "AES-256-CBC", $key, 0, $iv
	));

	return openssl_decrypt(
			base64_decode($str), "AES-256-CBC", $key, 0, $iv
	);
}

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}

function authName($authCode){
	if($authCode == '4'){
		$authName = "관리자 A";
	}else if($authCode == '3'){
		$authName = "관리자 B";
	}else if($authCode == '2'){
		$authName = "사용자 A";
	}else{
		$authName = "사용자 B";
	}

	return $authName;
}

function sessionTimeout(){
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
		// last request was more than 5 minutes ago
		session_unset();     // unset $_SESSION variable for the run-time
		session_destroy();   // destroy session data in storage

		return;
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
}
/*
function checkMobile(){
	//Check Mobile
	$mAgent = array("iPhone","iPod","Android","Blackberry", 
		"Opera Mini", "Windows ce", "Nokia", "sony" );
	$chkMobile = false;
	for($i=0; $i<sizeof($mAgent); $i++){
		if(stripos( $_SERVER['HTTP_USER_AGENT'], $mAgent[$i] )){
			$chkMobile = true;
			break;
		}
	}

	return $chkMobile;
}
*/
?>