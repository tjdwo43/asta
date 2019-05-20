<?
    session_start();

if(!empty($_SESSION)) {
    include $_SERVER["DOCUMENT_ROOT"]."/device/device.php";

    if($_SESSION["user_auth"] == 4 ){	//관리자 A
        $regist_seq = 0;
    }else if($_SESSION["user_auth"] == 3){	//관리자 B
        $regist_seq = $_SESSION["user_seq"];
    }else {	//사용자
        $regist_seq = $_SESSION["user_superId"];
    }

    $postData = Array(
        'regist_seq' => $regist_seq,
        'org_code' => $_SESSION["user_lastOrg"]
    );
    $getDeviceList = getDeviceList($postData);

    $getSerialNo = array();
    if(!empty($getDeviceList["data"])){
        foreach ( $getDeviceList["data"] as $key => $val) {
            $getSerialNo[$val['SerialNo']]['boardName'] = $val['BoardName'];
        }
    }
}
?>


<header>

    <span id="curBuildingName"></span>

    <span class="float-right" onclick="JS_logout();">
        <?=$_SESSION['user_name']?>
        <img src="/img/icon_logout_n.png" alt="" style="width:22px; height:22px;vertical-align: text-bottom">
    </span>

</header>

<div class="header-gap"></div>

<nav>
    <div id="nav-building" onclick="location.href='/m/buildingView.php'">
        <div class="d-block">
            <img src="/img/icn_bldg.png" alt="">
        </div>
        <span>빌딩 선택(관리자)</span>
    </div>
    <div id="nav-monitoring" onclick="location.href='/m/monitoringView.php'">
        <div class="d-block">
        <img src="/img/icon_monitoring_a.png" alt="">
        </div>
        <span>모니터링 제어</span>
    </div>
    <div id="nav-log" onclick="location.href='/m/logView.php'">
        <div class="d-block">
        <img src="/img/icon_log_a.png" alt="">
        </div>
        <span>이력조회</span>
    </div>
    <div id="nav-user" onclick="location.href='/m/userView.php'">
        <div class="d-block">
        <img src="/img/icon_user_a.png" alt="">
        </div>
        <span>사용자 정보</span>
    </div>
    <div id="nav-passwd" onclick="location.href='/m/changePasswd.php'">
        <div class="d-block">
        <img src="/img/icn_pw.png" alt="">
        </div>
        <span>비밀번호 변경</span>
    </div>

</nav>

