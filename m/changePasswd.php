<?
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE HTML>

<html>
<head>
    <? include $_SERVER["DOCUMENT_ROOT"]."/m/head.php"?>
</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/m/mHeader.php"?>

<section class="mt-3">
    <form action="#" class="changePasswdForm">
        <div class="form-group">
            <label for="currentPasswd" class="font-weight-bold">현재 비밀번호</label>
            <input class="form-control" type="password" id="currentPasswd" name="currentPasswd"
                   required data-parsley-minlength="8">
            <p id="notMatch" class="text-danger d-none" style="font-size:0.7rem">일치하지 않습니다.</p>

            <label for="newPasswd" class="font-weight-bold pt-3">신규 비밀번호</label>
            <input class="form-control" type="password" id="newPasswd" name="newPasswd"
                   data-parsley-minlength="8" required>

            <label for="confirmNewPasswd" class="font-weight-bold pt-3">신규 비밀번호 확인</label>
            <input class="form-control" type="password" id="confirmNewPasswd" name="confirmNewPasswd"
                   required data-parsley-equalto="#newPasswd">
        </div>

        <p class="text-danger" style="font-size:0.7rem">
            ※ 비밀번호는 최소 8자리 이상으로 입력해주세요
            <br>
            (숫자, 영문자 대소문자 구분)
        </p>

        <div class="ChangePasswdBtn w-100">
            <button class="btn btn-info w-100" type="button" onclick="changePassword()">저장</button>
        </div>
    </form>
</section>

<script>

</script>

<? include $_SERVER["DOCUMENT_ROOT"]."/m/bottom.php"; ?>