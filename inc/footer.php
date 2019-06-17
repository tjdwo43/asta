		<?if($isMobileBar){?>
			<!-- 모바일 하단 탭바 -->
<!--			<div class="mobile-navbar">-->
<!--				<a data-toggle-state="aside-toggled" data-no-persist="true">-->
<!--					<em class="fas fa-bars"></em>-->
<!--				</a>-->
<!--				<a onclick="movetop();">-->
<!--					<em class="fas fa-chevron-up"></em>-->
<!--				</a>-->
<!--			</div>-->
		<?}?>

        <audio id="myAudio" loop>
            <source src="/alarm3rev.wav" type="audio/ogg">
<!--            <source src="horse.mp3" type="audio/mpeg">-->
            Your browser does not support the audio element.
        </audio>

        <div class="modal manualRegist" id="sessionModal" style="display:none" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal body -->
                    <div class="modal-body" id="delete-body-Modal">
                        <span>세션이만료되어 다시 로그인 해주세요</span>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='/loginView.php';">확인</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal manualRegist" id="deleteCompleteModal" style="display:none" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal body -->
                    <div class="modal-body" id="delete-body-Modal">
                        <span class="text-danger">삭제되었습니다.</span>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-xs" onclick="window.location.reload()">확인</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal manualRegist" id="deleteConfModal" style="display:none" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal body -->
                    <div class="modal-body">
                        <span class="text-danger">삭제하시겠습니까?</span>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-xs" onclick="deleteModal();">삭제</button>
                        <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">취소</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal manualRegist" id="deleteBIdgModal" style="display:none" aria-hidden="true">
            <div class="modal-dialog">
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
                        <span class="text-danger">건물을 삭제 할 경우, 등록되어 있는 사용자와 장비 정보가 모두 삭제됩니다. 삭제 하시겠습니까?</span>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-xs" onclick="deleteModal();">삭제</button>
                        <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">취소</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal manualRegist" id="alertModal" style="display:none" aria-hidden="true">
            <div class="modal-dialog">
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

        <div class="modal manualRegist" id="alertModalR" style="display:none" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <!--                    <div class="modal-header">-->
                    <!--                        <h4 class="modal-title">수동등록</h4>-->
                    <!--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                    <!--                            <span aria-hidden="true">&times;</span>-->
                    <!--                        </button>-->
                    <!--                    </div>-->

                    <!-- Modal body -->
                    <div class="modal-body" id="modal-messageR">

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-xs" onclick="window.location.reload();">확인</button>
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

        <div class="modal manualRegist" id="logoutModal" style="display:none" aria-hidden="true">
            <div class="modal-dialog">
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

        <div class="modal manualRegist" id="chPasswModal" style="display:none" aria-hidden="true">
            <div class="modal-dialog">
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
                        처음 로그인 하셨습니다. 비밀번호 변경을 해주세요.
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-xs" onclick="window.location.href = '/user/userManage.php?chPass=1'">확인</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">취소</button>
                    </div>

                </div>
            </div>
        </div>

		<script type="text/javascript">
            <?
            if($basename != "loginView.php"){
                if(empty($_SESSION)){
                    echo 'sessionMessage("세션이만료되어 다시 로그인해주세요.");';
                }
            }
            ?>
            var firstLoginCheck = getParameter("s");

            if(firstLoginCheck == 1){

                $("#chPasswModal").modal("show");
            }

            //시리얼 리스트
            var deviceSerialNoList = '<?=json_encode($getSerialNo)?>';
            var deviceSerialNoListJson = $.parseJSON(deviceSerialNoList);

            var mutilDevice = '<?=json_encode($deviceArr)?>';
            var mutilDeviceJson = $.parseJSON(mutilDevice);

            console.log(mutilDeviceJson)

            let bIdgList2 = '<?=json_encode($getBuildingList['data'])?>';
            let bIdgListJson2 = JSON.parse(bIdgList2);

            var auth = document.getElementById("auth").value

            console.log(bIdgListJson2)

            if(bIdgListJson2 != null){
                if(document.getElementById("seq").value != "4"){
                    if(bIdgListJson2.length > 1){
                        document.getElementById("myBuildingName").value = bIdgListJson2[0].org_name + " 외 " + (bIdgListJson2.length - 1) + "개"
                    }else{
                        document.getElementById("myBuildingName").value = bIdgListJson2[0].org_name
                    }
                }
            }

            let seq = document.getElementById("seq").value;

            if(seq != ''){
                if(localStorage.getItem(seq) == null){

                    localStorage.setItem(seq, JSON.stringify(bIdgListJson2))

                    let list = JSON.parse(localStorage.getItem(seq) )

                    if(list.length != 0){
                        let name;
                        if(list.length - 1 == 0){
                            name = list[0].org_name
                        }else{
                            name = list[0].org_name + " 외 " + (list.length - 1) + "개"
                        }

                        document.getElementById("headerBIdgName").innerHTML = name;
                    }else{
                        let name = "건물을 등록 해 주세요.";

                        document.getElementById("headerBIdgName").innerHTML = name;
                    }
                }else{
                    let list = JSON.parse(localStorage.getItem(seq) )

                    let checkbox = document.getElementsByName("checkOne")

                    for (i in list)
                    {
                        for (var d = 0; d < checkbox.length; d++)
                        {
                            if(checkbox[d].value == (list[i].org_code+"_"+list[i].org_name) ){
                                checkbox[d].checked = true;
                            }
                        }
                    }

                    if(list.length != 0){
                        let name;
                        if(list.length - 1 == 0){
                            name = list[0].org_name
                        }else{
                            name = list[0].org_name + " 외 " + (list.length - 1) + "개"
                        }

                        document.getElementById("headerBIdgName").innerHTML = name;

                        if(list.length == checkbox.length) document.getElementsByName("checkAll")[0].checked = "true"
                    }
                }
            }

            console.log(deviceSerialNoListJson)

            let currentPath = window.location.pathname.split('/')[2]

            $(document).ready(function(){
                $(document).on('click', '[name=confirmBtn]', function() {
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
                        "url":"/log/logAjaxProc.php",
                        "type":"post",
                        "data":{
                            "mode":"confirmHistory",
                            "comment":cmt,
                            "gwKey":gwkey,
                            "chNo":chNo,
                            "type":type,
                            "bIdgName":bIdgName,
                            "gwCmt":gwCmt,
                            "serialNo":serialNo
                        },
                        success:function (data) {
                            pEle.parent("p").remove();

                            console.log(alarmMessage.childElementCount)

                            if(alarmMessage.childElementCount == 0){
                                $("#alarmModal").modal("hide");
                                x.pause();
                            }
                        }
                    })



                });
                /* ========================================================================*/

                $("[name=checkAll]").click(function(){	//체크 박스 전체 선택
                    allCheckFunc( this );
                });

                $("[name=checkOne]").each(function(){	//체크 박스 하나 선택
                    $(this).click(function(){
                        oneCheckFunc( $(this) );
                    });
                });


                let config = fireStoreConf();

                if(currentPath == 'deviceMornView.php') {
                    updateMornViewRealTime(config, deviceSerialNoListJson)
                }

                if(currentPath == 'deviceConf.php') {
                    web_device_conf(config)
                }

                if(currentPath == 'monitor_view.php'){
                    if(auth == "4"){
                        monitoringView(config);
                    }else{
                        monitoringView2(config);
                    }
                }

                if(currentPath == 'mvTest.php'){
                    monitoringView2(config);
                }

                if(currentPath == 'monitor_view_admin.php'){
                    adminMonitoringView(config)
                }

                if(currentPath == 'userManage.php'){
                    userListperOrg()
                }


                if(auth == "4"){
                    for(d in deviceSerialNoListJson){
                        var deviceObj = []
                        deviceObj[d] = deviceSerialNoListJson[d]

                        console.log(deviceSerialNoListJson[d])

                        alertModifyRealTime(config, deviceObj)
                    }
                }else{
                    for(s in mutilDeviceJson){

                        for(ss in mutilDeviceJson[s]){

                            var deviceObj2 = []

                            deviceObj2[ss] = mutilDeviceJson[s][ss];

                            alertModifyRealTime(config, deviceObj2)
                        }
                    }
                }

            }); // E : realTime document.ready

		</script>
	</body>
</html>
