<!-- Nav tabs-->
<ul class="nav nav-tabs nav-fill" role="tablist">
	<?
		$i=0;

		foreach($typeArr as $key => $typeData){
			$activeTab ="";
			switch ($key) {
				case 'login' : $tabName = "로그인/로그아웃"; $tagId="accessInfo";break;
				case 'userLog' : $tabName = "사용자 로그";  $tagId="userLog";break;
				case 'IODevice' : $tabName = "I/O 장비 로그"; $tagId="IODeviceLog";break;
				case 'GWInfo' : $tabName = "G/W ON/OFF"; $tagId="gWOnOFF";break;
				case 'InOutChange' : $tabName = "IN/OUT Ch 변동"; $tagId="iNOUTchLog";break;
				case 'thgLog' : $tabName = "온도/습도/가스 로그"; $tagId="thgLog";break;
				case 'dayLog' : $tabName = "일간 타임스케줄"; $tagId="dayScheLog"; break;
				case 'weekLog' : $tabName = "주간 타임스케줄"; $tagId="weekScheLog";break;
				case 'pushLog' : $tabName = "PUSH 알람 로그"; $tagId="pushLog";break;
			}
			
			if($i==0){
				$activeTab = 'active';
				$i++;
			}
	?>
		<li class="nav-item" role="presentation">
			<a class="nav-link show <?=$activeTab?>" href="#<?=$tagId?>" aria-controls="<?=$tagId?>" role="tab" data-toggle="tab" aria-selected="false">
				<em class="far fa-clock fa-fw"></em><?=$tabName?>
			</a>
		</li>
	<?}?>
</ul>
<!-- Nav tabs End-->

