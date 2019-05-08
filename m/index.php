<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="kr">
<head>
    <? include $_SERVER["DOCUMENT_ROOT"]."/m/head.php"?>
</head>
<style>
    body { border-top-color: #18A0CA;
        border-top-style: solid;
        border-width: 1.0rem;
        border-bottom-color: #18A0CA;
        border-bottom-style: solid; }
</style>
<body>
<div>

    <!-- S: logo -->
    <section class="logo_sect">
        <img  src="/img/ci_asta_arms_vert.png" alt="Image" style="width:90%">
    </section>
    <!-- E : logo -->

    <section class="input_sect">

        <form action="/m/buildingView.php">

            <div class="form-group">

                <label for="" class="font-weight-bold">아이디</label>
                <input class="form-control" type="text" id="id">

                <label for="" class="font-weight-bold pt-3">비밀번호</label>
                <input class="form-control" type="password">

                <div class="pt-3">
                    <div class="checkbox c-checkbox float-right">
                        <label>
                            <input type="checkbox" name="confCheckbox" value="1">
                            <span class="fa fa-check"></span>
                        </label>
                        자동로그인
                    </div>
                </div>


            </div>

            <div class="loginBtn pt-5 m-auto w-50">
                <button class="mLogin-Btn btn btn-block " type="submit" >로그인</button>
            </div>


        </form>

    </section>

    <section class="bLog_sect">

        <img src="/img/ci_asta_hor.png" alt="">

    </section>

    
</div>
</body>
</html>