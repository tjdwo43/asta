<? 
	if($_POST){
		$dateTemplateList = [];
		$dateTemplateList['data'] = json_decode($_POST['postData'], true);
	}
?>
<!-- sidebar-->
<aside class="aside-container">
	<!-- START Sidebar (left)-->
	<div class="aside-inner">
		<nav class="sidebar" data-sidebar-anyclick-close="">
			<!-- START sidebar nav-->
			<ul class="sidebar-nav">
				<li class="p-3">
					<div class="btn-group" style="width:100%">
						<button name="dayBtn" style="width:50%;" class="btn btn-secondary btn-large" onclick='window.location.href="/schedule/scheduleView.php";'>Day</button>
						<button name="weekBtn" style="width:50%;" class="btn btn-secondary btn-large" onclick='window.location.href="/schedule/scheduleWView.php";'>Week</button>
					</div>
				</li>
				<!-- Iterates over all sidebar items-->
				<li class="active">
					<a>
						<div id="countUser" class="float-right badge badge-success"><?=count($weekTemplateList[data]);?></div> 
						<div class="checkbox c-checkbox d-inline-block">
							<label>
								<input type="checkbox" name="checkAll">
								<span class="fa fa-check"></span>
							</label>
						</div> 
						<span>템플릿 목록</span>
					</a>
					<ul class="sidebar-nav sidebar-subnav collapse show" id="dashboard">
						<?foreach($weekTemplateList[data] as $timeData){?>
							<li name="weekTemplateList">
								<a href="#<?=$timeData["wTempName"]?>" class="getWeekTimeTemplate" data-tempwSeq="<?=$timeData["seq"]?>"> 
									<div class="checkbox c-checkbox d-inline-block">
										<label>
											<input type="checkbox" name="checkOne" value="<?=$timeData["seq"]?>">
											<span class="fa fa-check"></span>
										</label>
									</div>
									<span><?=$timeData["wTempName"];?></span>
								</a>
							</li>
						<?}?>
					</ul>
				</li>
			</ul>
			<div class="btn-group m-2 float-right">
				<?if($_SESSION['user_auth'] == 4 || $_SESSION['user_auth'] == 3){?>
					<button class="btn btn-sm btn-outline-danger" type="button" id="delWBtn">삭제</button>
				<?}?>
			</div>
			<!-- END sidebar nav-->
		</nav>
	</div>
	<!-- END Sidebar (left)-->
</aside>