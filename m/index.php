<?
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();

include_once $_SERVER["DOCUMENT_ROOT"] . "/inc/fnc.php";

?>
<!DOCTYPE html>
<html lang="kr">
<head>
    <? include $_SERVER["DOCUMENT_ROOT"] . "/m/head.php" ?>
</head>
<style>
    body {
        border-top-color: #18A0CA;
        border-top-style: solid;
        border-width: 1.0rem;
        border-bottom-color: #18A0CA;
        border-bottom-style: solid;
        margin-top:constant(safe-area-inset-top);
        margin-top:env(safe-area-inset-top);
    }
</style>
<body>
<div class="wrap">
    <!-- S: logo -->
    <section class="logo_sect" style="width:60%">
        <img src="/img/ci_asta_arms_vert.png" alt="Image" style="width:100%">
    </section>
    <!-- E : logo -->

    <section class="input_sect w-75">

        <form id="loginFrm" action="/login/loginProc.php" method="post">
            <input type="hidden" name="mode" value="login"/>
            <input type="hidden" name="deviceType" value="mobile"/>
            <input id="keyword" name="keyword" type="hidden">

            <div class="form-group">

                <label for="id" class="font-weight-bold">아이디</label>
                <input class="form-control" type="text" name="id" id="id" placeholder="">

                <label for="passwd" class="font-weight-bold pt-3">비밀번호</label>
                <input class="form-control" type="password" name="passwd" id="passwd">

                <div class="pt-3">

                    <div class="checkbox c-checkbox">
                        <label>
                            <input type="checkbox" id="autoCheckbox" name="confCheckbox" value="1">
                            <span class="fa fa-check"></span>
                        </label>
                        자동 로그인
                    </div>

                </div>

                <div class="<?= ($_GET['f'] == 1) ? 'd-blcok' : 'd-none' ?> text-danger" style="font-size:0.5rem">
                    아이디 또는 비밀번호를 다시 확인하세요.<br>
                    회원 등록되지 않은 아이디이거나, 아이디 또는 비밀번호를 잘못 입력하셨습니다.
                </div>
                <div class="<?= ($_GET['f'] == 2) ? 'd-blcok' : 'd-none' ?> text-danger" style="font-size:0.5rem">
                    서버에러
                </div>
                <div class="<?= ($_GET['f'] != 2) ? 'd-blcok' : 'd-none' ?> text-danger" style="font-size:0.5rem">
                    숫자, 영문자 대소문자 구분
                </div>
            </div>

            <div class="loginBtn m-auto w-50">
                <button class="mLogin-Btn btn btn-block " type="button" onclick="logIn()">로그인</button>
            </div>

        </form>

    </section>

    <section class="bLog_sect">

        <img src="/img/icon/mobile_bottom.png" alt="" >

    </section>


</div>

<script>
    autoLogin()
</script>
</body>
</html>