<?
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	session_start();

	include $_SERVER["DOCUMENT_ROOT"]."/login/login.php";

	$mode = $_POST['mode'];

	switch ($mode) {
		case 'login' :
			$postArr = Array(
				'id' => $_POST["id"],
				'passwd' => base64_encode($_POST["passwd"])
			);
			//print_r($postArr);
			$apiResult = loginProc($postArr);
			//print_r($apiResult);

			$result = $apiResult['result'];

			if($result == 0){
				$_SESSION['user_seq'] = $apiResult['data']['seq'];
				$_SESSION['user_id'] = $apiResult['data']['id'];
				$_SESSION['user_name'] = $apiResult['data']['name'];
				$_SESSION['user_auth'] = $apiResult['data']['auth'];
				$_SESSION['user_email'] = $apiResult['data']['email'];
				$_SESSION['user_depart'] = $apiResult['data']['depart'];
				$_SESSION['user_orgCode'] = $apiResult['data']['org_code'];
				$_SESSION['user_phone'] = $apiResult['data']['phone'];
				$_SESSION['user_superId'] = $apiResult['data']['superId'] ?? "";
				$_SESSION['user_pushId'] = $apiResult['data']['pushId'] ?? "";
				$_SESSION['user_comment'] = $apiResult['data']['comment'] ?? "";
				$_SESSION['LAST_ACTIVITY'] = time();
			}

			if($result == 0){
				//echo '1';
				redirect("/index2.php");
			}else{
				redirect("/login/loginView.php?f=1");

				//echo '2';
			}

			break;
		case 'logout' :
			$authName = authName($_SESSION['user_auth']);

			$postData = Array(
						'seq' => $_SESSION['user_seq'],
						'id' => $_SESSION['user_id'],
						'name' => $_SESSION['user_name'],
						'depart' => $_SESSION['user_depart'],
						'phone' => $_SESSION['user_phone'],
						'org_code' => $_SESSION['user_orgCode'],
						'auth' => $authName
					);

			$apiResult = logoutProc($postData, $url);

			$result = $apiResult['result'];
			
			if($result == 0){
				session_destroy();
				unset($_COOKIE["loginYN"]);
			}

			echo $result;

			break;
	}
?>
