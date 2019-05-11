<?
	include $_SERVER[DOCUMENT_ROOT]."/inc/header.php";
	

	$ipPattern = "^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)|(([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]).){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]).){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]))$";

	$macPattern = "/^(([a-fA-F0-9]{2}-){5}[a-fA-F0-9]{2}|([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}|([0-9A-Fa-f]{4}\.){2}[0-9A-Fa-f]{4})?$/";

	$portPattern = "(6553[0-5]|655[0-2]\d|65[0-4]\d{2}|6[0-4]\d{3}|5\d{4}|[0-9]\d{0,3})";
	
	include $_SERVER[DOCUMENT_ROOT]."/device/deviceConfAsside.php";
?>

<style type="text/css">
	.mTable tr > th {
		min-width:200px;
		width : 200px;
	}
	.gTable tr > th {
		min-width:100px;
		width : 100px;
	}
	.mTable tr >th:first-child, .gTable tr > th:first-child{
		min-width:65px;
		width : 65px;
	}
	.mTable tr >th:last-child{
		min-width:120px;
		width : 120px;
	}
	
	.switch {
		justify-content : center;
	}
</style>

<section class="section-container">
	<!-- Page content-->
	<div class="content-wrapper">
		<div class="content-heading">
			<div>장비 설정</div>
		</div>

		<?if(count($getDeviceList['data']) > 0){?>
			<!-- I/O Control Gateway board Info -->
			<div class="card card-default">
				<div class="card-header">
					<h4 class="d-inline">I/O Control Gateway Board</h4>
					<button class="btn btn-info float-right" id="updatecBoardInfo">제어보드 수정</button>
				</div>
				<!-- START table-responsive-->
				<div class="table-responsive pb-3">
					<table class="table table-bordered table-hover mTable">
						<thead>
							<tr>
								<th>ON/OFF</th>
								<th>S/N</th>
								<th>이름</th>
								<th>위치</th>
								<th>고유 ID</th>
								<th>Mac Addr</th>
								<th>IP Addr</th>
								<th>Port</th>
							</tr>
						</thead>
						<tbody>
							<tr id="controlDeviceInfo">
								<td>
									<label class="switch">
										<input type="checkbox" id="controlYN" value="1">
										<span></span>
									</label>
								</td>
								<td>
									<input class="form-control " id="inputSerialNo" placeholder="SerialNo" autocomplete="off" disabled required>
								</td>
								<td>
									<div class="input-group with-focus">
										<input class="form-control " id="inputBoardName" placeholder="BoardName" autocomplete="off" required>
									</div>
								</td>
								<td>
									<div class="input-group with-focus">
										<input class="form-control " id="inputLocation" placeholder="Location" autocomplete="off" required>
									</div>
								</td>
								<td>
									<div class="input-group with-focus">
										<input class="form-control " id="inputDeviceId" placeholder="Device ID" autocomplete="off" disabled required>
									</div>
								</td>
								<td>
									<div class="input-group with-focus">
										<input class="form-control " id="inputMACAddr" placeholder="MAC Addr" autocomplete="off" pattern="<?=$macPattern?>" data-parsley-pattern="<?=$macPattern?>" required>
									</div>
								</td>
								<td>
									<div class="input-group with-focus">
										<input class="form-control " id="inputIPAddr" placeholder="IP Addr" autocomplete="off" pattern="<?=$ipPattern?>" data-parsley-pattern="<?=$ipPattern?>" required>
									</div>
								</td>
								<td>
									<div class="input-group with-focus">
										<input class="form-control " id="inputPort" placeholder="Port" autocomplete="off" pattern="<?=$portPattern?>" data-parsley-pattern="<?=$portPattern?>" required>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- I/O Control Gateway board Info End-->

			<!-- Gateway board Info -->
			<div class="card card-default" id="gwCard">
				<div class="card-header">
					<h4 class="d-inline">Gateway</h4>
					<button class="btn btn-danger float-right" id="allDeleteGw">전체 삭제</button>
				</div>
				<!-- START table-responsive-->
				<div class="table-responsive pb-3">
					<table class="table table-bordered table-hover gTable">
						<thead>
							<tr>
								<th>ON/OFF</th>
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
								<th>설정</th>
							</tr>
						</thead>
						<tbody id="gwList">
						</tbody>
					</table>
				</div>
			</div>
			<!-- Gateway board Info End-->
		<?}else{?>
			<div class="card card-defalut">
				<div class="card-header"><h4>등록 된 장비가 없습니다. 장비를 추가해 주세요</h4></div>
			</div>
		<?}?>
	</div><!-- PageContent End -->
