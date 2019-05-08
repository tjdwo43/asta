<?
	include $_SERVER[DOCUMENT_ROOT]."/inc/header.php";

	include $_SERVER[DOCUMENT_ROOT]."/device/deviceConfAsside.php";
?>
<style type="text/css">
	.table td {
		max-width : 100px;
		min-width : 100px;
	}
</style>
<section class="section-container">
	<!-- Page content-->
	<div class="content-wrapper">
		<div class="content-heading">
			<div>장비 모니터링 & 제어</div>
		</div>
		
		<?if(count($getDeviceList['data']) > 0){?>
		<!-- Gateway board Info -->
			<div class="card card-default" id="gwCard">
				<!-- START table-responsive-->
				<div class="table-responsive pb-3">
					<table class="table table-bordered">
						<colgroup>
							<col>
							<col width=120><!-- in1 -->
							<col width=120><!-- in2 -->
							<col width=120><!-- in3 -->
							<col width=120><!-- in4 -->
							<col width=120><!-- in5 -->
							<col width=120><!-- in6 -->
							<col width=120><!-- out1 -->
							<col width=120><!-- out2 -->
							<col width=120><!-- out3 -->
							<col width=100><!-- temperate -->
							<col width=100><!-- humid -->
							<col width=100><!-- Gas -->
						</colgroup>
						<thead>
							<tr>
								<th>이름</th>
								<th>입력1</th>
								<th>입력2</th>
								<th>입력3</th>
								<th>입력4</th>
								<th>입력5</th>
								<th>입력6</th>
								<th>출력1</th>
								<th>출력2</th>
								<th>출력3</th>
								<th>온도</th>
								<th>습도</th>
								<th>가스</th>
							</tr>
						</thead>
						<tbody id="gwList">
						</tbody>
					</table>
				</div>
			</div>
		<!-- Gateway board Info End-->
		<?}else{?>
			<div class="card card-default">
				<div class="card-header"><h4>데이터가 없습니다. 장비 설정에서 장비 등록을 해주세요</h4></div>
			</div>
		<?}?>
	</div><!-- PageContent End -->
</section>

