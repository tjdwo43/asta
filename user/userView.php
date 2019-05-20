<?
	include $_SERVER[DOCUMENT_ROOT]."/inc/fnc.php";
	include $_SERVER[DOCUMENT_ROOT]."/inc/header.php";
	include $_SERVER[DOCUMENT_ROOT]."/user/user.php";

	//좌측 유저 리스트
	$postData = Array(
		'org_code' => $_SESSION['user_orgCode'],
		'auth'	=>	$_SESSION['user_auth'],
		'superId' => ($_SESSION['user_auth'] == 4)?"":$_SESSION['user_seq']
	);
	
	$userList = getListUser($postData);

	//p($userList);
?>
<?include $_SERVER[DOCUMENT_ROOT]."/user/userAsside.php";?>

<section class="section-container">
	<!-- Page content-->
	<div class="content-wrapper">
		<div class="content-heading">
			<div>사용자 정보</div>
		</div>
		
		<?if(count($userList['data']) > 0){?>
			<div class="card card-default">
				<div class="card-header">
					<legend class="border-bottom"><span id="infoId">아이디</span>
						<a class="float-right" href="#">
							<button class="btn btn-info mb-2" type="button" id="updateBtn">
								사용자 수정
							</button>
						</a>
					</legend>
				</div>
				<div class="card-body">
					<form class="form-horiziontal" action="">
						<fieldset>
							<div class="form-group row">
								<div class="col-md-12">
									<div class="row">
										<input type="hidden" id="infoSeq"/>

										<div class="col-md-6 mb-3">
											<input class="form-control" id="infoName" type="text" placeholder="이름" disabled >
										</div>

										<div class="col-md-6 mb-3">
											<input class="form-control col-6 d-inline-block" id="infoOrg" type="text" placeholder="코드" disabled>
											<input class="form-control col-6 d-inline-block" style="max-width:49%;" id="infoDepart" type="text" placeholder="소속" disabled>
										</div>

										<div class="col-md-6 mb-3">
											<input class="form-control" id="infoPhoneNum" type="text" placeholder="연락처" pattern="/^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/" data-parsley-pattern="/^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/" >
										</div>

										<div class="col-md-6 mb-3">
											<input class="form-control" id="infoEmail" type="email" placeholder="이메일">
										</div>
										
										<div class="col-md-6 mb-3" id="infoAuthDiv">
											<select class="custom-select custom-select-sm" id="infoAuth" <?=($_SESSION['user_auth'] >= 3)?'':"disabled"?>>
												<?if($_SESSION['user_auth'] == 4){?>
													<option value="4">슈퍼 관리자</option>
												<?}?>
												<?if($_SESSION['user_auth'] >= 3){?>
												<option value="3">관리자</option>
												<?}?>
												<option value="2">사용자 A</option>
												<option value="1">사용자 B</option>
											</select>
										</div>
										<div class="col-md-6 mb-3">
											<input class="form-control" id="infoComment" type="text" placeholder="코멘트">
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		<?}else{?>
			<div class="card card-default">
				<div class="card-header"><h4>등록 된 유저가 없습니다. 유저를 등록하여 주세요</h4></div>
			</div>
		<?}?>
	</div>
</section>

</div><!-- wrapper End -->

