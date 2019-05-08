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
        case '4' : $auth_name = "슈퍼 관리자"; break;
        case '3' : $auth_name = "관리자"; break;
        case '2' : $auth_name = "사용자 A"; break;
        case '1' : $auth_name = "사용자 B"; break;
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

    $postData = Array(
        'regist_seq' => $regist_seq,
        'org_code' => $_SESSION["user_orgCode"]
    );
    $getDeviceList = getDeviceList($postData);

    $getSerialNo = array();
    foreach ( $getDeviceList["data"] as $val) {
        array_push($getSerialNo , $val["SerialNo"]) ;
    }

}

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
	<link rel="stylesheet" href="/vendor/@fortawesome/fontawesome-free/css/brands.css">
	<link rel="stylesheet" href="/vendor/@fortawesome/fontawesome-free/css/regular.css">
	<link rel="stylesheet" href="/vendor/@fortawesome/fontawesome-free/css/solid.css">
	<link rel="stylesheet" href="/vendor/@fortawesome/fontawesome-free/css/fontawesome.css">
	<!-- SIMPLE LINE ICONS-->
	<link rel="stylesheet" href="/vendor/simple-line-icons/css/simple-line-icons.css">
	
	<!-- =============== BOOTSTRAP STYLES ===============-->
	<link rel="stylesheet" href="/css/bootstrap.min.css" id="bscss">
	<!-- =============== APP STYLES ===============-->
	<link rel="stylesheet" href="/css/app.min.css" id="maincss">

	<!-- ANIMATE.CSS-->
	<link rel="stylesheet" href="/vendor/animate.css/animate.css">

	<!-- WHIRL (spinners)-->
	<link rel="stylesheet" href="/vendor/whirl/dist/whirl.css">
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment-with-locales.min.js"></script>

	<!-- Custom Css -->
	<link rel="stylesheet" href="/css/style.css">

	<!-- =============== VENDOR SCRIPTS ===============-->
	<!-- MODERNIZR-->
	<script src="/vendor/modernizr/modernizr.custom.js"></script>
	<!-- STORAGE API-->
	<script src="/vendor/js-storage/js.storage.js"></script>
	<!-- i18next-->
	<!-- <script src="/vendor/i18next/i18next.js"></script> -->
	<!-- <script src="/vendor/i18next-xhr-backend/i18nextXHRBackend.js"></script> -->
	<!-- BOOTSTRAP-->
	<!-- <script src="/vendor/popper.js/dist/umd/popper.js"></script> -->
	<script src="/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- PARSLEY-->
	<script src="/vendor/parsleyjs/dist/parsley.min.js"></script>
	<!-- =============== APP SCRIPTS ===============-->
	<script src="/js/app.min.js"></script>

	<script src="/js/common.js"></script>
	<script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-firestore.js"></script>
</head>

<body>

<input type="hidden" id="loginYN" name="loginYN" value="<?=($_SESSION)?1:2?>"/>

<div class="wrapper ">
<!-- top navbar-->
<header class="topnavbar-wrapper">
	<!-- START Top Navbar-->
	<nav class="navbar topnavbar">
		<!-- START Left navbar-->
		<ul class="navbar-nav mr-auto flex-row pl-lg-5">
			<!-- 여 닫기-->
			<li class="nav-item">
				<!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
				<a class="nav-link d-none d-md-block d-lg-block d-xl-block" href="#" data-trigger-resize="" data-toggle-state="aside-collapsed">
					<em class="fas fa-bars"></em>
				</a>
			</li>
			<!-- 여 닫기 -->
			
			<?if(!empty($_SESSION)){?>
				<!-- 유저 관리 시작-->
				<li class="nav-item font-weight-bold">
					<a class="nav-link" id="user-block-toggle" href="/user/userView.php"> 
						<img style="width:20px; hegith:20px;" src="/img/icon_user_n.png" /> <span class="d-none d-md-inline">사용자 관리</span>
					</a>
				</li>
				<!-- 유저 관리 끝 -->
				
				<?if($_SESSION['user_auth'] >= 2){?>
				<!-- 장비 설정 시작 -->
				<li class="nav-item font-weight-bold">
					<a class="nav-link" href="/device/deviceConfView.php"> 
						<img style="width:20px; hegith:20px;" src="/img/icon_device_n.png" /> <span class="d-none d-md-inline">장비 설정</span>
					</a>
				</li>
				<!-- 장비 설정 끝-->
				<?}?>

				<!-- 장비 모니터링 시작-->
				<li class="nav-item font-weight-bold">
					<a class="nav-link"  href="/device/deviceMornView.php"> 
						<img style="width:20px; hegith:20px;" src="/img/icon_monitoring_n.png" /> <span class="d-none d-md-inline">장비 모니터링 & 제어</span>
					</a>
				</li>
				<!-- 장비 모니터링 시작-->

				<!-- 예약 설정 시작-->
				<li class="nav-item font-weight-bold">
					<a class="nav-link" href="/schedule/scheduleView.php"> 
						<img style="width:20px; hegith:20px;" src="/img/icon_schedule_n.png" /> <span class="d-none d-md-inline">스케쥴 설정</span>
					</a>
				</li>
				<!-- 예약 설정 시작-->
				
				<!-- 로그 시작-->
				<li class="nav-item font-weight-bold">
					<a class="nav-link" href="/log/logView.php"> 
						<img style="width:20px; hegith:20px;" src="/img/icon_log_n.png" /> <span class="d-none d-md-inline">이력 조회</span>
					</a>
				</li>
				<!-- 로그 끝-->
			<?}?>
		</ul>
		<!-- START Right Navbar-->
		<ul class="navbar-nav flex-row">
			<!-- START login toggle-->
			<?if(empty($_SESSION)){?>
				<!-- START Alert menu-->
				<li class="nav-item font-weight-bold">
					<a class="nav-link" title="로그인" href="#" onclick="location.href='/login/loginView.php'">
						<img style="width:20px; hegith:20px;" src="/img/icon_login_n.png" />
						<span class="d-none d-md-inline">Guest</span>
					</a> 
				</li>
			<?}else{?>
				<li class="nav-item font-weight-bold">
					<a class="nav-link" title="로그아웃" href="#" onclick="JS_logout();"> 
						<img style="width:20px; hegith:20px;" src="/img/icon_logout_n.png" />
						<span class="d-none d-md-inline"><?=$_SESSION[user_name]." : ".$auth_name?></span>
					</a> 
				</li>
			<?}?>
		</ul>
		<!-- END Right Navbar-->
	</nav>
	<!-- END Top Navbar-->
</header>