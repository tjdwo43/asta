<?
	include $_SERVER[DOCUMENT_ROOT]."/inc/header.php";
	include $_SERVER[DOCUMENT_ROOT]."/user/user.php";

	$deviceSerialNumList = array();

	foreach($getDeviceList['data'] as $deviceData){
		$deviceSerialNumList[] = $deviceData['SerialNo'];
	}
	
	//검색 유저리스트
	$postData = Array(
		'org_code' => $_SESSION['user_orgCode'],
		'auth'	=>	$_SESSION['user_auth'],
		'superId' => ($_SESSION['user_auth'] == 4)?"":$_SESSION['user_seq']
	);
	

	$userList = getListUser($postData);

	$userNameList =  array();
	$userIdList =  array();	
	foreach($userList['data'] as $userData){
		$userNameList[] = $userData['name'];
		$userIdList[] = $userData['id'];
	}

	$today = date("Y-m-d");
?>
<!-- =============== datetimepicker.css" ======= -->
<link href="/css/jquery.datetimepicker.min.css" type="text/css" rel="stylesheet"><!-- datetimepicker -->

<section>
	<!-- Page content-->
	<div class="content-wrapper" >
		<div class="content-heading">이력 조회</div>
		<!-- 검색 -->
		<div class="row">
			<div class="col-xl-12">
				<!-- Main card-->
				<div class="card b p-3">
					<!-- 검색 조건 -->
					<div class="row">
						<!-- 조회 일자 시작 -->
						<div class="col-md-auto">
							<div class="input-group ">
								<div class="input-group-prepend">
									<span class="input-group-text"><em class="fa fa-calendar"></em></span>
								</div>
								<input class="form-control" id="sDate" type="text" placeholder="시작 일" value="<?=$today?>">
							</div>
						</div>
						<div class="col-md-auto">
							<div class="input-group ">
								<div class="input-group-prepend">
									<span class="input-group-text"><em class="fa fa-calendar"></em></span>
								</div>
								<input class="form-control" id="eDate" type="text" placeholder="종료 일" value="<?=$today?>">
							</div>
						</div>
						<!-- 조회 일자 끝 -->
						<div class="col-md-3">
							<div class="input-group ">
								<div class="input-group-prepend">
									<select class="custom-select" id="typex">
										<option value="1">I/O Control S/N</option>
										<option value="2">ID</option>
										<option value="3">이름</option>
									</select>
								</div>
								<select id="key" class="custom-select"></select>
								<div class="input-group-append">
									<button class="btn btn-outline-secondary" type="button" id="searchLog">
										<em class="fa fa-search"></em>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- 검색 -->
		
		<!-- 본문 -->
		<div id="logInfo" class="card card-default ">
			<div class="card-header">이력 조회</div>
			<div class="card-body">
				<p>보시고 싶은 날짜와 검색 명을 입력해주세요.</p>
			</div>
		</div>
		<!-- 본문 끝 -->
	</div>
</section>
<!-- selection End -->

</div>
<script src="/js/jquery.datetimepicker.js"></script><!-- datetimepicker -->
<script type="text/javascript">
//유저  아이디
var userIdList = '<?=json_encode($userIdList)?>';
var idJson = $.parseJSON(userIdList);
var idOptions = [];
//유저  이름
var userNameList = '<?=json_encode($userNameList)?>';
var nameJson = $.parseJSON(userNameList);
var nameOptions = [];
//디바이스 시리얼 넘버
var deviceSNList = '<?=json_encode($deviceSerialNumList)?>';
var deviceSNJson = $.parseJSON(deviceSNList);
var deviceSNOptions = [];


//idOptions.push({text:'<?=$_SESSION["user_id"]?>', value:'<?=$_SESSION["user_id"]?>'});
for(var i =0; i < idJson.length; i++){
	idOptions.push({text:idJson[i], value:idJson[i]});
}
//nameOptions.push({text:'<?=$_SESSION["user_name"]?>', value:'<?=$_SESSION["user_name"]?>'});
for(var i=0; i < nameJson.length; i++){
	nameOptions.push({text:nameJson[i], value:nameJson[i]});
}
for (var i=0; i< deviceSNJson.length; i++)
{
	deviceSNOptions.push({text:deviceSNJson[i], value:deviceSNJson[i]});
}

$(function (){
	$("#key").replaceOptions(deviceSNOptions);	//옵션 초기값

	//기간설정
	$( '#sDate' ).datetimepicker({
		lang: 'ko',
		format:'Y-m-d',
		timepicker:false,
		onSelectDate: function () {
			$( '#sDate' ).datetimepicker("hide");
			$( '#eDate' ).datetimepicker("show");
		}
	});
	$( '#eDate' ).datetimepicker({
		lang: 'ko',
		format:'Y-m-d',
		formatDate:'Y-m-d',
		timepicker:false,
		closeOnDateSelect: true,
		onShow: function () {
			var sDate = $( '#sDate' ).val();
			this.setOptions({
				minDate: sDate
			})
		}
	});

	
	$(document).on("click", "#searchLog", function(){
		var typex = $("#typex").val();
		var startDate = $("#sDate").val();
		var endDate = $("#eDate").val();
		var key = $("#key").val();

		if(startDate == "" || startDate == null) {
			alert("시작 일을 입력해 주세요."); 
			return;
		}

		if(endDate == "" || endDate == null) {
			alert("종료 일을 입력해 주세요."); 
			return;
		}

		$.ajax({
			'url' : "/log/logAjaxProc.php",
			'type' : "post",
			'data' : {
				"mode" : "getHistoryList",
				"typex" : typex,
				"startDate" : startDate,
				"endDate" : endDate,
				"key" : key
			},
			success : function(data){
				$("#logInfo").html(data);
				//console.log(data);
			},
			beforeSend : function(){
				$(".wrapper").addClass("whirl traditional");
			},
			complete : function(){
				$(".wrapper").removeClass("whirl traditional");
			}
		});
	});

	$("#typex").change(function(){
		var typexVal = $(this).val();

		switch (typexVal) {
			case '1' : $("#key").replaceOptions(deviceSNOptions); break;
			case '2' : $("#key").replaceOptions(idOptions); break;
			case '3' : $("#key").replaceOptions(nameOptions); break;
		}

		
	});
});

$.fn.replaceOptions = function(options) {
		var self, $option;

		this.empty();
		self = this;

		$.each(options, function(index, option) {
			$option = $("<option></option>")
						.attr("value", option.value)
						.text(option.text);

			self.append($option);
		});
	};
</script>
<?include $_SERVER[DOCUMENT_ROOT]."/inc/footer.php";?>