<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include_once $_SERVER["DOCUMENT_ROOT"]."/inc/fnc.php";
include $_SERVER["DOCUMENT_ROOT"]."/login/login.php";
include $_SERVER["DOCUMENT_ROOT"]."/user/user.php";
include_once $_SERVER['DOCUMENT_ROOT']."/building/building.php";

$mode = $_POST['mode'];

switch ($mode) {
	case 'login' :

		$postArr = Array(
			'id' => $_POST["id"],
			'passwd' => base64_encode($_POST["passwd"])
		);

		//print_r($postArr);
		$apiResult = loginProc($postArr);

		$result = $apiResult['result'];

		//p($_POST);

		if($result == '0'){
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
			$_SESSION['user_useYN'] = $apiResult['data']['useyn'] ?? "";
			$_SESSION['LAST_ACTIVITY'] = time();

			if($_SESSION['user_auth'] == '4'){
				$authName = "수퍼 관리자";
			}else if($_SESSION['user_auth'] == '3'){
				$authName = "관리자";
			}else if($_SESSION['user_auth'] == '2'){
				$authName = "일반";
			}else{
				$authName = "디바이스";
			}

			if($_SESSION['user_lastOrg'] == ""){

				$orgCode = explode(",", $_SESSION['user_orgCode']);


				$postData = Array(
					'seq' => $_SESSION['user_seq'],
					'org_code' => $orgCode[count($orgCode)-1]
				);

				$buildingLastIdg = setBuildingBIdg($postData);

				$_SESSION['user_lastOrg'] = $orgCode[count($orgCode)-1];

				//$buildingLastIdg = setBuildingBIdg($postData);
			}

			$seq = $_SESSION['user_seq'];
			$name = $_SESSION['user_name'];
			$auth = $_SESSION['user_auth'];
			$comment = $_SESSION['user_comment'];
			$pushId = ($_POST['keyword'] == '') ? $_SESSION['user_pushId']:$_POST['keyword'];
			$grade = $_SESSION['user_grade'];

			//p($pushId);

			$sessionPhone = ($_SESSION['user_phone']) ?? "" ;
			$sessionDepart = ($_SESSION['user_depart']) ?? "" ;
			$sessionEmail = ($_SESSION['user_email']) ?? "" ;

			$postData2 = Array(
				'seq' => $seq,
				'name' => $name,
				'phone' => $sessionPhone,
				'email' => $sessionEmail,
				'auth'	=> '5',
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
				'passwd' => $_POST["passwd"],
				'depart'=> ($_SESSION['user_depart'] == '')?'':$_SESSION['user_depart']
			);

			$apiResult2 = updateUser($postData2);

			if($_POST["deviceType"] == "mobile"){
				if($_SESSION['user_useYN'] == 'Y'){
					redirect("/m/changePasswd.php?s=1");
				}else{
					redirect("/m/monitoringView.php");
				}
			}else {
				if($_SESSION['user_useYN'] == 'Y'){
					redirect("/index2.php?s=1");
				}else{
					redirect("/device/monitor_view.php");
				}

			}

		}else if($result == '1'){
			if($_POST["deviceType"] == "mobile") {
				redirect("/m/?f=1");
			}else {
				redirect("/login/loginView.php?f=1");
			}
			//echo '2';
		}else{
			if($_POST["deviceType"] == "mobile") {
				redirect("/m/?f=2");
			}else {
				redirect("/login/loginView.php?f=2");
			}
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
			'auth' => $authName,
			'org_name' => $_POST["org_name"]
		);

		$apiResult = logoutProc($postData, $url);

		$result = $apiResult['result'];

		session_destroy();
		unset($_COOKIE["loginYN"]);

		echo $result;

		break;
	case 'checkPasswd' :
		$postArr = Array(
			'id' => ($_POST["id"])?$_POST['id']:$_SESSION["user_id"],
			'passwd' => base64_encode($_POST["currentPasswd"])
		);
		//print_r($postArr);
		$apiResult = loginProc($postArr);
		//print_r($apiResult);

		$result = $apiResult['result'];
		echo $result;
		break;
	case 'mobileCheckPasswd' :
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
