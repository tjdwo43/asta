<?
	$frUrl = "http://dev.sh-system.co.kr:8080";
	//$frUrl = "http://58.225.16.36:8080";
	$pUrl = "/ASTA-API/api/user/updateUser";

	$fullUrl = $frUrl.$pUrl;

	$data = Array(
				'seq' => '226',
				'name' => 'test',
				'phone' => '',
				'email' => '',
				'auth'	=> '3',
				'comment' => 'tttt',
				'id' => 'asta',
				'nameM' => 'test',
				'departM' => '',
				'phoneM' => '',
				'authM' => '관리자 A',
				'org_code' => '0000001',
				'idM' => 'test',
				'pushId' => ''
	);
	
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

	//p($opts);
 
	// POST the data to an api
	$apiResult = file_get_contents($fullUrl, false, $context);

	$apiResultArr = Array();
	$apiResultArr = json_decode($apiResult, true);

	print_r($apiResultArr);
?>