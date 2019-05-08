<?	
	session_start();
	include $_SERVER["DOCUMENT_ROOT"]."/inc/fnc.php";
	include $_SERVER["DOCUMENT_ROOT"]."/schedule/scheduleApi.php";
	
	$mode = $_POST['mode'];

	switch ($mode){
		case 'updateTemplate' :	//일일 템플릿 수정
			$hourArr = array();
			$minArr = array();
			
			$hourArr = json_decode($_POST['hour']);
			$minArr = json_decode($_POST['min']);
			$confCheckbox = json_decode($_POST['confCheckbox']);
			$confType = '1';
			//$confType = json_decode($_POST['confType']);

			$postData = Array(
				'tempName' => $_POST['tempName'],
				'v1stSH' => ($confCheckbox[0] == '1')?$hourArr[0]:0,
				'v1stSM' => ($confCheckbox[0] == '1')?$minArr[0]:0,
				'v1stEH' => ($confCheckbox[0] == '1')?$hourArr[1]:0,
				'v1stEM' => ($confCheckbox[0] == '1')?$minArr[1]:0,
				'v1stType' => '1',
				'v2ndSH' => ($confCheckbox[1] == '1')?$hourArr[2]:0,
				'v2ndSM' => ($confCheckbox[1] == '1')?$minArr[2]:0,
				'v2ndEH' => ($confCheckbox[1] == '1')?$hourArr[3]:0,
				'v2ndEM' => ($confCheckbox[1] == '1')?$minArr[3]:0,
				'v2ndType' => '1',
				'v3rdSH' => ($confCheckbox[2] == '1')?$hourArr[4]:0,
				'v3rdSM' => ($confCheckbox[2] == '1')?$minArr[4]:0,
				'v3rdEH' => ($confCheckbox[2] == '1')?$hourArr[5]:0,
				'v3rdEM' => ($confCheckbox[2] == '1')?$minArr[5]:0,
				'v3rdType' => '1',
				'v4thSH' => ($confCheckbox[3] == '1')?$hourArr[6]:0,
				'v4thSM' => ($confCheckbox[3] == '1')?$minArr[6]:0,
				'v4thEH' => ($confCheckbox[3] == '1')?$hourArr[7]:0,
				'v4thEM' => ($confCheckbox[3] == '1')?$minArr[7]:0,
				'v4thType' => '1',
				'v5thSH' => ($confCheckbox[4] == '1')?$hourArr[8]:0,
				'v5thSM' => ($confCheckbox[4] == '1')?$minArr[8]:0,
				'v5thEH' => ($confCheckbox[4] == '1')?$hourArr[9]:0,
				'v5thEM' => ($confCheckbox[4] == '1')?$minArr[9]:0,
				'v5thType' => '1',
				'seq' => $_POST['seq']
			);
			
			$apiResult = updateTS($postData);

			echo $apiResult['result'];
			break;
		case 'saveTemplate' :	//일일 템플릿 추가 저장
			$hourArr = array();
			$minArr = array();
			
			$hourArr = json_decode($_POST['hour']);
			$minArr = json_decode($_POST['min']);
			$confCheckbox = json_decode($_POST['confCheckbox']);

			//$confType = $_POST['confType']; 항상 ON

			$postData = Array(
				'tempName' => $_POST['tempName'],
				'v1stSH' => ($confCheckbox[0] == '1')?$hourArr[0]:0,
				'v1stSM' => ($confCheckbox[0] == '1')?$minArr[0]:0,
				'v1stEH' => ($confCheckbox[0] == '1')?$hourArr[1]:0,
				'v1stEM' => ($confCheckbox[0] == '1')?$minArr[1]:0,
				'v1stType' => '1',
				'v2ndSH' => ($confCheckbox[1] == '1')?$hourArr[2]:0,
				'v2ndSM' => ($confCheckbox[1] == '1')?$minArr[2]:0,
				'v2ndEH' => ($confCheckbox[1] == '1')?$hourArr[3]:0,
				'v2ndEM' => ($confCheckbox[1] == '1')?$minArr[3]:0,
				'v2ndType' => '1',
				'v3rdSH' => ($confCheckbox[2] == '1')?$hourArr[4]:0,
				'v3rdSM' => ($confCheckbox[2] == '1')?$minArr[4]:0,
				'v3rdEH' => ($confCheckbox[2] == '1')?$hourArr[5]:0,
				'v3rdEM' => ($confCheckbox[2] == '1')?$minArr[5]:0,
				'v3rdType' => '1',
				'v4thSH' => ($confCheckbox[3] == '1')?$hourArr[6]:0,
				'v4thSM' => ($confCheckbox[3] == '1')?$minArr[6]:0,
				'v4thEH' => ($confCheckbox[3] == '1')?$hourArr[7]:0,
				'v4thEM' => ($confCheckbox[3] == '1')?$minArr[7]:0,
				'v4thType' => '1',
				'v5thSH' => ($confCheckbox[4] == '1')?$hourArr[8]:0,
				'v5thSM' => ($confCheckbox[4] == '1')?$minArr[8]:0,
				'v5thEH' => ($confCheckbox[4] == '1')?$hourArr[9]:0,
				'v5thEM' => ($confCheckbox[4] == '1')?$minArr[9]:0,
				'v5thType' => '1',
				'id' => $_SESSION['user_id'],
				'org_code' => $_SESSION['user_orgCode']
			);
			
			$apiResult = addTS($postData);

			echo $apiResult['result'];
			break;
		case 'delTemplate' :	//일일 템플릿 삭제
			$postData  = array(
				'seqs' => $_POST['seqs']
			);

			$apiResult = delTS($postData);

			echo $apiResult['result'];
			
			break;
		case 'saveWTemplate' :
			$dayTemp = array();
			
			$dayTemp = json_decode($_POST['dayTemp']);

			$postData = array(
				'wTempName' => $_POST['tempWName'],
				'monTemp' => $dayTemp[0],
				'tueTemp' => $dayTemp[1],
				'wedTemp' => $dayTemp[2],
				'thuTemp' => $dayTemp[3],
				'friTemp' => $dayTemp[4],
				'satTemp' => $dayTemp[5],
				'sunTemp' => $dayTemp[6],
				'id' => $_SESSION['user_id'],
				'org_code' => $_SESSION['user_orgCode']
			);

			$apiReulst = addWTS($postData);

			echo $apiResult['result'];
			
			break;
		case 'updateWTemplate' :
			$dayTemp = array();
			
			$dayTemp = json_decode($_POST['dayTemp']);

			$postData = array(
				'wTempName' => $_POST['tempWName'],
				'monTemp' => $dayTemp[0],
				'tueTemp' => $dayTemp[1],
				'wedTemp' => $dayTemp[2],
				'thuTemp' => $dayTemp[3],
				'friTemp' => $dayTemp[4],
				'satTemp' => $dayTemp[5],
				'sunTemp' => $dayTemp[6],
				'seq' => $_POST['seq']
			);
			
			$apiReulst = updateWTS($postData);

			echo $apiResult['result'];
			break;
		case 'deleteWTemplate' :
			$postData  = array(
				'seqs' => $_POST['seqs']
			);

			$apiResult = delWTS($postData);

			echo $apiResult['result'];
			
			break;
	}
?>