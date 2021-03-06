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
    case 'getUserListM' :
        //좌측 유저 리스트
        $postData = Array(
            'org_code' => $_POST['orgCode'],
            'auth'	=>	$_SESSION['user_auth'],
            'superId' => ($_SESSION['user_auth'] == 4)?"":$_SESSION['user_seq']
        );

        $userList = getListUserM($postData);

        $userListJson = json_encode($userList);

        echo $userListJson;

        break;
    case 'getUserListperOrg':
        //좌측 유저 리스트
        $postJson = json_decode($_POST['orgJson'], true);
        $resultArray = Array();
        foreach($postJson as $key => $val):
            $postData = Array(
                'org_code' => $val['org_code'],
                'auth'	=>	'3',
                'superId' => ''
            );

            $userList = getListUser($postData);
            if($userList['data'] != null)
                $resultArray = array_merge($resultArray, $userList['data']);
        endforeach;

        echo json_encode($resultArray);
        break;
    case 'registerUser' :
        $grade = $_POST["position"] ?? "미입력";
        $postData = Array(
            'id' => $_POST['id'],
            'passwd' => $_POST['newPW'],
            'name' => $_POST['userName'],
            'org_code' => $_POST['org_code'],
            'phone' => ($_POST['phone'])?$_POST['phone']:"",
            'email' => ($_POST['email'])?$_POST['email']:"",
            'auth' => $_POST['auth'],
            'comment' => ($_POST['comment'])?$_POST['comment']:'',
            'superId' => $_SESSION['user_seq'],
            'depart' => $_POST['depart'],
            'grade' => $grade
        );

        $apiResult = registerUser($postData);

        $result[data] = $apiResult[data];

        $result[seq] = $apiResult[data][seq];

        $result[resultVal] = $apiResult[result];

        echo json_encode($result, JSON_UNESCAPED_SLASHES);

        break;
    case 'delUser' :							//회원 정보 삭제
        $phoneNum = $_POST['phoneNum'] ?? "";

        if($_SESSION['user_auth'] == '4'){
            $authName = "수퍼 관리자";
        }else if($_SESSION['user_auth'] == '3'){
            $authName = "관리자";
        }else if($_SESSION['user_auth'] == '2'){
            $authName = "일반";
        }else{
            $authName = "디바이스";
        }

        $sessionDepart = empty($_SESSION['user_phone']) ?? '' ;

        $postData = Array(
            'seqs' => $_POST['seqs'],
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'depart' => $sessionDepart,
            'phone' => $phoneNum,
            'auth' => $authName,
            'org_code' => $_SESSION['user_orgCode']
        );

        p($postData);

        $apiResult = delUser($postData);

        echo $apiReuslt['result'];

        break;
    case 'updateUser' :							//회원 정보 수정
        if($_SESSION['user_auth'] == '4'){
            $authName = "수퍼 관리자";
        }else if($_SESSION['user_auth'] == '3'){
            $authName = "관리자";
        }else if($_SESSION['user_auth'] == '2'){
            $authName = "일반";
        }else{
            $authName = "디바이스";
        }

        $seq = ($_POST['seq'] == '')?'':$_POST['seq'];
        $name = ($_POST['userName'] == '')?'':$_POST['userName'];
        $phone = ($_POST['phone'] == '')?'':$_POST['phone'];
        $email = ($_POST['email'] == '')?'':$_POST['email'];
        $auth = ($_POST['auth'] == '')?'':$_POST['auth'];
        $comment = ($_POST['comment'] == '')?'':$_POST['comment'];
        $pushId = ($_POST['pushId'] == '')?'':$_POST['pushId'];
        $id = $_SESSION['user_id'];
        $grade = ($_POST['position'] == '')?'과장':$_POST['position'];

        $sessionPhone = ($_SESSION['user_phone'] == '')?$_SESSION['user_phone']:'' ;
        $sessionDepart = ($_SESSION['user_depart']) ? $_SESSION['user_depart']:'' ;

        $postData = Array(
            'seq' => $seq,
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'auth'	=> $auth,
            'comment' => $comment,
            'id' => $_POST['id'],
            'nameM' => $name,
            'departM' => $sessionDepart,
            'phoneM' => $sessionPhone,
            'authM' =>  $authName,
            'org_code' => $_POST['org_code'],
            'idM' => $id,
            'pushId' => $pushId,
            'grade' => $grade,
            'passwd' => $_POST['newPW'],
            'depart'=> $_POST['depart']??''
        );

        $apiResult = updateUser($postData);

        echo $apiResult['result'];
        //print_r($postData);
        //print_r($apiResult);

        break;
    case 'changePasswd' :
        $postData = Array(
            'seq' => ($_POST['seq'])?$_POST['seq']:$_SESSION['user_seq'],
            'passwd' => $_POST['newPasswd']
        );

        $apiResult = changePasswd($postData);

        echo $apiResult['result'];
        break;
    case 'dupCheck':
        $postData = Array(
            'id' => $_POST['id']
        );

        $apiResult = dupCheck($postData);

        //0 : 없는 아이디, 1: 중복 아이디
        echo $apiResult['result'];
        break;
}
?>
