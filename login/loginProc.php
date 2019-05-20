<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include_once $_SERVER["DOCUMENT_ROOT"]."/inc/fnc.php";
include $_SERVER["DOCUMENT_ROOT"]."/login/login.php";
include $_SERVER["DOCUMENT_ROOT"]."/user/user.php";

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
			$_SESSION['user_grade'] = $apiResult['data']['grade'] ?? "";
			$_SESSION['user_lastOrg'] = $apiResult['data']['lastOrg_Code'] ?? "";
			$_SESSION['LAST_ACTIVITY'] = time();
		}

		if($result == 0){
			if($_SESSION['user_auth'] == '4'){
				$authName = "관리자 A";
			}else if($_SESSION['user_auth'] == '3'){
				$authName = "관리자 B";
			}else if($_SESSION['user_auth'] == '2'){
				$authName = "사용자 A";
			}else{
				$authName = "사용자 B";
			}

			$seq = $_SESSION['user_seq'];
			$name = $_SESSION['user_name'];
			$auth = $_POST['auth'] ?? $_SESSION['user_auth'];
			$comment = $_POST['comment'] ?? $_SESSION['user_comment'];
			$pushId = ($_POST['keyword'] == '') ? $_SESSION['user_pushId']:$_POST['keyword'];
			$grade = $_SESSION['user_grade'];

			$sessionPhone = empty($_SESSION['user_phone']) ?? "0" ;
			$sessionDepart = empty($_SESSION['user_depart']) ?? "0" ;
			$sessionEmail = empty($_SESSION['user_email']) ?? "0" ;

			$postData2 = Array(
				'seq' => $seq,
				'name' => $name,
				'phone' => $sessionPhone,
				'email' => $sessionEmail,
				'auth'	=> $auth,
				'comment' => $comment,
				'id' => $_SESSION['user_id'],
				'nameM' => $name,
				'departM' => $sessionDepart,
				'phoneM' => $sessionPhone,
				'authM' =>  $authName,
				'org_code' => $_SESSION['user_orgCode'],
				'idM' => $_SESSION['user_id'],
				'pushId' => $pushId,
				'grade' => $grade,
				'passwd' => ''
			);

			$apiResult2 = updateUser($postData2);

			if($_POST["deviceType"] == "mobile"){
				redirect("/m/buildingView.php");
			}else {
				redirect("/index2.php");
			}

		}else{
			if($_POST["deviceType"] == "mobile") {
				redirect("/m/?f=1");
			}else {
				redirect("/login/loginView.php?f=1");
			}

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
	case 'checkPasswd' :
		$postArr = Array(
			'id' => $_SESSION["user_id"],
			'passwd' => base64_encode($_POST["currentPasswd"])
		);
		//print_r($postArr);
		$apiResult = loginProc($postArr);
		//print_r($apiResult);

		$result = $apiResult['result'];
		echo $result;
		break;
	default :
		echo '일치하는 모드가 없습니다.';
		break;
}
?>
