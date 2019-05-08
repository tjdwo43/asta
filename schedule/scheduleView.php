<?
	include $_SERVER["DOCUMENT_ROOT"]."/inc/fnc.php";
	include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php";
	include $_SERVER["DOCUMENT_ROOT"]."/schedule/scheduleApi.php";
	
	if($_SESSION['user_superId']){
		if($_SESSION['user_auth'] > 2) {
			$user_superId = $_SESSION['user_seq'];
		}else {
			$user_superId = $_SESSION["user_superId"];
		}
	}	

	$data = array(
		"org_code" => $_SESSION["user_orgCode"],
		"superId" => $user_superId,
		"id" => $_SESSION["user_id"]
	);

	$dateTemplateList = getTimeTemplate($data);
	$dayTempList = json_encode($dateTemplateList['data']);

	$weekTemplateList = getTimeWeekTemplate($data);

	//p($weekTemplateList);
	
	include $_SERVER["DOCUMENT_ROOT"]."/schedule/scheduleAsside.php"; 
?>
<style type="text/css">
	@media (max-width : 990px){
		.card-deck {
			display : block;
		}
	}
</style>
<section class="section-container">
	<!-- Page content-->
	<div class="content-wrapper">
		<div class="content-heading">
			<div>스케쥴 설정</div>
		</div>

		<div class="card card-default">
			<div class="card-header">
				<legend class="border-bottom">
					<span id="infoId">일일 템플릿</span>
					<?if($_SESSION['user_auth'] >= 2){?>
					<a class="float-right" href="#">
						<button class="btn btn-info mb-2" type="button" id="addTemp">초기화</button>
						<button class="btn btn-info mb-2" type="button" id="addBtn">추가</button>
						<button class="btn btn-info mb-2" type="button" id="updateBtn">수정</button>
					</a>
					<?}?>
				</legend>
			</div>
			<!-- card body 시작 -->
			<div class="card-body">
				<div class="form-row mb-3">
					<div class="col-lg-6">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">템플릿 이름</span>
							</div>
							<input class="form-control d-inline-block" type="text" name="tempName" required />
							<input id="seq" type="hidden" />
						</div>
						
					</div>
				</div>
				<!-- 설정 폼-->
				<?for($j=0; $j<5; $j++){?>
					<div name="confForm">
						<label>설정 <?=$j+1?> </label><span class="text-info"> ON</span>
						<div class="form-row">
							<div class="col-lg-6 mb-3">
								<div class="input-group" >
									<div class="input-group-prepend">
										<div class="checkbox c-checkbox pt-1">
											<label>
												<input type="checkbox" name="confCheckbox" value="1" <?=($j==0)?"checked":"";?> <?=($j==0)?"disabled":"";?>>
												<span class="fa fa-check"></span>
											</label>
										</div>
										<span class="input-group-text">시작시간</span>
									</div>
									<select class="custom-select" name="hour" <?=($j==0)?"":"disabled";?>>
										<?for($i=0; $i<24; $i++){?>
											<option value="<?=$i?>"><?=sprintf('%02d',$i);?>시</option>
										<?}?>
									</select>
									<select class="custom-select" name="min" <?=($j==0)?"":"disabled";?>>
										<?for($i=0; $i<60; $i++){?>
											<option value="<?=$i?>"><?=sprintf('%02d',$i);?>분</option>
										<?}?>
									</select>
								</div>
							</div>
							<div class="col-lg-6 mb-3">
								<div class="input-group" name="confDateTemp">
									<div class="input-group-prepend" >
										<span class="input-group-text">종료시간</span>
									</div>
									<select class="custom-select" name="hour" <?=($j==0)?"":"disabled";?>>
										<?for($i=0; $i<24; $i++){?>
											<option value="<?=$i?>"><?=sprintf('%02d',$i);?>시</option>
										<?}?>
									</select>
									<select class="custom-select" name="min" <?=($j==0)?"":"disabled";?>>
										<?for($i=0; $i<60; $i++){?>
											<option value="<?=$i?>"><?=sprintf('%02d',$i);?>분</option>
										<?}?>
									</select>
								</div>
							</div>
						</div>
					</div>
				<?}?>
				<!-- 설정 폼 끝 -->
			</div>
		</div>
		<!-- card body 끝 -->
	</div>
