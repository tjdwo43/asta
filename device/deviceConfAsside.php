<!-- sidebar-->
<aside class="aside-container">
	<!-- START Sidebar (left)-->
	<div class="aside-inner">
		<nav class="sidebar" data-sidebar-anyclick-close="">
			<!-- START sidebar nav-->
			<ul class="sidebar-nav">
				<!-- Iterates over all sidebar items-->
				<li class="active">
					<a>
						<!-- <div id="countUser" class="float-right badge badge-success"><?=count($userList[data]);?></div>  -->
						<div class="checkbox c-checkbox d-inline-block">
							<label>
								<input type="checkbox" name="checkAll">
								<span class="fa fa-check"></span>
							</label>
						</div>
						<span>장비 목록</span>
					</a>
					<ul class="sidebar-nav sidebar-subnav collapse show" id="dashboard">
						<?foreach($getDeviceList[data] as $deviceVal){?>
							<li name="deviceList">
								<a href="#" class="getDeviceList text-truncate" data-serialNum = "<?=$deviceVal[SerialNo]?>"> 
									<div class="checkbox c-checkbox d-inline-block " >
										<label>
											<input type="checkbox" name="checkOne" value="<?=$deviceVal[SerialNo]?>">
											<span class="fa fa-check"></span>
										</label>
									</div>
									<span><?=$deviceVal[SerialNo];?></span>
									<div class="text-truncate">
										<span>이름 : <?=$deviceVal[BoardName];?></span>
									</div>
									<span>위치 : <?=$deviceVal[Location];?></span>
								</a>
							</li>
						<?}?>
					</ul>
				</li>
			</ul>
			<?if(($_SESSION['user_auth'] == '4' || $_SESSION['user_auth'] == '3') && $basename == "deviceConfView.php"){?>
				<div class="btn-group m-2 float-right">
					<button class="btn btn-sm btn-outline-info" type="button" id="registDevice">장비 추가</button>
					<button class="btn btn-sm btn-outline-danger" type="button" id="delBtn">삭제</button>
				</div>
			<?}?>
			<!-- END sidebar nav-->
		</nav>
	</div>
	<!-- END Sidebar (left)-->
</aside>

<script type="text/javascript">
	//유저 리스트 
	var deviceList = '<?=json_encode($getDeviceList[data])?>';
	var parsedJson = $.parseJSON(deviceList);

	$(document).ready(function () {
		$("[name=checkAll]").click(function(){	//체크 박스 전체 선택
			allCheckFunc( this );
		});

		$("[name=checkOne]").each(function(){	//체크 박스 하나 선택
			$(this).click(function(){
				oneCheckFunc( $(this) );
			});
		});

		$("#registDevice").click(function(){	//모달 창 띄움
			$("#regDeviceModal").modal();
		});
		
		$("#saveBtn").click(function(){			//regForm 저장
			var returnData;

			var serialNo = $("#registSerialNo").val();
			var boardName = $("#registBoardName").val();
			var pLocation = $("#registLocation").val();
			var deviceId = $("#registDeviceId").val();
			var macAddr = $("#registMACAddr").val();
			var ipAddr = $("#registIPAddr").val();
			var port = $("#registPort").val();
			var useYN = $("[name=useYN]:checked").val();

			$("#registSerialNo").parsley().validate();
			$("#registBoardName").parsley().validate();
			$("#registLocation").parsley().validate();
			$("#registDeviceId").parsley().validate();
			$("#registIPAddr").parsley().validate();
			$("#registPort").parsley().validate();
			$("#registMACAddr").parsley().validate();

			if($("#registSerialNo").parsley().isValid() && $("#registBoardName").parsley().isValid() && $("#registLocation").parsley().isValid() && $("#registDeviceId").parsley().isValid() && $("#registIPAddr").parsley().isValid() && $("#registPort").parsley().isValid() && $("#registMACAddr").parsley().isValid()){
				$.ajax({
					url : '/device/deviceAjaxProc.php',
					type : 'post',
					data : {
						'mode' : 'registDevice',
						'SerialNo' : serialNo,
						'BoardName' : boardName,
						'Location' : pLocation,
						'DeviceId' : deviceId,
						'MACAddr' : macAddr,
						'IPAddr' : ipAddr,
						'Port' : port,
						'regist_seq' : '<?=$_SESSION[user_seq]?>',
						'org_code' : '<?=$_SESSION[user_orgCode]?>',
						'useYN' : useYN,
						'id' : '<?=$_SESSION[user_id]?>'
					},
					success : function(data){
						if(data == 0){
							window.location.reload();
						}
						else{
							$('.error').removeClass("d-none");
						}
						
					}
				});
			}
		});

		$("#delBtn").click(function(){			// control I/O 삭제
			var checkedIdxArr = [];	//체크된 등록 리스트 값 
			var checkedIdx = "";

			var boardName = $("#inputBoardName").val();
			var pLocation = $("#inputLocation").val();
			var ipAddr = $("#inputIPAddr").val();
			var port = $("#inputPort").val();
			var deviceId = $("#inputDeviceId").val();
			var macAddr = $("#inputMACAddr").val();
			if($("#controlYN:checked").val() == '1'){
				controlUse = 1;
			}else{
				controlUse = 0;
			}

			$("input[name=checkOne]:checked").each(function(){
				checkedIdxArr.push($(this).val());
			});
			
			checkedIdx = checkedIdxArr.join(",");
			
			$.ajax({
				url : "/device/deviceAjaxProc.php",
				type : 'post',
				data : {
					'mode' : 'deleteDevice',
					'serialNo' : checkedIdx,
					'BoardName' : boardName,
					'Location' : pLocation,
					'IPAddr' : ipAddr,
					'Port' : port,
					'useYN' : controlUse,
					'DeviceId' : deviceId,
					'MACAddr' : macAddr
				},
				success : function(){
					alert("삭제 되었습니다.");
					
					$("input[name=checkOne]:checked").each(function(){
						$(this).closest('li').remove();
					});

					//$("#countUser").text($("[name=userInfo]").length);
				}
			});
		});
	});
</script>