</section>

</div>

<!-- 등록 모달 -->
<div class="modal fade" id="regDeviceModal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">I/O Control Gateway Board 등록</h4>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<div class="card card-flat">
					<div class="card-body">
						<form class="mb-3" id="registerForm" novalidate="">
							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control " id="registSerialNo" placeholder="SerialNo" autocomplete="off" required="">
								</div>
								<div class="error d-none">
									<p>중복 된 시리얼 번호입니다.</p>
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control" id="registBoardName" placeholder="BoardName" autocomplete="off" required="">
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control " id="registLocation" placeholder="Loaction" autocomplete="off" required="">
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control " id="registDeviceId" placeholder="Device ID" autocomplete="off" required="">
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control " id="registMACAddr" placeholder="MAC Addr"  pattern="<?=$macPattern?>" data-parsley-pattern="<?=$macPattern?>" autocomplete="off" required="">
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control " id="registIPAddr" placeholder="IP addr" pattern="<?=$ipPattern?>" data-parsley-pattern="<?=$ipPattern?>" autocomplete="off" required="">
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control " id="registPort" placeholder="Port" pattern="<?=$portPattern?>" data-parsley-pattern="<?=$portPattern?>" autocomplete="off" required="">
								</div>
							</div>
							<div class="form-group">
								<div class="text-center">
									<label class="c-radio">
										<input id="inlineradio1" type="radio" name="useYN" value="1" checked="">
										<span class="fa fa-circle"></span> 사용
									</label>

									<label class="c-radio">
										<input id="inlineradio2" type="radio" name="useYN" value="0">
										<span class="fa fa-circle"></span> 사용 안함
									</label>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" id="saveBtn" class="btn btn-primary" >저장</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
			</div>

		</div>
	</div>
</div>

<!-- 온도 범위 설정 모달 -->
<div class="modal fade" id="tempModal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">온도 범위 설정</h4>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<div class="card card-flat">
					<div class="card-body">
						<form class="form-horizontal">
                           <div class="form-group row">
                              <label class="col-xl-2 col-form-label">최대값</label>
                              <div class="col-xl-10">
                                 <input class="form-control" id="modalTempMax" type="text">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-xl-2 col-form-label">최소값</label>
                              <div class="col-xl-10">
                                 <input class="form-control" id="modalTempMin" type="text">
                              </div>
                           </div>
                        </form>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="saveTemp" >저장</button>
				<button type="button" class="btn btn-danger" id="closeTemp" >취소</button>
			</div>

		</div>
	</div>
</div>

<!-- 습도 범위 설정 모달 -->
<div class="modal fade" id="huModal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">습도 범위 설정</h4>
				<button type="button" class="close" data-dismiss="modal">×</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<div class="card card-flat">
					<div class="card-body">
						<form class="form-horizontal">
                           <div class="form-group row">
                              <label class="col-xl-2 col-form-label">최대값</label>
                              <div class="col-xl-10">
                                 <input class="form-control" id="modalHuMax" type="text">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-xl-2 col-form-label">최소값</label>
                              <div class="col-xl-10">
                                 <input class="form-control" id="modalHuMin" type="text">
                              </div>
                           </div>
                        </form>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="saveHu">저장</button>
				<button type="button" class="btn btn-danger" id="closeHu">취소</button>
			</div>

		</div>
	</div>
</div>

