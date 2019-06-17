<?
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

?>
<!DOCTYPE HTML>

<head>
    <? include $_SERVER["DOCUMENT_ROOT"]."/m/head.php"?>
</head>

<body class="whirl traditional">

<? include $_SERVER["DOCUMENT_ROOT"]."/m/mHeader.php"?>

<div id="mainDiv">
    <!-- S : 경보 -->
    <section class="d-none">
        <div class="monitoring-title">경보</div>
        <div id="alarm-contents" class="monitoring-contents"></div>
    </section>
    <!-- E : 경보 -->

    <!-- S : 상태 -->
    <section class="d-none">
        <div class="monitoring-title">상태</div>
        <div id="status-contents" class="monitoring-contents"></div>
    </section>
    <!-- E : 상태 -->

    <!-- S : 제어 -->
    <section class="d-none">
        <div class="monitoring-title">제어</div>
        <div id="control-contents" class="monitoring-contents"></div>
    </section>
    <!-- E : 제어 -->

    <!-- S : 온/습/가스 -->
    <section class="d-none">
        <div class="monitoring-title">온도/습도/가스</div>
        <div id="climate-contents" class="monitoring-contents"></div>
    </section>
    <!-- E : 온/습/가스 -->
</div>

<div class="modal fade" id="outControlModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">출력 제어 ON/OFF</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="height:80px;">
                <form class="form-horizontal">
                    <input type="hidden" id="m_sn">
                    <input type="hidden" id="m_gw">
                    <input type="hidden" id="m_out1">
                    <input type="hidden" id="m_out2">
                    <input type="hidden" id="m_out3">
                    <input type="hidden" id="m_selected">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="c-radio">
                                <input id="inlineradio1" type="radio" name="useYN" value="1">
                                <span class="fa fa-circle"></span> ON
                            </label>

                            <label class="c-radio">
                                <input id="inlineradio2" type="radio" name="useYN" value="2" checked>
                                <span class="fa fa-circle"></span> OFF
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveOutControl" onclick="saveOutChVal()">저장</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">취소</button>
            </div>

        </div>
    </div>
</div>

<? include $_SERVER["DOCUMENT_ROOT"]."/m/bottom.php"; ?>