<!-- 등록 모달 -->
<div class="modal fade" id="regUserModal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">사용자 등록</h4>
				<button type="button" class="close" data-dismiss="modal">×</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<div class="card card-flat">
					<div class="card-body">
						<form class="mb-3" id="registerForm" >
							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control border-right-0" id="signupInputId" placeholder="*아이디" autocomplete="off" required="" >
									<div class="input-group-append">
										<span class="input-group-text text-muted bg-transparent">
											<em class="fa fa-id-card"></em>
										</span>
									</div>
								</div>
								<div class="text-help filled d-none" id="parsley-id-5">
									<div class="parsley-type">중복 된 아이디입니다.</div>
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control border-right-0" id="signupInputPassword1" data-parsley-minlength="8" type="password" placeholder="*비밀번호" autocomplete="off" required="">
									<div class="input-group-append">
										<span class="input-group-text text-muted bg-transparent">
											<em class="fa fa-lock"></em>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control border-right-0" id="signupInputPassword2" data-parsley-equalto="#signupInputPassword1" type="password" placeholder="*비밀번호 확인" autocomplete="off" required="">
									<div class="input-group-append">
										<span class="input-group-text text-muted bg-transparent">
											<em class="fa fa-lock"></em>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control border-right-0" id="signupInputName" type="text" placeholder="*이름" autocomplete="off" required="">
									<div class="input-group-append">
										<span class="input-group-text text-muted bg-transparent ">
											<em class="fa fa-user"></em>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control border-right-0" id="signupInputEmail" type="email" placeholder="이메일" autocomplete="off">
									<div class="input-group-append">
										<span class="input-group-text text-muted bg-transparent ">
											<em class="fa fa-envelope"></em>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control" id="signupInputPhone" pattern="/^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/" data-parsley-pattern="/^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/" placeholder="연락처">
								</div>
							</div>
							
							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control" id="signupInputDepart" value="<?=$_SESSION[user_depart]?>" placeholder="그룹 명" <?=($_SESSION['user_auth'] == 4)?'':"disabled"?> required>
									<input class="form-control" id="signupInputOrgCode" value="<?=$_SESSION[user_orgCode]?>" placeholder="코드" <?=($_SESSION['user_auth'] == 4)?'':"disabled"?> required>
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<select class="custom-select custom-select-sm" id="signupInputAuth">
										<?if($_SESSION['user_auth'] == '4'){?>
											<option value="3">관리자</option>
										<?}?>
										<option value="2">사용자 A</option>
										<option value="1">사용자 B</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<div class="input-group with-focus">
									<input class="form-control" id="signupInputComment" placeholder="Comment">
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