<!-- 가스 범위 설정 모달 -->
<div class="modal fade" id="gasModal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">가스 범위 설정</h4>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<div class="card card-flat">
					<div class="card-body">
						<form class="form-horizontal">
                           <div class="form-group row">
                              <label class="col-xl-2 col-form-label">최대값</label>
                              <div class="col-xl-10">
                                 <input class="form-control" id="modalGasMax" type="text">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-xl-2 col-form-label">최소값</label>
                              <div class="col-xl-10">
                                 <input class="form-control" id="modalGasMin" type="text">
                              </div>
                           </div>
                        </form>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="saveGas">저장</button>
				<button type="button" class="btn btn-danger" id="closeGas" >취소</button>
			</div>

		</div>
	</div>
</div>

<!-- 가스 범위 설정 모달 -->
<div class="modal fade" id="gasModal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">가스 범위 설정</h4>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<div class="card card-flat">
					<div class="card-body">
						<form class="form-horizontal">
                           <div class="form-group row">
                              <label class="col-xl-2 col-form-label">최대값</label>
                              <div class="col-xl-10">
                                 <input class="form-control" id="modalGasMax" type="text">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-xl-2 col-form-label">최소값</label>
                              <div class="col-xl-10">
                                 <input class="form-control" id="modalGasMin" type="text">
                              </div>
                           </div>
                        </form>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="saveGas">저장</button>
				<button type="button" class="btn btn-danger" id="closeGas" >취소</button>
			</div>

		</div>
	</div>
</div>

<!-- 템플릿 설정 -->
<div class="modal fade" id="scheduleModal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">템플릿 설정</h4>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<div class="card card-flat">
					<div class="card-body">
						<form class="form-horizontal">
                           <div class="form-group row">
                              <label class="col-form-label">주간 템플릿 이름</label>
                              <div class="col-xl-10">
                                 <select id="scheduleTempList" class="custom-select">
								 </select>
                              </div>
                           </div>
                        </form>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="saveTem">저장</button>
				<button type="button" class="btn btn-danger" id="closeTem" data-dismiss="modal">취소</button>
			</div>
		</div>
	</div>
</div>




