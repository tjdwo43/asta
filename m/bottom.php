<audio id="myAudio" loop>
    <source src="/alarm3rev.wav" type="audio/ogg">
    <!--            <source src="horse.mp3" type="audio/mpeg">-->
    Your browser does not support the audio element.
</audio>

<div class="modal manualRegist" id="logoutModal" style="display:none" aria-hidden="true">
    <div class="modal-dialog" style="margin:7rem 1rem;">
        <div class="modal-content">
            <!-- Modal Header -->
            <!--                    <div class="modal-header">-->
            <!--                        <h4 class="modal-title">수동등록</h4>-->
            <!--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
            <!--                            <span aria-hidden="true">&times;</span>-->
            <!--                        </button>-->
            <!--                    </div>-->

            <!-- Modal body -->
            <div class="modal-body">
                로그아웃하시겠습니까?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-xs" onclick="JS_logout()">확인</button>
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">취소</button>
            </div>

        </div>
    </div>
</div>

<div class="modal manualRegist" id="alertModal" style="display:none" aria-hidden="true">
    <div class="modal-dialog" style="margin:7rem 1rem;">
        <div class="modal-content">
            <!-- Modal Header -->
            <!--                    <div class="modal-header">-->
            <!--                        <h4 class="modal-title">수동등록</h4>-->
            <!--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
            <!--                            <span aria-hidden="true">&times;</span>-->
            <!--                        </button>-->
            <!--                    </div>-->

            <!-- Modal body -->
            <div class="modal-body" id="modal-message">

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-xs" data-dismiss="modal">확인</button>
            </div>

        </div>
    </div>
</div>

<div class="modal manualRegist" id="sessionModal" style="display:none" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal body -->
            <div class="modal-body" id="delete-body-Modal">
                <span>세션이만료되어 다시 로그인 해주세요</span>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='/m';">확인</button>
            </div>

        </div>
    </div>
</div>

<div class="modal manualRegist" id="alarmModal" style="display:none" aria-hidden="true">
    <input type="hidden" id="alertConfirmCmt">
    <input type="hidden" id="alertConfirmGwKey">
    <input type="hidden" id="alertConfirmChNo">
    <input type="hidden" id="alertConfirmGwCmt">
    <input type="hidden" id="alertConfirmSerialNo">

    <div class="modal-dialog">
        <div class="modal-content">
            <!--                     Modal Header-->
            <div class="modal-header">
                <h4 class="modal-title">경보알림</h4>
                <!--                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                <!--                                <span aria-hidden="true">&times;</span>-->
                <!--                            </button>-->
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="alarm-message">

            </div>

            <!-- Modal footer -->
            <!--                    <div class="modal-footer">-->
            <!--                        <button type="button" class="btn btn-info btn-xs" id="alarmConfirm">확인</button>-->
            <!--                    </div>-->

        </div>
    </div>
</div>

<button id="MOVE_TOP_BTN2"><em class="fa-2x fas fa-angle-up"></em></button>

