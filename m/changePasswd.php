<!DOCTYPE HTML>

<head>
    <? include $_SERVER["DOCUMENT_ROOT"]."/m/head.php"?>
</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/m/mHeader.php"?>

<section class="mt-3">
    <form action="#" class="changePasswdForm">

        <div class="form-group">

            <label for="" class="font-weight-bold">현재 비밀번호</label>
            <input class="form-control" type="password" id="id">

            <label for="" class="font-weight-bold pt-3">신규 비밀번호</label>
            <input class="form-control" type="password">

            <label for="" class="font-weight-bold pt-3">신규 비밀번호 확인</label>
            <input class="form-control" type="password">

        </div>

        <p class="text-danger">
            ※ 비밀번호는 최소 8자리 이상으로 입력해주세요
            <br>
            (숫자, 영문자 대소문자 구분)
        </p>

        <div class="ChangePasswdBtn w-100">
            <button class="btn btn-info w-100" type="submit" >저장</button>
        </div>
</section>

</body>
