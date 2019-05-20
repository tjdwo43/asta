<?	
	session_start();

	include_once $_SERVER[DOCUMENT_ROOT]."/inc/fnc.php";
	include_once $_SERVER[DOCUMENT_ROOT]."/user/user.php";

	$mode = $_POST['mode'];

	switch($mode) {
        case 'getUserList' :
            //좌측 유저 리스트
            $postData = Array(
                'org_code' => $_POST['orgCode'],
                'auth'	=>	$_SESSION['user_auth'],
                'superId' => ($_SESSION['user_auth'] == 4)?"":$_SESSION['user_seq']
            );

            $userList = getListUser($postData);

            $userListJson = json_encode($userList);

            echo $userListJson;

            break;
		case 'registerUser' :
		    $grade = $_POST["depart"] ?? "미입력";
			$postData = Array(
				'id' => $_POST['id'],
				'passwd' => $_POST['passwd'],
				'name' => $_POST['name'],
				'org_code' => $_POST['org_code'],
				'phone' => ($_POST['phone'])?$_POST['phone']:"",
				'email' => ($_POST['email'])?$_POST['email']:"",
				'auth' => $_POST['auth'],
				'comment' => ($_POST['comment'])?$_POST['comment']:'',
				'superId' => $_POST['superId'],
				'depart' => $_POST['depart'],
                'grade' => $grade
			);

			$apiResult = registerUser($postData);

			if($apiResult[result] == 0){
				$result[html] =		'<li>';
				$result[html] .=		'<a href="#'.$apiResult[data][seq].'" class="getUserInfo" data-userSeq="'.$apiResult[data][seq].'">'; 
				$result[html] .=			'<div class="checkbox c-checkbox d-inline-block">';
				$result[html] .=				'<label>';
				$result[html] .=					'<input type="checkbox" name="checkOne" value="'.$apiResult[data][seq].'">';
				$result[html] .=					'<span class="fa fa-check"></span>';
				$result[html] .=				'</label>';
				$result[html] .=			'</div>';
				$result[html] .=			'<span>'.$apiResult[data][name].' ['.$apiResult[data][org_code].']</span>';
				$result[html] .=		'</a>';
				$result[html] .=	'</li>';
			}
			
			$result[data] = $apiResult[data];

			$result[seq] = $apiResult[data][seq];

			$result[resultVal] = $apiResult[result];
			
			echo json_encode($result, JSON_UNESCAPED_SLASHES);

			break;
		case 'delUser' :							//회원 정보 삭제
			$phoneNum = $_POST['phoneNum'] ?? "";

			if($_SESSION['user_auth'] == '4'){
				$authName = "관리자 A";
			}else if($_SESSION['user_auth'] == '3'){
				$authName = "관리자 B";
			}else if($_SESSION['user_auth'] == '2'){
				$authName = "사용자 A";
			}else{
				$authName = "사용자 B";
			}

			$sessionDepart = empty($_SESSION['user_phone']) ?? '' ;

			$postData = Array(
				'seqs' => $_POST['seqs'],
				'id' => $_SESSION['user_id'],
				'name' => $_SESSION['user_name'],
				'depart' => $sessionDepart,
				'phone' => $phoneNum,
				'auth' => $authName,
				'org_code' => $_SESSION['user_orgCode'],
				'seqx' => $_SESSION['user_seq']
			);
			
			$apiResult = delUser($postData);

			echo $apiReuslt['result'];

			break;
		case 'updateUser' :							//회원 정보 수정
			if($_SESSION['user_auth'] == '4'){
				$authName = "관리자 A";
			}else if($_SESSION['user_auth'] == '3'){
				$authName = "관리자 B";
			}else if($_SESSION['user_auth'] == '2'){
				$authName = "사용자 A";
			}else{
				$authName = "사용자 B";
			}

			$seq = $_POST['seq'] ?? $_SESSION['user_seq'];
			$name = $_POST['name'] ?? $_SESSION['user_name'];
			$phone = $_POST['phone'] ?? $_SESSION['user_phone'];
			$email = $_POST['email'] ?? $_SESSION['user_email'];
			$auth = $_POST['auth'] ?? $_SESSION['user_auth'];
			$comment = $_POST['comment'] ?? $_SESSION['user_comment'];
			$pushId = $_POST['pushId'] ?? $_SESSION['user_pushId'];
			$id = $_POST['id'] ?? $_SESSION['user_id'];
			$grade = $_POST['grade'] ?? $_SESSION['user_grade'];

			$sessionPhone = empty($_SESSION['user_phone']) ?? '' ;
			$sessionDepart = empty($_SESSION['user_phone']) ?? '' ;

			$postData = Array(
				'seq' => $seq,
				'name' => $name,
				'phone' => $phone,
				'email' => $email,
				'auth'	=> $auth,
				'comment' => $comment,
				'id' => $_SESSION['user_id'],
				'nameM' => $name,
				'departM' => $sessionDepart,
				'phoneM' => $sessionPhone,
				'authM' =>  $authName,
				'org_code' => $_SESSION['user_orgCode'],
				'idM' => $id,
				'pushId' => $pushId,
                'grade' => $grade,
                'passwd' => ''
			);

			$apiResult = updateUser($postData);
			
			echo $apiResult['result'];
			//print_r($postData);
			//print_r($apiResult);
			
			break;
        case 'changePasswd' :
            $postData = Array(
                'seq' => $_SESSION['user_seq'],
                'passwd' => $_POST['newPasswd']
            );

            $apiResult = changePasswd($postData);

            p($apiResult);

            echo $apiResult['result'];
            break;
	}
?>