<script type="text/javascript">
	//유저 리스트 
	var userList = '<?=json_encode($userList[data])?>';
	var parsedJson = $.parseJSON(userList);

	var getSeq = getParameter('seq');

	$(document).ready(function () {
		$("[name=checkAll]").click(function(){	//체크 박스 전체 선택
			allCheckFunc( this );
		});

		$("[name=checkOne]").each(function(){	//체크 박스 하나 선택
			$(this).click(function(){
				oneCheckFunc( $(this) );
			});
		});
		
		$(document).on("click", ".getUserInfo", function(){	//눌렀을 때 계정 정보 보기
			var userSeq;
			//전에 유효성 체크 초기화
			$('#infoPhoneNum').parsley().reset();
			$('#infoEmail').parsley().reset();
			
			$('[name=userInfo]').children('.getUserInfo').each(function(){
				$(this).find('span').removeClass("clickedList");
			});

			if(!getSeq || getSeq.indexOf('#') != -1){
				userSeq = $(this).data('userseq');
			}else{
				userSeq = getSeq
			}
				
			for(var i=0; i < parsedJson.length; i++){
				if(parsedJson[i]['seq'] == userSeq){
					$('#infoSeq').val(userSeq);
					$('#infoId').html(parsedJson[i]['id']);
					$('#infoName').val(parsedJson[i]['name']);
					$('#infoPhoneNum').val(parsedJson[i]['phone']);
					$('#infoEmail').val(parsedJson[i]['email']);
					$('#infoComment').val(parsedJson[i]['comment']);
					$('#infoOrg').val(parsedJson[i]['org_code']);
					$('#infoDepart').val(parsedJson[i]['org_name']);

					$('#infoAuth').val(parsedJson[i]['auth']);

					$('[name=userInfo]').children('.getUserInfo').each(function (){
						if($(this).data('userseq') == userSeq){
							$(this).children('span').addClass('clickedList');
						}
					});
				}
			}

			getSeq = getSeq+"#";
		}).find('.getUserInfo').eq(0).trigger('click');

		$("#addUser").click(function(){	//모달 창 띄움
			$("#signupInputId").val("");
			$("#signupInputPassword1").val("");
			$("#signupInputPassword2").val("");
			$("#signupInputName").val("");
			$("#signupInputPhone").val("");
			$("#signupInputEmail").val("");
			$("#signupInputComment").val("");

			$('#signupInputId').parsley().reset();
			$('#signupInputPassword1').parsley().reset();
			$('#signupInputPassword2').parsley().reset();
			$('#signupInputName').parsley().reset();
			$("#signupInputEmail").parsley().reset();
			$("#signupInputPhone").parsley().reset();

			$("#regUserModal").modal();
		});
		
		$("#saveBtn").click(function(){	//regForm 저장
			var returnData;

			var id = $("#signupInputId").val();
			var passwd = $("#signupInputPassword1").val();
			var name = $("#signupInputName").val();
			var phone = $("#signupInputPhone").val();
			var email = $("#signupInputEmail").val();
			var auth = $("#signupInputAuth").val();
			var comment = $("#signupInputComment").val();
			var superId = '<?=$_SESSION[user_seq]?>';
			var org_code = $('#signupInputOrgCode').val();
			var depart = $('#signupInputDepart').val();

			//유효성
			$('#signupInputId').parsley().validate();
			$('#signupInputPassword1').parsley().validate();
			$('#signupInputPassword2').parsley().validate();
			$('#signupInputName').parsley().validate();
			$("#signupInputEmail").parsley().validate();
			$("#signupInputPhone").parsley().validate();
			$('#signupInputOrgCode').parsley().validate();
			$('#signupInputDepart').parsley().validate();
			
			if($('#signupInputId').parsley().isValid() && $('#signupInputPassword1').parsley().isValid() && $('#signupInputName').parsley().isValid() && $("#signupInputEmail").parsley().isValid() && $('#signupInputPassword2').parsley().isValid() && $('#signupInputOrgCode').parsley().isValid() && $('#signupInputDepart').parsley().isValid() && $("#signupInputPhone").parsley().isValid()){
				$.ajax({
					url : '/user/userAjaxProc.php',
					type : 'post',
					data : {
						'mode' : 'registerUser',
						'id' : id,
						'passwd' : passwd,
						'name' : name,
						'org_code' : org_code,
						'phone' : phone,
						'email' : email,
						'auth' : auth,
						'comment' : comment,
						'superId' : superId,
						'depart' : depart
					},
					success : function(data){
						var lists = $.parseJSON(data);

						if(lists.resultVal == 0){ //유저 등록 성공
							/*
							$("#regUserModal").modal('hide');
							
							$('#dashboard').append(returnData['html']);
							//배열 추가
							arrLength = parsedJson.length;
							
							parsedJson.push(returnData['data']);
							
							$('#countUser').text(parsedJson.length);*/

							window.location.href='/user/userView.php?seq='+lists.seq;
						}else {
							$("#parsley-id-5").removeClass("d-none");
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

		$("#delBtn").click(function(){
			var checkedIdxArr = [];	//체크된 메일 리스트 값 
			var checkedIdx = "";
			var phoneNum;

			$("input[name=checkOne]:checked").each(function(){
				checkedIdxArr.push($(this).val());
			});
			
			checkedIdx = checkedIdxArr.join(",");

			phoneNum = $("#infoPhoneNum").val();
			
			$.ajax({
				url : "/user/userAjaxProc.php",
				type : 'post',
				data : {
					'mode' : 'delUser',
					'seqs' : checkedIdx,
					'phoneNum' : phoneNum
				},
				success : function(){
					$("input[name=checkOne]:checked").each(function(){
						$(this).closest('li').remove();
					});

					$("#countUser").text($("[name=userInfo]").length);

					alert("삭제 되었습니다.");
				},
				beforeSend : function(){
					$(".wrapper").addClass("whirl traditional");
				},
				complete : function(){
					$(".wrapper").removeClass("whirl traditional");
				}
			});
		});

		$("#updateBtn").click(function(){
			var seq = $("#infoSeq").val();
			var name = $("#infoName").val();
			var phone = $("#infoPhoneNum").val();
			var email = $("#infoEmail").val();
			var auth = $("#infoAuth").val();
			var comment = $("#infoComment").val();
			var id = $("#infoId").text();

			$('#infoPhoneNum').parsley().validate();
			$('#infoEmail').parsley().validate();

			if($('#infoPhoneNum').parsley().isValid() && $('#infoEmail').parsley().isValid()){
				$.ajax({
					url : "/user/userAjaxProc.php",
					type : 'post',
					data : {
						'mode' : 'updateUserTest',
						'seq' : seq,
						'name' : name,
						'phone' : phone,
						'email' : email,
						'auth' : auth,
						'comment' : comment,
						'id' : id
					},
					success : function(data){
						console.log(data);
						if(data == '0'){
							alert("수정되었습니다.");
							window.location.href = "/user/userView.php?seq="+seq;
						}else {
							alert("서버오류");
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
	});
</script>
<?include $_SERVER[DOCUMENT_ROOT]."/inc/footer.php";?>