<script type="text/javascript">
    var currentSerialNo

	$(document).ready(function(){
		var getSerialNo = getParameter('serialNo');
		var updateGatewayKey;

		$(document).on("click", ".getDeviceList", function(){	//눌렀을 때 디바이스 정보 보기
			$('[name=deviceList]').children('.getDeviceList').each(function(){
				$(this).removeClass("clickedList");
			});

			if(!getSerialNo || getSerialNo.indexOf("#") != -1){
				var serialNo = $(this).data('serialnum');
				
				for(var i=0; i < parsedJson.length; i++){
					if(parsedJson[i]['SerialNo'] == serialNo){
						$("#inputSerialNo").val(parsedJson[i]['SerialNo']);
						$("#inputBoardName").val(parsedJson[i]['BoardName']);
						$("#inputLocation").val(parsedJson[i]['Location']);
						$("#inputDeviceId").val(parsedJson[i]['DeviceId']);
						$("#inputMACAddr").val(parsedJson[i]['MACAddr']);
						$("#inputIPAddr").val(parsedJson[i]['IPAddr']);
						$("#inputPort").val(parsedJson[i]['Port']);
						
						if(parsedJson[i]['useYN'] == 1){
							$("#controlYN").attr("checked", true);
						}else{
							$("#controlYN").attr("checked", false);
						}

						$('[name=deviceList]').children('.getDeviceList').eq(i).addClass("clickedList");
					}
				}

				$.ajax({
					url : "/device/deviceAjaxProc.php",
					type : "post",
					data : {
						'mode' : 'getGWDevice',
						'SerialNo' : serialNo
					},
					success : function(data){
						//console.log(data);
						$("#gwList").html(data);
					},
					beforeSend : function(){
						$("#gwCard").addClass("whirl traditional");
					},
					complete : function(){
						$("#gwCard").removeClass("whirl traditional");
					}
				});
			}else {
				for(var i=0; i < parsedJson.length; i++){
					if(parsedJson[i]['SerialNo'] == getSerialNo){
						$("#inputSerialNo").val(parsedJson[i]['SerialNo']);
						$("#inputBoardName").val(parsedJson[i]['BoardName']);
						$("#inputLocation").val(parsedJson[i]['Location']);
						$("#inputDeviceId").val(parsedJson[i]['DeviceId']);
						$("#inputMACAddr").val(parsedJson[i]['MACAddr']);
						$("#inputIPAddr").val(parsedJson[i]['IPAddr']);
						$("#inputPort").val(parsedJson[i]['Port']);
						
						if(parsedJson[i]['useYN'] == 1){
							$("#controlYN").attr("checked", true);
						}else{
							$("#controlYN").attr("checked", false);
						}

						$('[name=deviceList]').children('.getDeviceList').eq(i).addClass("clickedList");
					}
				}

				$.ajax({
					url : "/device/deviceAjaxProc.php",
					type : "post",
					data : {
						'mode' : 'getGWDevice',
						'SerialNo' : getSerialNo
					},
					success : function(data){
						//console.log(data);
						$("#gwList").html(data);
					},
					beforeSend : function(){
						$("#gwCard").addClass("whirl traditional");
					},
					complete : function(){
						$("#gwCard").removeClass("whirl traditional");
					}
				});

				getSerialNo += "#";
			}
		}).find('.getDeviceList').eq(0).trigger('click');

        currentSerialNo = $("#inputSerialNo").val();    //현재 보고 있는 I/O controler board serialNo

		var dataSeq;	//몇번째 Row인지
		var pTempMax;	//modal tempMAX 값이 들어 있는 input
		var pTempMin;	//modal tempMin 값이 들어 있는 input

		var pHuMax;		//modal tempMin 값이 들어 있는 input
		var pHuMin;		//modal tempMin 값이 들어 있는 input

		var pGasMax;	//modal tempMin 값이 들어 있는 input
		var pGaxMin;	//modal tempMin 값이 들어 있는 input

		$("#updatecBoardInfo").click(function(){	//Control I/O 수정
			var serialNo = $("#inputSerialNo").val();
			var boardName = $("#inputBoardName").val();
			var pLocation = $("#inputLocation").val();
			var ipAddr = $("#inputIPAddr").val();
			var port = $("#inputPort").val();
			var deviceId = $("#inputDeviceId").val();
			var macAddr = $("#inputMACAddr").val();
			if($("#controlYN:checked").val() == '1'){
				controlUse = 1;
			}else{
				controlUse = 2;
			}
			var regist_seq = '<?=$regist_seq?>';

			$("#inputBoardName").parsley().validate();
			$("#inputLocation").parsley().validate();
			$("#inputDeviceId").parsley().validate();
			$("#inputIPAddr").parsley().validate();
			$("#inputPort").parsley().validate();
			$("#inputMACAddr").parsley().validate();
			
			if($("#inputBoardName").parsley().isValid() && $("#inputLocation").parsley().isValid() && $("#inputDeviceId").parsley().isValid() && $("#inputIPAddr").parsley().isValid() && $("#inputPort").parsley().isValid() && $("#inputMACAddr").parsley().isValid()){
				$.ajax({
					url : '/device/deviceAjaxProc.php',
					type : 'post',
					data : {
						'mode' : "updateDevice",
						'SerialNo' : serialNo,
						'BoardName' : boardName,
						'location' : pLocation,
						'IPAddr' : ipAddr,
						'Port' : port,
						'regist_seq' : regist_seq,
						'useYN' : controlUse,
						'DeviceId' : deviceId,
						'MACAddr' : macAddr,
					},
					success : function(data){
						alert("수정 되었습니다.");
						//window.location.href="/device/deviceConfView.php?serialNo="+serialNo;
					}
				});
			}
		});

		$(document).on("change", ".useChange, .inputChange, .outChange, .cmt", function(){	//값 변경 여부
			var thisBtnGroup = ($(this).hasClass("cmt"))?$(this).closest("tr").prev().find('[name=updateGW]'):$(this).closest("tr").find('[name=updateGW]');	//변경 된 btn group div 위치
			var useChangeYN = $(this).closest("tr").children('[name=useChangeVal]');	//변경 여부 Input값
			var inChangeYN = $(this).closest("tr").children('[name=inChangeVal]');
			var outChangeYN = $(this).closest("tr").children('[name=outChangeVal]');
			//var btnChangeYN = ($(this).hasClass("cmt"))?$(this).closest("tr").prev().find("[name=addBtnYN]"):$(this).closest("tr").children('[name=addBtnYN]');

			if($(this).hasClass("useChange")){
				useChangeYN.val(1);
			}else if($(this).hasClass("inputChange")){
				inChangeYN.val(1);
			}else if($(this).hasClass("outChange")){
				outChangeYN.val(1);
			}
			
			/*
			if(btnChangeYN.val() == 0){
				thisBtnGroup.prop("disabled", false);
				btnChangeYN.val(1);
			}
			*/
		});

		$(document).on("click", "[name=updateGW]", function(){	//Gateway 수정
			dataSeq = $(this).closest('tr').children("[name=keyValue]").val();
			var serialNo = $("#inputSerialNo").val();

			var gwData = [];	//현재 Row 상태 값들
			var cmtData = [];	//현재 Row Comment 값들
			
			var tempMax = $("[name=tempMax"+dataSeq+"]").val();	//tempMax 값
			var tempMin = $("[name=tempMin"+dataSeq+"]").val();	//tempMin 값
			var tempYN = ($("[name=gw"+dataSeq+"]").eq(11).is(":checked"))?'1':'2';

			var huMax = $("[name=huMax"+dataSeq+"]").val();		//huMax 값
			var huMin = $("[name=huMin"+dataSeq+"]").val();		//huMin 값
			var huYN = ($("[name=gw"+dataSeq+"]").eq(12).is(":checked"))?'1':'2';

			var gasMax = $("[name=gasMax"+dataSeq+"]").val();	//gasMax 값
			var gasMin = $("[name=gasMin"+dataSeq+"]").val();	//gasMin 값
			var gasYN = ($("[name=gw"+dataSeq+"]").eq(13).is(":checked"))?'1':'2';
			
			var inputchUseVal = $(this).closest("tr").children('[name=useChangeVal]').val();	
			var inputchInVal = $(this).closest("tr").children('[name=inChangeVal]').val();
			var inputchOutVal = $(this).closest("tr").children('[name=outChangeVal]').val();
			
			var gatewayUse = $(this).closest("tr").find('.useChange').is(":checked");

			if(gatewayUse == 1){
				gatewayUse = 1;
			}else{
				gatewayUse = 2;
			}
				
			$("[name=gw"+dataSeq+"]").each(function (i) {
				gwData.push($("[name=gw"+dataSeq+"]").eq(i).val());
            });

			$("[name='cmt"+dataSeq+"']").each(function (i) {
                cmtData.push($("input[name=cmt"+dataSeq+"]").eq(i).val());
            });
				
			var useYNLog = (inputchUseVal == 1)?gatewayUse+""+1:gatewayUse+""+0;
			
			if(inputchInVal == 1 && inputchOutVal == 1){
				useYNLog += 3;
			}else if(inputchInVal == 1 && inputchOutVal == 0){
				useYNLog += 1;
			}else if(inputchInVal == 0 && inputchOutVal == 1){
				useYNLog += 2;
			}else{
				useYNLog += 0;
			}

			$.ajax({
				'url' : '/device/deviceAjaxProc.php',
				'type' : 'post',
				'data' : {
					'mode' : "updateGW",
					'SerialNo' : serialNo,
					'GatewayKey' : gwData[0],
					'GatewayUseYN' : useYNLog,
					'GatewayName' : gwData[1],
					'inch1Select' : gwData[2],
					'inch2Select' : gwData[3],
					'inch3Select' : gwData[4],
					'inch4Select' : gwData[5],
					'inch5Select' : gwData[6],
					'inch6Select' : gwData[7],
					
					'outch1Select' : gwData[8],
					'outch2Select' : gwData[9],
					'outch3Select' : gwData[10],

					'tempYN' : tempYN,
					'huYN' : huYN,
					'gasYN' : gasYN,

					'GatewayCmt' : cmtData[0],

					'inch1Cmt' : cmtData[1],
					'inch2Cmt' : cmtData[2],
					'inch3Cmt' : cmtData[3],
					'inch4Cmt' : cmtData[4],
					'inch5Cmt' : cmtData[5],
					'inch6Cmt' : cmtData[6],

					'outch1Cmt' : cmtData[7],
					'outch2Cmt' : cmtData[8],
					'outch3Cmt' : cmtData[9],

					'tempCmt' : cmtData[10],
					'huCmt' : cmtData[11],
					'gasCmt' : cmtData[12],

					//온도 값
					'tempMax' : tempMax,
					'tempMin' : tempMin,
					//습도 값
					'huMax' : huMax,
					'huMin' : huMin,
					//가스 값
					'gasMax' : gasMax,
					'gasMin' : gasMin
				},
				success : function(data){
					if(data == 0){
                        updateGatewayKey = gwData[0];

                        currentSerialNo = $("#inputSerialNo").val();    //현재 보고 있는 I/O controler board serialNo

                        console.log ( updateGatewayKey )

						alert("수정되었습니다.");
						//window.location.href="/device/deviceConfView.php?serialNo="+serialNo;
					}else{
						alert("수정 실패.");
					}
				}
			});
		});
		
		$(document).on("click", ".tempModal", function(){	//온도 설정 모달
			var tempCheckbox = $(this);

			$(this).closest("tr").find('[name=updateGW]').prop("disabled", false);

			if($(this).is(":checked")){
				pTempMax = $(this).closest("tr").children().eq(2);
				pTempMin = $(this).closest("tr").children().eq(3);

				$("#modalTempMax").val(pTempMax.val());
				$("#modalTempMin").val(pTempMin.val());

				$("#tempModal").modal();
			}

			$("#closeTemp").click(function(){
				tempCheckbox.prop("checked", false);
				$("#tempModal").modal('hide');
			});
		});

		$("#saveTemp").click(function(){					//온도 설정 저장
			pTempMax.val($("#modalTempMax").val());
			pTempMin.val($("#modalTempMin").val());

			if( pTempMax.val() < pTempMin.val() ){
			    alert("최소값이 최대값보다 큽니다.");
			    return;
            }else {
                $("#tempModal").modal('hide');
            }
			

		});

		$(document).on("click", ".huModal", function(){		//습도 설정 모달
			var huCheckbox = $(this);
				
			$(this).closest("tr").find('[name=updateGW]').prop("disabled", false);

			if($(this).is(":checked")){
				pHuMax = $(this).closest("tr").children().eq(4);
				pHuMin = $(this).closest("tr").children().eq(5);

				$("#modalHuMax").val(pHuMax.val());
				$("#modalHuMin").val(pHuMin.val());

				$("#huModal").modal();
			}

			$("#closeHu").click(function(){
				huCheckbox.prop("checked", false);
				$("#huModal").modal('hide');
			});
		});

		$("#saveHu").click(function(){
			pHuMax.val($("#modalHuMax").val());
			pHuMin.val($("#modalHuMin").val());


            if( pHuMax.val() < pHuMin.val() ){
                alert("최소값이 최대값보다 큽니다.");
                return;
            }else {
                $("#huModal").modal('hide');
            }


		});

		$(document).on("click", ".gasModal", function(){	//가스 설정 모달
			var gasCheckbox = $(this);
			$(this).closest("tr").find('[name=updateGW]').prop("disabled", false);
			if($(this).is(":checked")){
				pGasMax = $(this).closest("tr").children().eq(6);
				pGasMin = $(this).closest("tr").children().eq(7);

				$("#modalGasMax").val(pGasMax.val());
				$("#modalGasMin").val(pGasMin.val());

				$("#gasModal").modal();
			}
			$("#closeGas").click(function(){
				gasCheckbox.prop("checked", false);
				$("#gasModal").modal('hide');
			});
		});

		$("#saveGas").click(function(){						//가스 설정 저장
			pGasMax.val($("#modalGasMax").val());
			pGasMin.val($("#modalGasMin").val());


            if( pGasMax.val() < pGasMin.val() ){
                alert("최소값이 최대값보다 큽니다.");
                return;
            }else {
                $("#gasModal").modal('hide');
            }


		});

		$(document).on("click", "[name=delGWBtn]", function(){	//게이트웨이 삭제
			$(this).closest('tr').next().remove();
			$(this).closest('tr').remove();
		});
		
		var keyValue;
		var outch;
		var selectedValue;
		var selectedOption;
		var selectFirstNoneEvent = 0;

		$(document).on("click", ".outChange", function(){	// 타임 스케줄로 셀릭트 값 바꿨을 떄
			if(selectFirstNoneEvent != 0){	//select 눌러을 때 이벤트 방지용
				keyValue = $(this).parents('td').siblings('[name=keyValue]').val();
				
				outch = $(this).data('outch');

				if(outch == '1'){
					selectedValue = $("[name=outch1TS]").eq(keyValue).val();
				}else if(outch == '2'){
					selectedValue =  $("[name=outch2TS]").eq(keyValue).val();
				}else if(outch == '3'){
					selectedValue =  $("[name=outch3TS]").eq(keyValue).val();
				}
				
				selectedOption = $("option:selected", this).val();

				if(selectedOption == '3'){
					$.ajax({
						url : '/device/deviceAjaxProc.php',
						type : 'post',
						data : {'mode' : 'getScheduleTemplate'},
						success : function(data){
							$("#scheduleTempList").html(data);
							$("#scheduleTempList").val(selectedValue);
							$("#scheduleModal").modal();
							selectFirstNoneEvent = 0;
						}
					});
				}
			}else {
				selectFirstNoneEvent = 1;
			}
		});

		$(document).on("click", "#saveTem", function(){
			var serialNo = $("#inputSerialNo").val();
			var gatewayKey = $("[name=gw"+keyValue+"]").val();
			var selectVal = $("#scheduleTempList").val();

			if(outch == '1'){
				$("[name=outch1TS]").eq(keyValue).val(selectVal);
			}else if(outch == '2'){
				$("[name=outch2TS]").eq(keyValue).val(selectVal);
			}else if(outch == '3'){
				$("[name=outch3TS]").eq(keyValue).val(selectVal);
			}

			$.ajax({
				'url' : '/device/deviceAjaxProc.php',
				'type' : 'post',
				'data' : {
					'mode' : 'updateGWTS',
					'serialNo' : serialNo,
					'gatewayKey' : gatewayKey,
					'outch1TS' : $("[name=outch1TS]").eq(keyValue).val(),
					'outch2TS' : $("[name=outch2TS]").eq(keyValue).val(),
					'outch3TS' : $("[name=outch3TS]").eq(keyValue).val()
				},
				success : function (data){
					$("#scheduleModal").modal('hide');
				}
			});
		});

		$(document).on("click", "#allDeleteGw", function(){	//게이트 웨이 일괄 삭제

			var serialNo = $("#inputSerialNo").val();

			if(confirm("모든 Gateway가 삭제됩니다.")){
				$.ajax({
					url : '/device/deviceAjaxProc.php',
					type : 'post',
					data : {'mode' : 'allDeleteGW', 'serialNo' : serialNo},
					success : function (data) {
						if(data == '0') {
							window.location.reload();
						}
					}
				});
			}
		});

	}); // E : device Jquery 끝
</script>

<? include $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"?>