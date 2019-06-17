<?
include $_SERVER[DOCUMENT_ROOT]."/inc/header.php";
?>
<style type="text/css">
    @media (min-width: 768px) {
        .wrapper .section-container {
            width: calc(100% - 60px);
            margin: 22px auto;
        }
    }
</style>

<section class="section-container">
    <div class="row">
        <div class="col-xl-12">
            <!--
            <div class="card card-default card-demo" id="">
                <div class="card-header">
                    <a class="float-right collapseBtn" href="#">
                        <em class="fa fa-angle-down"></em>
                    </a>
                    <div class="card-title font-weight-lighter">경보 (가산 SK V1 Center)</div>
                </div>
                <div class="card-wrapper">
                    <div class="card-body card_content">
                        <ul class="list-unstyled pt-0 text-center">
                            <li class="active"><a href="">정전</a></li>
                            <li><a href="">화재</a></li>
                            <li><a href="">누수1</a></li>
                            <li><a href="">누수2</a></li>
                            <li><a href="">가스1</a></li>
                            <li><a href="">가스2</a></li>
                            <li><a href="">보일러</a></li>
                            <li><a href="">집수정1</a></li>
                            <li><a href="">집수정2</a></li>
                            <li><a href="">화재-가스실</a></li>
                            <li><a href="">누수1</a></li>
                            <li><a href="">누수2</a></li>
                            <li><a href="">가스1</a></li>
                            <li><a href="">가스2</a></li>
                            <li><a href="">보일러</a></li>
                            <li><a href="">집수정1</a></li>
                            <li><a href="">정전</a></li>
                            <li><a href="">화재-보일러실</a></li>
                            <li class="active"><a href="">누수</a></li>
                            <li><a href="">누수2</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card card-default card-demo" id="">
                <div class="card-header">
                    <a class="float-right collapseBtn" href="#">
                        <em class="fa fa-angle-down"></em>
                    </a>
                    <div class="card-title font-weight-lighter">상태 (가산 SK V1 Center)</div>
                </div>
                <div class="card-wrapper">
                    <div class="card-body card_content cardType_state">
                        <ul class="list-unstyled pt-0 text-center">
                            <li><a href="">보일러1<br><span>OFF</span></a></li>
                            <li class="active"><a href="">보일러2<br><span>ON</span></a></li>
                            <li><a href="">보일러3<br><span>OFF</span></a></li>
                            <li><a href="">냉동기1<br><span>OFF</span></a></li>
                            <li><a href="">냉동기2<br><span>OFF</span></a></li>
                            <li><a href="">냉동기3<br><span>OFF</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card card-default card-demo" id="">
                <div class="card-header">
                    <a class="float-right collapseBtn" href="#">
                        <em class="fa fa-angle-up"></em>
                    </a>
                    <div class="card-title font-weight-lighter">제어 (가산 SK V1 Center) <label class="tag">1/4</label></div>
                </div>
            </div>
            <div class="card card-default card-demo" id="">
                <div class="card-header">
                    <a class="float-right collapseBtn" href="#">
                        <em class="fa fa-angle-down"></em>
                    </a>
                    <div class="card-title font-weight-lighter">온도/습도/가스 (문래 SK V1 Center)</div>
                </div>
                <div class="card-wrapper">
                    <div class="card-body card_content cardType_state">
                        <ul class="list-unstyled pt-0 text-center">
                            <li><a href="">보일러1온도<br><span>20℃</span></a></li>
                            <li><a href="">보일러2온도<br><span>10℃</span></a></li>
                            <li class="active"><a href="">보일러1습도<br><span>70%</span></a></li>
                            <li><a href="">보일러2습도<br><span>50%</span></a></li>
                            <li class="active"><a href="">보일러3온도<br><span>40℃</span></a></li>
                            <li><a href="">보일러3습도<br><span>45%</span></a></li>
                            <li><a href="">보일러4온도<br><span>23℃</span></a></li>
                            <li><a href="">보일러4습도<br><span>55%</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>
</section>

</div>
<!-- 출력 제어 ON/OFF 모달 -->
<div class="modal fade" id="outControlModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="outch-title"></h4>
            </div>
            <div class="modal-body" style="height:80px;border-bottom:1px solid #e9ecef">
                <div>최근 이력 :</div>
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
                <button type="button" class="btn btn-primary btn-info" id="saveOutControl" onclick="saveOutChVal()">저장</button>
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">취소</button>
            </div>

        </div>
    </div>
</div>

<!-- 히스토리 -->
<div class="modal fade" id="recentHistory" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="recentModal-title">최근 이력 조회</h4>
            </div>

            <!-- Modal body -->

            <div class="modal-body"  style="height:80px;">
                <div>최근이력 :</div>
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

    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="recentModal-title2"></h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="height:80px;">
                <div>최근이력 :</div>
                <div id="recentHistory-body2"></div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="inchConfirmBtn">확인</button>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#inchConfirmBtn").click(function(){
            let userAuth = document.getElementById("auth").value

            let serialNo = document.getElementById("recentSerialNo").value
            let gwKey = document.getElementById("recentGatewayKey").value
            let chType = document.getElementById("recentChType").value
            let orgCode = document.getElementById("recentOrgCode").value
            let bIdgName = document.getElementById("recentBidgName").value
            let gwCmt = document.getElementById("recentGwCmt").value
            let cmt = document.getElementById("recentCmt").value
            let status = document.getElementById("recentStatus").value

            console.log(userAuth)

            if(status == "3"){
                if(userAuth > 2){
                    $.ajax({
                        "url":"/device/deviceAjaxProc.php",
                        "type":"post",
                        "data":{
                            "mode":"registGwByCH",
                            "SerialNo":serialNo,
                            "GatewayKey":gwKey,
                            "chType":chType,
                            "org_code":orgCode,
                            "bIdgName":bIdgName,
                            "gwCmt":gwCmt,
                            "comment":cmt
                        },
                        success:function(data){
                            console.log(data)
                            $("#recentHistory2").modal("hide")
                            alertMessage("해제 되었습니다.")
                        }
                    })
                }
                else{
                    $("#recentHistory2").modal("hide")
                }
            }
            else {
                $("#recentHistory2").modal("hide")
            }
        })
    });
    getHeaderName();
    setInterval(function() {
        $(".alarm-danger").toggleClass("active");
    }, 1000);
</script>
<? include $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"?>
