<?
session_start();

$basename=basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.

if (!empty($_SESSION)) {
    include $_SERVER["DOCUMENT_ROOT"] . "/device/device.php";

    if ($_SESSION["user_auth"] == 4) {    //관리자 A
        $regist_seq = 0;
    } else if ($_SESSION["user_auth"] == 3) {    //관리자 B
        $regist_seq = $_SESSION["user_seq"];
    } else {    //사용자
        $regist_seq = $_SESSION["user_superId"];
    }

    $postData = Array(
        'regist_seq' => "1",
        'org_code' => $_SESSION["user_lastOrg"]
    );

    $getDeviceList = getDeviceList($postData);

    $getSerialNo = array();
    if (!empty($getDeviceList["data"])) {
        foreach ($getDeviceList["data"] as $key => $val) {
            $getSerialNo[$val['SerialNo']]['boardName'] = $val['BoardName'];
        }
    }

    include_once $_SERVER['DOCUMENT_ROOT']."/building/building.php";

    $orgCode = $_SESSION["user_orgCode"];
    if ($_SESSION["user_auth"] == 4) {
        $orgCode = '';
    }

    $postData = Array(
        'auth' => $_SESSION["user_auth"],
        'seq' => $_SESSION['user_seq']
    );

    $getBuildingList = buildingList($postData);


    foreach ($getBuildingList['data'] as $val){
        if($val['org_code'] == $_SESSION["user_lastOrg"]){
            $getLastOrgName = $val['org_name'];
        }
    }

    if(count($getBuildingList['data']) > 1){
        $getMyBuildingName = $getBuildingList['data'][0]['org_name']." 외 ".(count($getBuildingList['data'])-1)."개";
    }else if(count($getBuildingList) == 1){
        $getMyBuildingName = $getBuildingList['data'][0]['org_name'];
    }
}
?>
<input type="hidden" id="lastOrgName" value="<?=$getLastOrgName?>">
<input type="hidden" id="myBuildingName" value="<?=$getMyBuildingName?>">
<input type="hidden" id="auth" value="<?=$_SESSION['user_auth']?>">
<input type="hidden" id="lastOrg" value="<?=$_SESSION["user_lastOrg"]?>">
<div class="notch-header"></div>
<header>

    <span id="header-buildingName">
        <label id="curBuildingName">건물을 선택해주세요</label>
        <label id="curBldgCount" class="tag">0/0</label>
    </span>

    <span class="float-right" onclick="showLogoutModal();">
        <?= $_SESSION['user_name'] ?>
        <img src="/img/icon_logout_n.png" alt="" style="width:22px; height:22px;vertical-align: text-bottom">
    </span>

</header>

    <div class="header-gap"></div>

<nav ontouchend="setMenuScroll()">
    <div id="nav-monitoring" onclick="location.href='/m/monitoringView.php'">
        <div class="d-block">
            <img src="/img/icon_monitoring_a.png" alt="">
        </div>
        <span>모니터링&제어</span>
    </div>
    <div id="nav-log" onclick="location.href='/m/logView.php'">
        <div class="d-block">
            <img src="/img/icon_log_a.png" alt="">
        </div>
        <span>이력 조회</span>
    </div>
    <div id="nav-user" onclick="location.href='/m/userView.php'">
        <div class="d-block">
            <img src="/img/icon_user_a.png" alt="">
        </div>
        <span>사용자 정보</span>
    </div>
    <div id="nav-building" onclick="location.href='/m/buildingView.php'">
        <div class="d-block">
            <img src="/img/icn_bldg.png" alt="">
        </div>
        <span>건물 정보</span>
    </div>
    <div id="nav-passwd" onclick="location.href='/m/changePasswd.php'">
        <div class="d-block">
            <img src="/img/icn_pw.png" alt="">
        </div>
        <span>비밀번호 변경</span>
    </div>

</nav>

