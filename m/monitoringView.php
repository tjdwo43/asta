<?
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

?>
<!DOCTYPE HTML>

<head>
    <? include $_SERVER["DOCUMENT_ROOT"]."/m/head.php"?>
    <style>
        .monitoring-contents:after {
            content:'';
            display:block;
            clear:both;
        }
    </style>
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

<!-- 출력 제어 ON/OFF 모달 -->
<div class="modal fade" id="outControlModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" style="margin:7rem 1rem;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="outch-title"></h4>
            </div>
            <div class="modal-body" style="height:80px;border-bottom:1px solid #e9ecef">
                <div>최근 이력 : <span id="outControlregDate"></span></div>
                <div id="outRecentHistory"></div>
            </div>
            <div class="modal-header">
                <h4 class="modal-title">출력 제어</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="height:50px;">
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
                <button type="button" class="btn btn-primary btn-info btn-xs" id="saveOutControl" onclick="saveOutChVal()">저장</button>
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">취소</button>
            </div>

        </div>
    </div>
</div>

<!-- 히스토리 -->
<div class="modal fade" id="recentHistory" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" style="margin:7rem 1rem;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="recentModal-title">최근 이력 조회</h4>
            </div>

            <!-- Modal body -->

            <div class="modal-body"  style="height:80px;">
                <div>최근이력 : <span id="historyRegDate"></span></div>
                <div id="recentHistory-body"></div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-info" data-dismiss="modal">확인</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="recentHistory2" style="display: none;" aria-hidden="true">
    <input type="hidden" id="recentSerialNo">
    <input type="hidden" id="recentGatewayKey">
    <input type="hidden" id="recentChType">
    <input type="hidden" id="recentOrgCode">
    <input type="hidden" id="recentBidgName">
    <input type="hidden" id="recentGwCmt">
    <input type="hidden" id="recentCmt">
    <input type="hidden" id="recentStatus">

    <div class="modal-dialog" style="margin:7rem 1rem;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="recentModal-title2"></h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="height:80px;">
                <div>최근이력 : <span id="historyRegDate2"></span></div>
                <div id="recentHistory-body2"></div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
<!--                <button type="button" class="btn btn-primary" id="inchConfirmBtn">확인</button>-->
                <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">확인</button>
            </div>

        </div>
    </div>
</div>

<? include $_SERVER["DOCUMENT_ROOT"]."/m/bottom.php"; ?>