</div>
<!-- 출력 제어 ON/OFF 모달 -->
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
					<div class="form-group">
						<div class="text-center">
							<label class="c-radio">
								<input id="inlineradio1" type="radio" name="useYN" value="1">
								<span class="fa fa-circle"></span> ON
							</label>

							<label class="c-radio">
								<input id="inlineradio2" type="radio" name="useYN" value="2">
								<span class="fa fa-circle"></span> OFF
							</label>
						</div>
					</div>
				</form>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="saveOutControl" >저장</button>
				<button type="button" class="btn btn-danger" id="closeOutControl" >취소</button>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
	var returnDataArr;
	var pDataArr;

    //var deviceSerialNoList = '<?=json_encode($getSerialNo)?>';
    //var deviceSerialNoListJson = $.parseJSON(deviceSerialNoList);

    var test;
	//디바이스
	var getSerialNo = getParameter('serialNo');

	$(document).ready(function(){
        var serialNo;
		$(document).on("click", ".getDeviceList", function(){	//눌렀을 때 디바이스 정보 보기
			$('[name=deviceList]').children('.getDeviceList').each(function(){
				$(this).removeClass("clickedList");
			});
			if(!getSerialNo || getSerialNo.indexOf("#") != -1){
				serialNo = $(this).data('serialnum');
				test = $(this).data('serialnum');

				$.ajax({
					url : "/device/deviceAjaxProc.php",
					type : "post",
					data : {
						'mode' : 'getMornDevice_n',
						'SerialNo' : serialNo
					},
					success : function(data){
						returnData = $.parseJSON(data);
						
						returnDataArr = returnData['data'];
						$("#gwList").html(returnData['html']);
					},
					beforeSend : function(){
						$(".wrapper").addClass("whirl traditional");
					},
					complete : function(){
						$(".wrapper").removeClass("whirl traditional");
					}
				});

				$('[name=deviceList]').children('.getDeviceList').each(function(){
					if($(this).data('serialnum') == serialNo) {
						$(this).addClass("clickedList");
					}
				});
			}else {
				$.ajax({
					url : "/device/deviceAjaxProc.php",
					type : "post",
					data : {
						'mode' : 'getMornDevice_n',
						'SerialNo' : getSerialNo
					},
					success : function(data){
						returnData = $.parseJSON(data);
						returnDataArr = returnData['data'];
						$("#gwList").html(returnData['html']);
					},
					beforeSend : function(){
						$(".wrapper").addClass("whirl traditional");
					},
					complete : function(){
						$(".wrapper").removeClass("whirl traditional");
					}
				});

				$('[name=deviceList]').children('.getDeviceList').each(function(){
					if($(this).data('serialnum') == getSerialNo) {
						$(this).addClass("clickedList");
					}
				});

				getSerialNo += "#";
			}
		}).find('.getDeviceList').eq(0).trigger('click');

		var outchOnOff = [];
		var thisIndex;
		var serialNo;
		var gatewayKey;
		var thisTd;

		$(document).on("click", ".outch", function(){			//출력 수정
			thisIndex = ($(this).closest('tr').find("td").index(this)) - 7;

			var outch1 = $(this).closest('tr').children('td').eq(7);
			var outch2 = $(this).closest('tr').children('td').eq(8);
			var outch3 = $(this).closest('tr').children('td').eq(9);

			thisTd = $(this);
			
			//OnOff 값저장
			outchOnOff = [];
			outchOnOff.push(outch1.attr("data-onoff"));
			outchOnOff.push(outch2.attr("data-onoff"));
			outchOnOff.push(outch3.attr("data-onoff"));

			serialNo = $(this).closest('tr').find("[name=serialNo]").val();
			gatewayKey = $(this).closest('tr').find("[name=gatewayKey]").val();

			//console.log(thisTd);
			
			/* 이전 값 */
			/*
			if(thisTd.data('onoff') == 2){
				$("#inlineradio2").prop("checked", true);
			}
			else if(thisTd.data('onoff') == 1){
				$("#inlineradio1").prop("checked", true);
			}
			*/

			$("#inlineradio2").prop("checked", true);
			
			$("#outControlModal").modal();

		});

		$("#saveOutControl").click(function(){
				var outch1Val = outchOnOff[0];
				var outch2Val = outchOnOff[1];
				var outch3Val = outchOnOff[2];

				var useYN = $('[name=useYN]:checked').val();

				switch (thisIndex)
				{
					case 0 : 
						outch1Val = useYN; 
						break;
					case 1 : 
						outch2Val = useYN;
						break;
					case 2 : 
						outch3Val = useYN;
						break;
				}

				$.ajax({
					url : "/device/deviceAjaxProc.php",
					type : 'post',
					data : {
						'mode' : "updateOutch",
						'SerialNo' : serialNo,
						'GatewayKey' : gatewayKey,
						'outch1' : outch1Val,
						'outch2' : outch2Val,
						'outch3' : outch3Val
					},
					success : function(data){
						if(data == 0){
							
							if(thisTd.data('onoff') == 1){
								if(useYN == 2){
									//thisTd.css({'backgroundColor': '#76bc57'});
									//thisTd.data('onoff', 2);
									alert("수정되었습니다.");
								}
							}
							else if (thisTd.data('onoff') == 2){
								if(useYN == 1){
									//thisTd.css({'backgroundColor': '#e57b80'});
									//thisTd.data('onoff', 1);
									alert("수정되었습니다.");
								}
							}
							outchOnOff = [];
							$("#outControlModal").modal('hide');
							//window.location.href="/device/deviceMornView.php?serialNo="+serialNo;
						}
					},
					beforeSend : function(){
						$(".wrapper").addClass("whirl traditional");
					},
					complete : function(){
						$(".wrapper").removeClass("whirl traditional");
					}
				});
			});

			$("#closeOutControl").click(function(){
				outchOnOff = [];
				$("#outControlModal").modal('hide');
			});
	});

    $(document).ready(function(){
        let currentDateStr = getTimeStamp();

        var config = {
            apiKey: "AIzaSyB5fynBW8XxyKncF0jfF5zkl6Ea9V7pm_g",
            authDomain: "asta-49744.firebaseapp.com",
            databaseURL: "https://asta-49744.firebaseio.com",
            projectId: "asta-49744",
            storageBucket: "asta-49744.appspot.com",
            messagingSenderId: "409436546529"
        };

        if (!firebase.apps.length) {
            firebase.initializeApp(config);
        }

        var db = firebase.firestore();

        let currentSerialNo = $("[name=deviceList]").find(".getDeviceList ").data("serialnum");

        $("[name=deviceList]").find(".getDeviceList ").each(function(){

            if($(this).hasClass("clickedList") ) currentSerialNo = $(this).data("serialnum");

        })

        var deviceRef = db.collection("tb_gateway")

        db.collection("tb_gateway").where("SerialNo", "==", currentSerialNo)
            .onSnapshot(function(snapshot) {
                snapshot.docChanges.forEach(function(change) {

                    if (change.type === "modified") {
                        console.log(change.doc.data())

                        if (change.doc.data().SerialNo == currentSerialNo) {
                            $.ajax({
                                url: "/device/deviceAjaxProc.php",
                                type: "post",
                                data: {
                                    'mode': 'getMornDevice_n',
                                    'SerialNo': currentSerialNo
                                },
                                success: function (data) {
                                    returnData = $.parseJSON(data);

                                    returnDataArr = returnData['data'];
                                    $("#gwList").html(returnData['html']);
                                },
                                beforeSend: function () {
                                    $(".wrapper").addClass("whirl traditional");
                                },
                                complete: function () {
                                    $(".wrapper").removeClass("whirl traditional");
                                }
                            });
                        }
                    }
                }); // E : onSnapshot.foreach
            }); // E : onSnapshot

    }); // E : realTime document.ready

</script>
<? include $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"?>