<script>
    <?
    if($basename != "index.php"){
        if(empty($_SESSION)){
            echo 'sessionMessage("세션이만료되어 다시 로그인해주세요.");';
        }
    }
    ?>
    //시리얼 리스트
    let sessionList = '<?=json_encode($_SESSION)?>';
    let sessionListJson = $.parseJSON(sessionList);

    sessionConsole(sessionListJson)

    //realTime
    let config = fireStoreConf();
    let deviceSerialNoList = '<?=json_encode($getSerialNo)?>';
    let deviceSerialNoListJson = $.parseJSON(deviceSerialNoList);
    let currentDateStr = getTimeStamp();
    let currentPath = window.location.pathname.split('/')[2]

    var mutilDevice = '<?=json_encode($deviceArr)?>';
    var mutilDeviceJson = $.parseJSON(mutilDevice);

    console.log(mutilDeviceJson);

    if(currentPath == 'monitoringView.php') {
        setBuldingSession()
        console.log(Object.keys(deviceSerialNoListJson).length )
        if( Object.keys(deviceSerialNoListJson).length > 0){
            mobileMornitoringView( config, deviceSerialNoListJson, sessionListJson.user_auth)

            setInterval(function() {
                $(".danger_blink").toggleClass("status-danger")
            }, 1000);
        }else{
            document.getElementsByTagName('body')[0].classList.remove("whirl", "traditional");
            document.getElementsByTagName('section')[0].classList.remove("d-none");
            document.getElementsByTagName('section')[1].classList.remove("d-none");
            document.getElementsByTagName('section')[2].classList.remove("d-none");
            document.getElementsByTagName('section')[3].classList.remove("d-none");
        }
    }
    if(currentPath == 'mTest.php') {
        setBuldingSession()
        console.log(Object.keys(deviceSerialNoListJson).length )
        if( Object.keys(deviceSerialNoListJson).length > 0){
            mobileMornitoringView2( config, deviceSerialNoListJson, sessionListJson.user_auth)

            setInterval(function() {
                $(".alarm-inch").toggleClass("status-danger")
            }, 1000);
        }else{
            document.getElementsByTagName('body')[0].classList.remove("whirl", "traditional");
            document.getElementsByTagName('section')[0].classList.remove("d-none");
            document.getElementsByTagName('section')[1].classList.remove("d-none");
            document.getElementsByTagName('section')[2].classList.remove("d-none");
            document.getElementsByTagName('section')[3].classList.remove("d-none");
        }
    }
    else if(currentPath == 'buildingView.php') {
        buildingList()
    }
    else if(currentPath == 'logView.php') {
        getMobileLog()
    }

    if(currentPath == 'changePasswd.php'){
        setBuldingSession()
    }

    if(typeof JSON.parse(sessionStorage.getItem('selectedLastBidg')) === 'object' && JSON.parse(sessionStorage.getItem('selectedLastBidg')) != null){
        document.getElementById("curBuildingName").innerHTML = JSON.parse(sessionStorage.getItem('selectedLastBidg')).org_name
        document.getElementById("curBldgCount").dataset.orgcode = JSON.parse(sessionStorage.getItem('selectedLastBidg')).org_code

        headerCounting(config)
    }

    alertModifyRealTime(config, deviceSerialNoListJson)

    mobileNavigationDiv()

    $(function() {
        $("#MOVE_TOP_BTN2").click(function () {
            $('html, body').animate({
                scrollTop: 0
            }, 400);
            return false;
        });
        $("#inchConfirmBtn").click(function () {
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

            if (status == "3") {
                if (userAuth > 2) {
                    $.ajax({
                        "url": "/device/deviceAjaxProc.php",
                        "type": "post",
                        "data": {
                            "mode": "registGwByCH",
                            "SerialNo": serialNo,
                            "GatewayKey": gwKey,
                            "chType": chType,
                            "org_code": orgCode,
                            "bIdgName": bIdgName,
                            "gwCmt": gwCmt,
                            "comment": cmt
                        },
                        success: function (data) {
                            console.log(data)
                            $("#recentHistory2").modal("hide")
                            alertMessage("해제 되었습니다.")
                        }
                    })
                } else {
                    $("#recentHistory2").modal("hide")
                }
            } else {
                $("#recentHistory2").modal("hide")
            }
        })

        $(document).on('click', '[name=confirmBtn]', function () {
            let alarmMessage = document.getElementById("alarm-message")

            var x = document.getElementById("myAudio");

            var pEle = $(this)

            let bIdgName = document.getElementById("myBuildingName").value;
            var cmt = $(this).parent("p").data("cmt");
            var gwkey = $(this).parent("p").data("gwkey");
            var chNo = $(this).parent("p").data("chno");
            var type = "12";
            var serialNo = $(this).parent("p").data("serialno");
            var gwCmt = $(this).parent("p").data("gwcmt");

            $.ajax({
                "url": "/log/logAjaxProc.php",
                "type": "post",
                "data": {
                    "mode": "confirmHistory",
                    "comment": cmt,
                    "gwKey": gwkey,
                    "chNo": chNo,
                    "type": type,
                    "bIdgName": bIdgName,
                    "gwCmt": gwCmt,
                    "serialNo": serialNo
                },
                success: function (data) {
                    pEle.parent("p").remove();

                    console.log(alarmMessage.childElementCount)

                    if (alarmMessage.childElementCount == 0) {
                        $("#alarmModal").modal("hide");
                        x.pause();
                    }
                }
            })


        });
    })

</script>

</body>
</html>