</section>
</div>
<script type="text/javascript">
	//일일 리스트 
	var dateList = '<?=json_encode($dateTemplateList[data])?>';
	var parsedJson = $.parseJSON(dateList);
	
	//주간 리스트 
	var weekList = '<?=json_encode($weekTemplateList[data])?>';
	var weekJson = $.parseJSON(weekList);

	var nhOptions = [];
	var nmOptions = [];
	var initOptions = [];

	var hour = document.getElementsByName("hour");
	var min = document.getElementsByName("min");

	var confCheckbox = document.getElementsByName("confCheckbox");
	var onOffTemp = document.getElementsByName("OnOffTemp");

	var fnYN = 0; // 중복체크 변수

	$(function (){
		var getDayScheduleSeq = getParameter('daySchedule');

		$("[name=checkAll]").click(function(){	//체크 박스 전체 선택
			allCheckFunc( this );
		});

		$("[name=checkOne]").each(function(){	//체크 박스 하나 선택
			$(this).click(function(){
				oneCheckFunc( $(this) );
			});
		});

		$(document).on("change", "[name=hour], [name=min]", function(){	//시간, 분 변경
			nhOptions = [];	//시간 옵션값들 초기화
			nmOptions = [];	//분 옵션값들 초기화
			initOptions = [];
			
			var thisIndex;

			if($(this).attr("name") == "hour"){
				thisIndex = $("[name=hour]").index(this);
			}
			else if($(this).attr("name") == "min"){
				thisIndex = $("[name=min]").index(this);
			}
			
			var nextMin;
			var nextHour;

			var thisHour = $("[name=hour]").eq(thisIndex).val();
			var thisMin = $("[name=min]").eq(thisIndex).val();

			var thisHourSel = $("[name=hour]").eq(thisIndex);
			var thisMinSel = $("[name=min]").eq(thisIndex);

			var nextHourSel = $("[name=hour]").eq(thisIndex+1);
			var nextMinSel = $("[name=min]").eq(thisIndex+1);

			nextMin = parseInt(thisMin);

			if(nextMin == 60){
				nextHour = parseInt(thisHour) + 1;
				nextMin = 0;
			}else{
				nextHour = parseInt(thisHour);
			}
			
			/*시간 변경 시 분 옵션 값 초기화*/
			if($(this).attr("name") == "hour"){
				minuteOptionVal = 0;
			}
			/*시간 변경 시 분 옵션 값 초기화 끝*/

			for(i=nextHour; i<24; i++){
				nhOptions.push({text:pad(i)+"시", value:i});
			}

			for(i=nextMin; i<60; i++){
				nmOptions.push({text:pad(i)+"분", value:i});
			}

			if($(this).attr("name") == "hour"){		//시간 값 조정시 분 값 초기화
				for(i=0; i<60; i++){
					initOptions.push({text:pad(i)+"분", value:i});
				}

				thisMinSel.replaceOptions(initOptions);
			}

			$(nextHourSel).replaceOptions(nhOptions);
			$(nextMinSel).replaceOptions(nmOptions);

			$(nextHourSel).val(nextHour);
			$(nextMinSel).val(nextMin);
		});
		
		$(document).on("click", "[name=confCheckbox]", function(){	//체크 박스 설정 클릭 시
			nhOptions = [];
			nmOptions = [];

			var thisIndex = $("[name=confCheckbox]").index(this);	//현재 선택 한 체크 박스 위치 값
			
			var preIndex = thisIndex * 2 - 1;	//현재 선택한 체크 박스 이전 *종료 시간 위치 값
			
			var preHour = $("[name=hour]").eq(preIndex);
			var preMin = $("[name=min]").eq(preIndex);

			var sHour = $("[name=hour]").eq(preIndex + 1);
			var sMin = $("[name=min]").eq(preIndex + 1);

			var eHour = $("[name=hour]").eq(preIndex + 2);
			var eMin = $("[name=min]").eq(preIndex + 2);
			
			/**/
			if(!$("[name=confCheckbox]").eq(thisIndex-1).is(":checked")){
				alert("이전 설정이 안되어있습니다.");
				$(this).prop("checked", false);
				return;
			}
			/**/
			/* ========== 선택한 체크 박스 OFF 시 아래 체크 박스 OFF ========== */
			if(!$("[name=confCheckbox]").eq(thisIndex).is(":checked")){
				for(i=thisIndex; i<5; i++) {
					$("[name=confCheckbox]").eq(i).prop("checked", false);

					/* ========== 밑에 체크 해제 된 부분도 disabled ========== */
					j = i * 2;
					$("[name=hour]").eq(j).prop("disabled", true);
					$("[name=hour]").eq(j+1).prop("disabled", true);
					$("[name=min]").eq(j).prop("disabled", true);
					$("[name=min]").eq(j+1).prop("disabled", true);
					/* ========== 밑에 체크 해제 된 부분도 disabled ========== */
				}
			}
			/* ========== 선택한 체크 박스 OFF 시 아래 체크 박스 OFF ========== */

			/* 이전 값 0:0 시 설정 불가*/
			if(thisIndex != 0){
				if(preHour.val() == 0 && preMin.val() == 0){
					alert("이전 설정 종료시간이 미설정 입니다.");
					sHour.prop("disabled", true);
					sMin.prop("disabled", true);
					eHour.prop("disabled", true);
					eMin.prop("disabled", true);
					$(this).prop("checked", false);
				}else{
					/* 체크 시 disabled 변화 */
					if($(this).is(":checked")){
						sHour.prop("disabled", false);
						sMin.prop("disabled", false);
						eHour.prop("disabled", false);
						eMin.prop("disabled", false);
					}else{
						sHour.prop("disabled", true);
						sMin.prop("disabled", true);
						eHour.prop("disabled", true);
						eMin.prop("disabled", true);
					}
					/* 체크 시 disabled 변화 끝*/
				}
			}else{
				/* 체크 시 disabled 변화 */
				if($(this).is(":checked")){
					sHour.prop("disabled", false);
					sMin.prop("disabled", false);
					eHour.prop("disabled", false);
					eMin.prop("disabled", false);
				}else{
					sHour.prop("disabled", true);
					sMin.prop("disabled", true);
					eHour.prop("disabled", true);
					eMin.prop("disabled", true);
				}
			}
			/* 이전 값 0:0 시 설정 불가 끝*/

			/* =============체크 시 값 변화 =================*/
			if((sHour.val() == 0 && sHour.val() == '0') && (sMin.val() == 0 && sMin.val() == '0')){		//값이 없을 경우 이전 값 가져오기
				sHourVal = parseInt(preHour.val());
				sMinVal = parseInt(preMin.val());
				
				if(preMin.val() == 59){
					sHourVal += 1;
					sMinVal = 0;
				}
			}else {
				sHourVal = parseInt(sHour.val());
				sMinVal = parseInt(sMin.val());
			}

			for(i=sHourVal; i<24; i++){
				nhOptions.push({text:pad(i)+"시", value:i});
			}

			for(i=sMinVal; i<60; i++){
				nmOptions.push({text:pad(i)+"분", value:i});
			}
			
			if(thisIndex != 0){
				sHour.val(sHourVal);
				sMin.val(sMinVal);
				$(sHour).replaceOptions(nhOptions);
				$(sMin).replaceOptions(nmOptions);
			}else{
				sHour.val(0);
				sMin.val(0);
			}

			//종료시간 값 변화
			if((eHour.val() == 0 && eHour.val() == '0') && (eMin.val() == 0 && eMin.val() == '0')){
				eHourVal = parseInt(sHourVal);
				eMinVal = sMinVal;

				if(sMinVal == 59){
					eHourVal += 1;
					eMinVal = 0;
				}
			}else{
				eHourVal = parseInt(eHour.val());
				eMinVal = eMin.val();
			}
			
			nhOptions = [];
			nmOptions = [];

			for(i=eHourVal; i<24; i++){
				nhOptions.push({text:pad(i)+"시", value:i});
			}

			for(i=eMinVal; i<60; i++){
				nmOptions.push({text:pad(i)+"분", value:i});
			}
			
			if(thisIndex != 0){
				eHour.val(eHourVal);
				eMin.val(eMinVal);
				$(eHour).replaceOptions(nhOptions);
				$(eMin).replaceOptions(nmOptions);
			}else {
				eHour.val(0);
				eMin.val(0);
			}
			/* =============체크 시 값 변화 끝=================*/
		});

		$(document).on("click", ".getTimeTemplate", function(element){	//일일 템플릿 정보 보기
			$(".getTimeTemplate").each(function(){
				$(this).children('span').removeClass("clickedList");
			});

			var tempSeq;
			if(!getDayScheduleSeq || getDayScheduleSeq.indexOf('#') != -1){
				tempSeq = $(this).data('tempseq');
			}else{
				tempSeq = getDayScheduleSeq;
			}
			
			/* ========== 화면에 데이터 뿌리기 ========== */
			for(var i=0; i < parsedJson.length; i++){
				if(parsedJson[i]['seq'] == tempSeq){
					$('[name=dayTemplateList]').children('.getTimeTemplate').each(function (){
						if($(this).data('tempseq') == tempSeq){
							$(this).children('span').addClass('clickedList');
						}
					});
					initReplaceOption(parsedJson[i]);	//옵션값 초기화

					document.getElementsByName("tempName")[0].value = parsedJson[i]['tempName'];
					document.getElementById("seq").value = tempSeq;

					hour[0].value = parsedJson[i]['v1stSH'];
					min[0].value = parsedJson[i]['v1stSM'];
					hour[1].value = parsedJson[i]['v1stEH'];
					min[1].value = parsedJson[i]['v1stEM'];

					hour[2].value = parsedJson[i]['v2ndSH'];
					min[2].value = parsedJson[i]['v2ndSM'];
					hour[3].value = parsedJson[i]['v2ndEH'];
					min[3].value = parsedJson[i]['v2ndEM'];

					hour[4].value = parsedJson[i]['v3rdSH'];
					min[4].value = parsedJson[i]['v3rdSM'];
					hour[5].value = parsedJson[i]['v3rdEH'];
					min[5].value = parsedJson[i]['v3rdEM'];

					hour[6].value = parsedJson[i]['v4thSH'];
					min[6].value = parsedJson[i]['v4thSM'];
					hour[7].value = parsedJson[i]['v4thEH'];
					min[7].value = parsedJson[i]['v4thEM'];

					hour[8].value = parsedJson[i]['v5thSH'];
					min[8].value = parsedJson[i]['v5thSM'];
					hour[9].value = parsedJson[i]['v5thEH'];
					min[9].value = parsedJson[i]['v5thEM'];

					if(parsedJson[i]['v2ndSH'] == "0" && parsedJson[i]['v2ndSM'] == "0"){
						confCheckbox[1].checked = false;
					}else{
						confCheckbox[1].checked = true;
					}
					
					if(parsedJson[i]['v3rdSH'] == "0" && parsedJson[i]['v3rdSM'] == "0"){
						confCheckbox[2].checked = false;
					}else{
						confCheckbox[2].checked = true;
					}

					if(parsedJson[i]['v4thSH'] == "0" && parsedJson[i]['v4thSM'] == "0") {
						confCheckbox[3].checked = false;
					}else{
						confCheckbox[3].checked = true;
					}

					if(parsedJson[i]['v5thSH'] == "0" && parsedJson[i]['v5thSM'] == "0"){
						confCheckbox[4].checked = false;
					}else{
						confCheckbox[4].checked = true;
					}

					/* 체크 값에 따라 disalbed*/
					for(var k=0; k<5; k++){
						var j = k*2;
						if(confCheckbox[k].checked){
							hour[j].disabled = false;
							hour[j+1].disabled = false;
							min[j].disabled = false;
							min[j+1].disabled = false;
						}else{
							hour[j].disabled = true;
							hour[j+1].disabled = true;
							min[j].disabled = true;
							min[j+1].disabled = true;
						}
					}
					/* 체크 값에 따라 disalbed 끝*/
				}
			}
			getDayScheduleSeq += '#';
			/* ========== 화면에 데이터 뿌리기 끝========== */
		}).find(".getTimeTemplate").eq(0).trigger('click');
		
		$(document).on("click", "#updateBtn", function(){	//일일 템플릿 수정
			var hour = [];
			var min = [];
			var confCheckbox = [];
			var hourJson;
			var minJson;
			var confCheckboxJson;
			var seq = $("#seq").val();
			var tempName = $("[name=tempName]").val();

			$.each($("[name=hour]"), function(){
				hour.push($(this).val());
			});

			$.each($("[name=min]"), function(){
				min.push($(this).val());
			});

			$.each($("[name=confCheckbox]"), function(){
				if($(this).is(":checked")){
					confCheckbox.push($(this).val());
				}else{
					confCheckbox.push("2");
				}
			});

			confCheckboxJson = JSON.stringify(confCheckbox);
			hourJson = JSON.stringify(hour);
			minJson = JSON.stringify(min);

			if(parsedJson != null) fnYN = overlapName(parsedJson, tempName, seq);	//이름 중복체크
			if(fnYN == 1){
				var jbResult = confirm( '중복 된 이름이 있습니다. 진행하시겠습니까?' );
				if(!jbResult) return;
			}
			
			$("[name=tempName]").parsley().validate();
			
			//템플릿 이름 유효성 체크
			if($("[name=tempName]").parsley().isValid()){
				$.ajax({
					url : '/schedule/scheduleProc.php',
					type : 'post',
					data : {
						'mode' : "updateTemplate",
						'tempName' : tempName,
						'hour' : hourJson,
						'min' : minJson,
						'confType' : 1,
						'seq' : seq,
						'confCheckbox' : confCheckboxJson
					},
					success : function(data){
						if(data == 0){
							alert("수정 되었습니다.");
							window.location.href= "/schedule/scheduleView.php?daySchedule="+seq;
						}
					},
					beforeSend : function(){
						$(".wrapper").addClass("whirl traditional");
					},
					complete : function(){
						$(".wrapper").removeClass("whirl traditional");
					}
				});
			}
		});
		
		$(document).on("click", "#addBtn", function(){	//일일 템플릿 추가
			var hour = [];
			var min = [];
			var confCheckbox = [];
			var hourJson;			//시 값
			var minJson;			//분 값
			var confCheckboxJson;	//체크 박스 설정 값
			var confTypeJson = "1";	//항상 ON값, ON,OFF 값
			var tempName = $("[name=tempName]").val(); //일일 템플릿 이름

			$.each($("[name=hour]"), function(){
				hour.push($(this).val());
			});

			$.each($("[name=min]"), function(){
				min.push($(this).val());
			});

			$.each($("[name=confCheckbox]"), function(){
				if($(this).is(":checked")){
					confCheckbox.push($(this).val());
				}else{
					confCheckbox.push("2");
				}
			});
			
			confCheckboxJson = JSON.stringify(confCheckbox);
			hourJson = JSON.stringify(hour);
			minJson = JSON.stringify(min);
			
			if(parsedJson != null) fnYN = overlapName(parsedJson, tempName, 0);	//이름 중복체크
			if(fnYN == 1){
				var jbResult = confirm( '중복 된 이름이 있습니다. 진행하시겠습니까?' );
				if(!jbResult) return;
			}

			$("[name=tempName]").parsley().validate();	//템플릿 이름이 비였는지 체크
			if($("[name=tempName]").parsley().isValid() ){
				$.ajax({
					url : '/schedule/scheduleProc.php',
					type : 'post',
					data : {
						'mode' : "saveTemplate",
						'tempName' : tempName,
						'hour' : hourJson,
						'min' : minJson,
						'confType' : confTypeJson,
						'confCheckbox' : confCheckboxJson
					},
					success : function(data){
						if(data == 0){
							alert("추가 되었습니다.");
							window.location.reload();
						}
					},
					beforeSend : function(){
						$(".wrapper").addClass("whirl traditional");
					},
					complete : function(){
						$(".wrapper").removeClass("whirl traditional");
					}
				});
			}

		});
		
		$(document).on("click", "#delBtn", function(){	//일일템플릿 삭제
			var checkedIdxArr = [];	//체크된 메일 리스트 값 
			var checkedIdx = "";

			$("input[name=checkOne]:checked").each(function(){
				checkedIdxArr.push($(this).val());
			});
			
			checkedIdx = checkedIdxArr.join(",");
			
			$.ajax({
				url : "/schedule/scheduleProc.php",
				type : 'post',
				data : {
					'mode' : 'delTemplate',
					'seqs' : checkedIdx
				},
				success : function(data){
					if(data == 0){
						alert("일일 스케줄이 삭제 되었습니다.");
						window.location.reload();
					}else{
						alert("사용 중인 템플릿이 있어 삭제 되지 않았습니다.");
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
		
		$(document).on("click", "#addTemp", function(){	//초기화
			$(".section-container").load("/schedule/scheduleView.php .content-wrapper", function(){
				/* 초기 값*/
				$("[name=confCheckbox]").eq(0).prop("checked", true);

				$("[name=hour]").eq(0).prop("disabled", false);
				$("[name=min]").eq(0).prop("disabled", false);
				$("[name=hour]").eq(1).prop("disabled", false);
				$("[name=min]").eq(1).prop("disabled", false);
			});

			//$("#dashboard").load("/schedule/scheduleAsside.php #dayTemplateList", {postData : dateList} );
		});
	});//document.ready 끝

	function initReplaceOption(arrVal){
		var replaceHourArr = [];
		var replaceMinArr = [];
		var tempVal;
		
		var parsedThisVal;
		$.each($("[name=hour]"), function(index){
			switch (index)
			{
				case 0 : tempVal = arrVal['v1stSH']; break;
				case 1 : tempVal = arrVal['v1stEH']; break;
				case 2 : tempVal = arrVal['v2ndSH']; break;
				case 3 : tempVal = arrVal['v2ndEH']; break;
				case 4 : tempVal = arrVal['v3rdSH']; break;
				case 5 : tempVal = arrVal['v3rdEH']; break;
				case 6 : tempVal = arrVal['v4thSH']; break;
				case 7 : tempVal = arrVal['v4thEH']; break;
				case 8 : tempVal = arrVal['v5thSH']; break;
				case 9 : tempVal = arrVal['v5thEH']; break;
			}
			
			parsedThisVal = tempVal;

			for(var i=parsedThisVal; i<24; i++){
				replaceHourArr.push({text : pad(i)+"시", value : i});
			}

			$(this).replaceOptions(replaceHourArr);
			replaceHourArr = [];
		});
		
		
		$.each($("[name=min]"), function(index){
			switch (index)
			{
				case 0 : tempVal = arrVal['v1stSM']; break;
				case 1 : tempVal = arrVal['v1stEM']; break;
				case 2 : tempVal = arrVal['v2ndSM']; break;
				case 3 : tempVal = arrVal['v2ndEM']; break;
				case 4 : tempVal = arrVal['v3rdSM']; break;
				case 5 : tempVal = arrVal['v3rdEM']; break;
				case 6 : tempVal = arrVal['v4thSM']; break;
				case 7 : tempVal = arrVal['v4thEM']; break;
				case 8 : tempVal = arrVal['v5thSM']; break;
				case 9 : tempVal = arrVal['v5thEM']; break;
			}

			parsedThisVal = tempVal;

			for(var i=parsedThisVal; i<60; i++){
				replaceMinArr.push({text : pad(i)+"분", value : i});
			}
			$(this).replaceOptions(replaceMinArr);
			replaceMinArr = [];
		});
	}

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

	function overlapName(arr, name, seq){
		var fnExit;

		for (var i=0; i<arr.length; i++)
		{
			if (arr[i]['tempName'] == name && arr[i]['seq'] != seq) {
				fnExit = 1;
			}
		}
		return fnExit;
	}
</script>


<?
	include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>