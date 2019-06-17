<?
include $_SERVER['DOCUMENT_ROOT']."/inc/header.php";
?>
    <link rel="stylesheet" href="/css/style.css">

    <div class="block-center wd-xxl" style="margin-top:15%">
        <!-- START card-->
        <div class="card card-flat bg-transparent" style="box-shadow:inherit;">

            <div class="card-header text-center mb-4">
                <img class="block-center rounded" src="/img/ci_asta_arms_vert.png" alt="Image" style = "width:90%";>
            </div>

            <div class="card-body pl-0 pr-0">
                <form class="mb-3" id="loginForm" method="post" action="/login/loginProc.php" >
                    <input type="hidden" name="mode" value="login"/>
                    <div class="form-group">
                        <div class="input-group with-focus">
                            <input class="form-control" name="id" placeholder="아이디" autocomplete="off" required>
                            <!-- <div class="input-group-append">
                            <span class="input-group-text text-muted bg-transparent border-left-0">
                            <em class="fa fa-envelope"></em>
                            </span>
                            </div> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group with-focus">
                            <input class="form-control border-right-0" name="passwd" type="password" placeholder="비밀번호" required>
                            <div class="input-group-append">
							<span class="input-group-text text-muted bg-transparent border-left-0">
								<em class="fa fa-lock"></em>
							</span>
                            </div>
                        </div>
                    </div>

                    <?if($_GET['f']=='1'){?>
                        <div class="error">
                            <p>아이디 또는 비밀번호를 다시 확인하세요.<br>등록되지 않은 아이디이거나, 아이디 또는 비밀번호를 잘못 입력하셨습니다.</p>
                        </div>
                    <?}?>

                    <?if($_GET['f']=='2'){?>
                        <div class="error">
                            <p>서버에러</p>
                        </div>
                    <?}?>
                    <?if($_GET['f'] !='2'){?>
                        <div class="error">
                            <p>(숫자, 영문자 대소문자 구분)</p>
                        </div>
                    <?}?>
                    <!--
                                    <div class="clearfix">
                                         <div class="checkbox c-checkbox float-left mt-0">
                                        <label>
                                        <input type="checkbox" value="" name="remember">
                                        <span class="fa fa-check"></span> Remember Me</label>
                                        </div>
                                        <div class="float-right">
                                        <a class="text-muted" href="recover.html">Forgot your password?</a>
                                        </div> -->
            </div>
            <button class="btn btn-block btn-info" type="submit" >로그인</button>
            </form>
        </div>
    </div>
    </div>

    </div>
<? include $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"?>