<!-- Tab panes-->
<div class="tab-content p-0">
	<?
	$j=0;
	foreach($typeArr as $key => $typeData){
		$activeTab ="";
		switch ($key) {
			case 'login' : $tabName = "로그인/로그아웃"; $tagId="accessInfo";break;
			case 'userLog' : $tabName = "사용자 로그";  $tagId="userLog";break;
			case 'IODevice' : $tabName = "I/O 장비 로그"; $tagId="IODeviceLog";break;
			case 'GWInfo' : $tabName = "G/W ON/OFF"; $tagId="gWOnOFF";break;
			case 'InOutChange' : $tabName = "IN/OUT Ch 변동"; $tagId="iNOUTchLog";break;
			case 'thgLog' : $tabName = "온도/습도/가스 로그"; $tagId="thgLog";break;
			case 'dayLog' : $tabName = "일간 타임스케줄"; $tagId="dayScheLog"; break;
			case 'weekLog' : $tabName = "주간 타임스케줄"; $tagId="weekScheLog";break;
			case 'pushLog' : $tabName = "PUSH 알람 로그"; $tagId="pushLog";break;
		}

		if($j==0){
			$activeTab = 'active';
			$j++;
		}
	?>
		<div class="tab-pane show <?=$activeTab?>" id="<?=$tagId?>" role="tabpanel">
			<!-- START table responsive-->
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
					<?if($key == 'login'){?>
						<th>고유번호</th>
						<th>부서</th>
						<th>연락처</th>
						<th>권한</th>
						<th>상태</th>
						<th>날짜</th>
					<?}else if($key == 'userLog'){?>
						<th>대상자 고유번호</th>
						<th>대상자 부서</th>
						<th>대상자 연락처</th>
						<th>대상자 권한</th>
						<th>대상자 ID</th>
						<th>대상자 이름</th>
						<th>작업자 권한</th>
						<th>상태</th>
						<th>날짜</th>
					<?}else if($key == 'IODevice'){?>
						<th>SerialNo</th>
						<th>위치</th>
						<th>IP Addr</th>
						<th>MAC Addr</th>
						<th>작업자 ID</th>
						<th>작업자 권한</th>
						<th>상태</th>
						<th>날짜</th>
					<?}else if($key == 'GWInfo'){?>
						<th>SerialNo</th>
						<th>GatewayKey</th>
						<th>상태</th>
						<th>날짜</th>
					<?}else if($key == 'InOutChange'){?>
						<th>SerialNo</th>
						<th>GatewayKey</th>
						<th>상태</th>
						<th>날짜</th>
					<?}else if($key == 'thgLog'){?>
						<th>SerialNo</th>
						<th>GatewayKey</th>
						<th>수치</th>
						<th>상태</th>
						<th>날짜</th>
					<?}else if($key == 'dayLog'){?>
						<th>상태</th>
						<th>날짜</th>
					<?}else if($key == 'weekLog'){?>
						<th>상태</th>
						<th>날짜</th>
					<?}else if($key == 'pushLog'){?>
						<th>Gateway Key</th>
						<th>Device Id</th>
						<th>이름</th>
						<th>내용</th>
						<th>날짜</th>
					<?}?>
					</tr>
				</thead>
				<tbody>
					<?foreach($typeData as $data){
						if($key == 'login'){?>
							<tr>
								<td><?=$data['seq']?></td>
								<td><?=$data['depart']?></td>
								<td><?=$data['phone']?></td>
								<td><?=$data['authName']?></td>
								<td><?=$data['status']?></td>
								<td><?=$data['regDate']?></td>
							</tr>
						<?}else if($key == 'userLog'){?>
							<tr>
								<td><?=$data['seq']?></td>
								<td><?=$data['depart']?></td>
								<td><?=$data['phone']?></td>
								<td><?=$data['authName']?></td>
								<td><?=$data['wId']?></td>
								<td><?=$data['wName']?></td>
								<td><?=$data['wAuth']?></td>
								<td><?=$data['status']?></td>
								<td><?=$data['regDate']?></td>
							</tr>
						<?}else if($key == 'IODevice'){?>
							<tr>
								<td><?=$data['SerialNo']?></td>
								<td><?=$data['Location']?></td>
								<td><?=$data['DeviceId']?></td>
								<td><?=$data['MACAddr']?></td>
								<td><?=$data['IPAddr']?> ID</td>
								<td><?=$data['useYN']?></td>
								<td><?=$data['status']?></td>
								<td><?=$data['regDate']?></td>
							</tr>
						<?}else if($key == 'GWInfo'){?>
							<tr>
								<td><?=$data['SerialNo']?></td>
								<td><?=$data['GatewayKey']?></td>
								<td><?=$data['gwChange']?></td>
								<td><?=$data['regDate']?></td>
							</tr>
						<?}else if($key == 'InOutChange'){?>
							<tr>
								<td><?=$data['SerialNo']?></td>
								<td><?=$data['GatewayKey']?></td>
								<td><?=$data['inOutChange']?></td>
								<td><?=$data['regDate']?></td>
							</tr>
						<?}else if($key == 'thgLog'){?>
							<tr>
								<td><?=$data['SerialNo']?></td>
								<td><?=$data['GatewayKey']?></td>
								<td><?=$data['thgMaximum']?></td>
								<td><?=$data['thgStatus']?></td>
								<td><?=$data['regDate']?></td>
							</tr>
						<?}else if($key == 'dayLog'){?>
							<tr>
								<td><?=$data['dayTS']?></td>
								<td><?=$data['regDate']?></td>
							</tr>
						<?}else if($key == 'weekLog'){?>
							<tr>
								<td><?=$data['weekTS']?></th>
								<td><?=$data['regDate']?></td>
							</tr>
						<?}else if($key == 'pushLog'){?>
							<tr>
								<td><?=$data['gatewayKey']?></td>
								<td><?=$data['deviceId']?></td>
								<td><?=$data['orgName']?></th>
								<td><?=$data['pushText']?></td>
								<td><?=$data['regDate']?></td>
							</tr>
						<?}
					}?>
				</tbody>
				</table>
			</div>
			<!-- END table responsive-->
		</div>
	<?}?>
</div>