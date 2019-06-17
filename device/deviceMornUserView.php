<?
include $_SERVER[DOCUMENT_ROOT] . "/inc/header.php";

include $_SERVER[DOCUMENT_ROOT] . "/device/deviceConfAsside.php";
?>

    <section class="section-container p-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default" id="cardDemo1">
                    <div class="card-header">경보
                        <a class="float-right" href="#" title="">
                            <em class="fa fa-minus"></em>
                        </a>
                    </div>
                    <div class="card-wrapper">
                        <div class="card-body" id="alarm-contents">

                        </div>
                    </div><!-- END card-->
                </div>
                <div class="card card-default" id="cardDemo1">
                    <div class="card-header">상태
                        <a class="float-right" href="#"  title="">
                            <em class="fa fa-minus"></em>
                        </a>
                    </div>
                    <div class="card-wrapper">
                        <div class="card-body" id="status-contents">

                        </div>
                    </div><!-- END card-->
                </div>
                <div class="card card-default" id="cardDemo1">
                    <div class="card-header">제어
                        <a class="float-right" href="#" title="">
                            <em class="fa fa-minus"></em>
                        </a>
                    </div>
                    <div class="card-wrapper" transition: max-height 0.5s ease 0s; ">
                        <div class="card-body" id="control-contents">

                        </div>
                    </div><!-- END card-->
                </div>
                <div class="card card-default" id="cardDemo1">
                    <div class="card-header">온도, 습도, 가스
                        <a class="float-right" href="#" title="">
                            <em class="fa fa-minus"></em>
                        </a>
                    </div>
                    <div class="card-wrapper"  >
                        <div class="card-body" id="climate-contents">

                        </div>
                    </div><!-- END card-->
                </div>
            </div>
    </section>

<? include $_SERVER[DOCUMENT_ROOT] . "/inc/footer.php" ?>