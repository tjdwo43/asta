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
						<div id="countUser" class="float-right badge badge-success"><?=count($userList[data]);?></div> 
						<div class="checkbox c-checkbox d-inline-block">
							<label>
								<input type="checkbox" name="checkAll">
								<span class="fa fa-check"></span>
							</label>
						</div> 
						<span>사용자 목록</span>
					</a>
					<ul class="sidebar-nav sidebar-subnav collapse show" id="dashboard">
					<?foreach($userList[data] as $userVal){?>
						<li name="userInfo">
							<a href="#" class="getUserInfo" data-userSeq="<?=$userVal[seq]?>"> 
								<div class="checkbox c-checkbox d-inline-block">
									<label>
										<input type="checkbox" name="checkOne" value="<?=$userVal[seq]?>">
										<span class="fa fa-check"></span>
									</label>
								</div>
								<span><?=$userVal[name]." [".$userVal[id]."]";?></span>
							</a>
						</li>
					<?}?>
					</ul>
				</li>
			</ul>
			<?if($_SESSION['user_auth'] == '4' || $_SESSION['user_auth'] == '3' ){?>
				<div class="btn-group m-2 float-right">
					<button class="btn btn-sm btn-outline-info" type="button" id="addUser">사용자 추가</button>
					<button class="btn btn-sm btn-outline-danger" type="button" id="delBtn">삭제</button>
				</div>
			<?}?>
			<!-- END sidebar nav-->
		</nav>
	</div>
	<!-- END Sidebar (left)-->
</aside>
