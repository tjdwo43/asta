	   <div class="row">
			<div class="col-xs-12">
				<h3 class="page-header"><img src="/images/bar.png" >  업무관리 작성</h3>
			</div>
			<form name="orderwriteform" method="post" action="/order/order_write.php"  enctype="multipart/form-data">
			<input type='hidden' name="ids" id="ids">
				<div class="col-lg-5" >
						<div class="modal-body">
							<div class="form-group"><label>제목</label> <input type="text" placeholder="제목" class="form-control2" name="title"  ></div>
							<div class="form-group"><button class="btn btn-info" type="button"   onClick="Show_Share()">권한설정</button> <input type="text" name="tname"   id="tname" style="width:590px"></div>
							<div class="form-group"><label>내용</label>  <textarea  name="content"  class="form-control2"  placeholder="내 용" rows='10'></textarea></div>
							<div class="form-group"><label>완료요구일</label> <input   name="request_date" type='text' id='sdate'  style='width: 100px;' value='<?=$today?>'></div>
							<div class="form-group"><label>첨부자료</label> <input type="file" name="userfile1"   maxlength="8" size="8" ></div>
							<div style="float:left;"><button class="btn btn-info" type="button"   onClick="OrderSave()">저장하기</button></div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10"></div>
				</div>
			</form>
		</div>
