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
		"id" => $_SESSION["user_seq"]
	);

	$dateTemplateList = getTimeTemplate($data);

	$weekTemplateList = getTimeWeekTemplate($data);

	$weekName = Array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
	
	include $_SERVER["DOCUMENT_ROOT"]."/schedule/scheduleWAsside.php"; 
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
			<div>예약 설정</div>
		</div>

		<div class="card card-default">
			<div class="card-header">
				<legend class="border-bottom">
					<span id="infoId">주간 템플릿</span>
					<?if($_SESSION['user_auth'] >= 2){?>
					<a class="float-right" href="#">
						<button class="btn btn-info mb-2" type="button" id="weekBtn">초기화</button>
						<button class="btn btn-info mb-2" type="button" id="addWBtn">추가</button>
						<button class="btn btn-info mb-2" type="button" id="updateWBtn">수정</button>
					</a>
					<?}?>
				</legend>
			</div>
			<!-- card body 시작 -->
			<div class="card-body">
				<div class="form-row">
					<div class="col-lg-12 ">
						<div class="input-group mb-3 col-lg-6">
							<div class="input-group-prepend">
								<span class="input-group-text">템플릿 이름</span>
							</div>
							<input class="form-control d-inline-block" type="text" name="tempWName"/ required>
							<input id="wSeq" type="hidden" />
						</div>
						<div class=" col-lg-12">
							<div class="card-deck">
								<?for($i=0; $i<4; $i++){?>
									<div class="card card-default mb-4">
										<div class="card-header"><?=$weekName[$i]?></div>
										<div class="card-body">
											<select name="dayTemp" class="custom-select" required>
												<?foreach($dateTemplateList['data'] as $dayVal){?>
													<option value="<?=$dayVal['seq']?>"><?=$dayVal['tempName']?></option>
												<?}?>
											</select>
										</div>
									</div>
								<?}?>
							</div>
						</div>
						<div class=" col-lg-9">
							<div class="card-deck">
								<?for($i=4; $i<7; $i++){?>
									<div class="card card-default mb-4">
										<div class="card-header"><?=$weekName[$i]?></div>
										<div class="card-body">
											<select name="dayTemp" class="custom-select" required>
												<?foreach($dateTemplateList['data'] as $dayVal){?>
													<option value="<?=$dayVal['seq']?>"><?=$dayVal['tempName']?></option>
												<?}?>
											</select>
										</div>
									</div>
								<?}?>
							</div>
						</div>
					</div>
				</div>
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

	var getWeekScheduleSeq = getParameter('weekSchedule');

	var fnYN = 0; // 중복체크 변수

	$(function (){
		$("[name=checkAll]").click(function(){	//체크 박스 전체 선택
			allCheckFunc( this );
		});

		$("[name=checkOne]").each(function(){	//체크 박스 하나 선택
			$(this).click(function(){
				oneCheckFunc( $(this) );
			});
		});

		$(document).on("click", "#weekBtn", function(){	//주말 템플릿 폼 불러오기
			$(".section-container").load("/schedule/scheduleWView.php .content-wrapper");
			//$("#dashboard").load("/schedule/scheduleWAsside.php", {postData : weekList});
			
			//window.location.href="/schedule/scheduleWView.php";
		});

		$(document).on("click", "#addWBtn", function(){	//주말 템플릿 저장
			var dayTemp = [];
			var dayJson = "";

			var tempWName = $("[name=tempWName]").val();

			$.each($("[name=dayTemp]"), function(){
				dayTemp.push($(this).val());
			});

			dayJson = JSON.stringify(dayTemp);
			
			if(weekJson != null) fnYN = overlapName(weekJson, tempWName, 0);	//이름 중복체크
			if(fnYN == 1){
				var jbResult = confirm( '중복 된 이름이 있습니다. 진행하시겠습니까?' );
				if(!jbResult) return;
			}

			$("[name=tempWName]").parsley().validate();
			for(var i=0; i<$("[name=dayTemp]").length; i++){
				if($('[name=dayTemp]').eq(i).val() != null) {continue};
				alert('일일 템플릿을 설정 해주세요');
				break;
			}

			if($("[name=tempWName]").parsley().isValid()){
				$.ajax({
					url : '/schedule/scheduleProc.php',
					type : 'post',
					data : {
						'mode' : "saveWTemplate",
						'dayTemp' : dayJson,
						'tempWName' : tempWName
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

		$(document).on("click", ".getWeekTimeTemplate", function(){	//주말 템플릿 보기
			$(".getWeekTimeTemplate").each(function(){
				$(this).children('span').removeClass("clickedList");
			});

			var tempSeq;
			if(!getWeekScheduleSeq || getWeekScheduleSeq.indexOf('#') != -1){
				tempSeq = $(this).data('tempwseq');
			}else{
				tempSeq = getWeekScheduleSeq;
			}

			for(var i=0; i < weekJson.length; i++){
				if(weekJson[i]['seq'] == tempSeq){
					$('[name=weekTemplateList]').children('.getWeekTimeTemplate').each(function (){
						if($(this).data('tempwseq') == tempSeq){
						
							$(this).children('span').addClass('clickedList');
						}
					});

					$('#wSeq').val(tempSeq);
					$('[name=tempWName]').val(weekJson[i]['wTempName']);
					$("[name=dayTemp]").eq(0).val(weekJson[i]['monTemp']);
					$("[name=dayTemp]").eq(1).val(weekJson[i]['tueTemp']);
					$("[name=dayTemp]").eq(2).val(weekJson[i]['wedTemp']);
					$("[name=dayTemp]").eq(3).val(weekJson[i]['thuTemp']);
					$("[name=dayTemp]").eq(4).val(weekJson[i]['friTemp']);
					$("[name=dayTemp]").eq(5).val(weekJson[i]['satTemp']);
					$("[name=dayTemp]").eq(6).val(weekJson[i]['sunTemp']);
				}
			}
			getWeekScheduleSeq += '#';
		}).find(".getWeekTimeTemplate").eq(0).trigger('click');;

		$(document).on("click", "#updateWBtn", function(){	// 주말 템플릿 수정
			var dayTemp = [];
			var dayJson = "";

			var tempWName = $("[name=tempWName]").val();
			var tempWSeq = $("#wSeq").val();

			$.each($("[name=dayTemp]"), function(){
				dayTemp.push($(this).val());
			});

			dayJson = JSON.stringify(dayTemp);
			
			if(weekJson != null) fnYN = overlapName(weekJson, tempWName, tempWSeq);	//이름 중복체크
			if(fnYN == 1){
				var jbResult = confirm( '중복 된 이름이 있습니다. 진행하시겠습니까?' );
				if(!jbResult) return;
			}

			$.ajax({
				url : '/schedule/scheduleProc.php',
				type : 'post',
				data : {
					'mode' : "updateWTemplate",
					'dayTemp' : dayJson,
					'tempWName' : tempWName,
					'seq' : tempWSeq
				},
				success : function(data){
					if(data == 0){
						alert("수정 되었습니다.");
						window.location.href="/schedule/scheduleWView.php?weekSchedule="+tempWSeq;
					}
				},
				beforeSend : function(){
					$(".wrapper").addClass("whirl traditional");
				},
				complete : function(){
					$(".wrapper").removeClass("whirl traditional");
				}
			});
		})

		$(document).on("click", "#delWBtn", function(){	//주간템플릿 삭제
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
					'mode' : 'deleteWTemplate',
					'seqs' : checkedIdx
				},
				success : function(){
					alert("삭제 되었습니다.");
					window.location.reload();
				},
				beforeSend : function(){
					$(".wrapper").addClass("whirl traditional");
				},
				complete : function(){
					$(".wrapper").removeClass("whirl traditional");
				}

			});
		});
	});//document.ready 끝

	function overlapName(arr, name, seq){
		var fnExit;
		for (var i=0; i<arr.length; i++)
		{
			if (arr[i]['wTempName'] == name && arr[i]['seq'] != seq) {
				fnExit = 1;
			}
		}
		return fnExit;
	}
</script>

<?
	include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>