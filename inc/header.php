<?
@session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
////모바일 하단 페이지 별 유무

$basename=basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.
$isMobileBar = ($basename == 'index.php' || $basename == 'loginView.php')?false:true;

if(!empty($_SESSION)) {

    $auth_name = "";
    switch ($_SESSION["user_auth"]) {
        case '4' : $auth_name = "수퍼 관리자"; break;
        case '3' : $auth_name = "관리자"; break;
        case '2' : $auth_name = "일반"; break;
        case '1' : $auth_name = "디바이스"; break;
        default : $auth_name = ""; break;
    }

    include $_SERVER["DOCUMENT_ROOT"]."/device/device.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/inc/fnc.php";

    if($_SESSION["user_auth"] == 4 ){	//관리자 A
        $regist_seq = 0;
    }else if($_SESSION["user_auth"] == 3){	//관리자 B
        $regist_seq = $_SESSION["user_seq"];
    }else {	//사용자
        $regist_seq = $_SESSION["user_superId"];
    }

    $deviceArr = [];
    $exDeviceArr = explode(",", $_SESSION['user_orgCode']);


    for($i=0; $i<count($exDeviceArr); $i++ ){
        $postData = Array(
            'regist_seq' => $regist_seq,
            'org_code' => $exDeviceArr[$i]
        );
        $getDeviceList = getDeviceList($postData);

        $getSerialNo = array();

        if (!empty($getDeviceList['data'])) {
            foreach ($getDeviceList["data"] as $key => $val) {

                $getSerialNo[$val['SerialNo']]['boardName'] = $val['Location'];

            }
        }

        $deviceArr[$i] = $getSerialNo;
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

    if(count($getBuildingList) > 1){
        $getMyBuildingName = $getBuildingList[0]['org_name']." 외 ".(count($getBuildingList)-1)."개";
    }else if(count($getBuildingList) == 1){
        $getMyBuildingName = $getBuildingList[0]['org_name']."개";
    }


}//E: NOT SESSION

?>

<!DOCTYPE html>
<html lang="kr">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- <link rel="icon" type="image/x-icon" href="favicon.ico"> -->
	<title>ASTA</title>
    <!-- =============== VENDOR STYLES ===============-->
    <!-- FONT AWESOME-->
    <link rel="stylesheet" href="/vendor/@fortawesome/fontawesome-free/css/brands.css?v=3">
    <link rel="stylesheet" href="/vendor/@fortawesome/fontawesome-free/css/regular.css?v=3">
    <link rel="stylesheet" href="/vendor/@fortawesome/fontawesome-free/css/solid.css?v=3">
    <link rel="stylesheet" href="/vendor/@fortawesome/fontawesome-free/css/fontawesome.css?v=3">
    <!-- SIMPLE LINE ICONS-->
    <link rel="stylesheet" href="/vendor/simple-line-icons/css/simple-line-icons.css?v=3">
    <!-- =============== BOOTSTRAP STYLES ===============-->
    <link rel="stylesheet" href="/css/bootstrap.min.css?v=3" id="bscss">
    <!-- =============== APP STYLES ===============-->
    <link rel="stylesheet" href="/css/app.css" id="maincss?v=3">
    <!-- ANIMATE.CSS-->
    <link rel="stylesheet" href="/vendor/animate.css/animate.css?v=3">
    <!-- WHIRL (spinners)-->
    <link rel="stylesheet" href="/vendor/whirl/dist/whirl.css?v=3">
    <!-- DatetimePicker -->
    <link rel="stylesheet" href="/css/tempusDominus.css?v=3" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="/css/style.css?v=3">
    <link rel="stylesheet" href="/css/asta_style.css?v=3">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js?v=3"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment-with-locales.min.js?v=3"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js?v=3"></script>
    <!-- =============== VENDOR SCRIPTS ===============-->
    <!-- MODERNIZR-->
    <script src="/vendor/modernizr/modernizr.custom.js?v=3"></script>
    <!-- STORAGE API-->
    <script src="/vendor/js-storage/js.storage.js?v=3"></script>
    <!-- BOOTSTRAP-->
    <!-- <script src="/vendor/popper.js/dist/umd/popper.js"></script> -->
    <script src="/vendor/bootstrap/dist/js/bootstrap.min.js?v=3"></script>
    <!-- PARSLEY-->
    <script src="/vendor/parsleyjs/dist/parsley.js?v=3"></script>
    <!-- =============== APP SCRIPTS ===============-->
    <script src="/js/app.min.js?v=3"></script>
    <script src="/vendor/popper.js/dist/umd/popper.js?v=3"></script>

    <!-- =============== Customer JS =============== -->
    <script src="/js/common.js?v=3"></script>
    <script src="/js/fs-conf.js?v=3"></script>
    <script src="/js/realTime.js?v=4"></script>
    <script src="/js/asta-event.js?v=3"></script>

    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js?v=3"></script>
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-firestore.js?v=3"></script>
    <script src="/js/tempusDominus.js?v=3"></script>
    <script src="/js/yeom.js?v=3"></script>
    <script src="/js/yeom2.js?v=3"></script>
    <script src="/js/yeom3.js?v=3"></script>

</head>

<body>

<input type="hidden" id="loginYN" name="loginYN" value="<?=($_SESSION)?1:2?>"/>
<input type="hidden" id="seq" value="<?=$_SESSION['user_seq']?>">
<input type="hidden" id="auth" value="<?=$_SESSION['user_auth']?>">
<input type="hidden" id="myBuildingName">

<div class="wrapper " style="z-index:1000">
<!-- top navbar-->
<header class="topnavbar-wrapper">
	<!-- START Top Navbar-->
	<nav class="navbar topnavbar p-2">
		<!-- START Left navbar-->
		<ul class="navbar-nav mr-auto flex-row pl-lg-5 navbar-leftArea">
			<!-- 여 닫기-->
			<!-- <li class="nav-item">
				<a class="nav-link d-none d-md-block d-lg-block d-xl-block" href="#" data-trigger-resize="" data-toggle-state="aside-collapsed">
					<em class="fas fa-bars"></em>
				</a>
			</li> -->
			<!-- 여 닫기 -->

			<?if(!empty($_SESSION)){?>
                <!-- 장비 모니터링 유저 시작-->
                <li class="nav-item">
                    <a class="nav-link <?=($basename=='monitor_view.php'?"active":"")?>" href="/device/monitor_view.php">
                        <p class="navIcon navIcon1"></p>
                        <span class="d-none d-md-inline font-weight-bold">장비 모니터링</span>
                    </a>
                </li>
                <!-- 장비 모니터링 유저 시작-->
                <?if($_SESSION["user_auth"] > 2){?>
                <!-- 장비 모니터링 시작-->
                <li class="nav-item">
                    <a class="nav-link <?=($basename=='monitor_view_admin.php'?"active":"")?>" href="/device/monitor_view_admin.php">
                        <p class="navIcon navIcon3"></p>
                        <span class="d-none d-md-inline font-weight-bold">장비 모니터링(관리자)</span>
                    </a>
                </li>
                <!-- 장비 모니터링 시작-->
                <?}?>
                <!-- 로그 시작-->
                <li class="nav-item">
                    <a class="nav-link <?=($basename=='logView_n.php'?"active":"")?>" href="/log/logView_n.php">
                        <p class="navIcon navIcon6"></p>
                        <span class="d-none d-md-inline font-weight-bold">이력 조회</span>
                    </a>
                </li>
                <!-- 로그 끝-->
                <!-- 스케줄 설정 시작-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" id="user-block-toggle" href="#">-->
<!--                        <img src="/img/icon_schedule_n.png" />-->
<!--                        <span class="d-none d-md-inline font-weight-bold">스케줄 설정</span>-->
<!--                    </a>-->
<!--                </li>-->
                <!-- 스케줄 설정 끝 -->
                <!-- 유저 관리 시작-->
                <li class="nav-item">
                    <a class="nav-link <?=($basename=='userManage.php'?"active":"")?>" href="/user/userManage.php">
                        <p class="navIcon navIcon5"></p>
                        <span class="d-none d-md-inline font-weight-bold">사용자 관리</span>
                    </a>
                </li>
                <!-- 유저 관리 끝 -->
                <?if($_SESSION["user_auth"] > 2){?>
                    <!-- 장비 설정 시작 -->
                    <li class="nav-item">
                        <a class="nav-link <?=($basename=='deviceConf.php'?"active":"")?>" href="/device/deviceConf.php">
                            <p class="navIcon navIcon2"></p>
                            <span class="d-none d-md-inline font-weight-bold">장비 설정</span>
                        </a>
                    </li>
                <!-- 장비 설정 끝-->
                <?}?>
                <?if($_SESSION["user_auth"] == 4){?>
                    <!-- 빌딩 관리 시작 -->
                    <li class="nav-item">
                        <a class="nav-link <?=($basename=='buildingManage.php'?"active":"")?>" href="/building/buildingManage.php">
                            <p class="navIcon navIcon7"></p>
                            <span class="d-none d-md-inline font-weight-bold">건물 관리</span>
                        </a>
                    </li>
                    <!-- 빌딩 관리 끝 -->
                <?}?>
			<?}?>
		</ul>
		<!-- START Right Navbar-->
        <ul class="navbar-nav flex-row navbar-rightArea">
			<!-- START login toggle-->
			<?if(empty($_SESSION)){?>
				<!-- START Alert menu-->
                <li class="nav-item font-weight-bold mr-0">
                    <a class="nav-link font-weight-lighter" onclick="window.location.href='/login/loginView.php';">
                        <span class="ml-2"><img src="/img/icon_login_n.png" alt="" style="width:23px;"></span>
                        <span class="ml-0 navText">Login</span>
                        <!--                        <span class="count-circle text-center ml-2">2</span>-->

                    </a>
                </li>
            <?}else{?>
                <li class="nav-item font-weight-bold mr-0">
                    <a class="nav-link font-weight-lighter" onclick="showLogoutModal();">
                        <span class="navText"><span id="headerBIdgName"><?=$_SESSION['user_depart']?></span> - <?=$_SESSION['user_name']."(".$auth_name.")"?></span>
<!--                        <span class="count-circle text-center ml-2">2</span>-->
                        <span class="ml-2"><img src="/img/icon/icon_notice.png" alt=""></span>
                    </a>
                </li>
			<?}?>
		</ul>
		<!-- END Right Navbar-->
	</nav>
	<!-- END Top Navbar-->
</header>
