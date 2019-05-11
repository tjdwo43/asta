<?	
	$offTd = '<td style="background-color:#656565; color:#fff"></td>';
	
	ob_start();

	if(count($apiResult['data']) == 0 ){?>
		
	<?}

	foreach($apiResult['data'] as $deviceRow){
		if($deviceRow['GatewayUseYN'] == '1'){
?>
	<tr>
		<input type="hidden" name="serialNo" value="<?=$deviceRow['SerialNo']?>"/>
		<input type="hidden" name="gatewayKey" value="<?=$deviceRow['GatewayKey']?>"/>

		<!-- Gateway Name -->
		<td class="text-truncate">
			<?
			if($deviceRow['GatewayCmt'] != '' || $deviceRow['GatewayCmt'] != null){
				echo $deviceRow['GatewayCmt'];
			}else {
				echo $deviceRow['GatewayName'];
			}
			
			?>
		</td>
		<!-- Gateway Name -->

		<!-- 입력 -->
		<?
			for($i=0; $i<6; $i++){
				$inchCmtNum = $i+1;
				$inchSelectVal = $deviceRow["inch".$inchCmtNum."Select"];
				$inchStatusVal = $deviceRow["inch".$inchCmtNum];
				$inchCmtVal = $deviceRow["inch".$inchCmtNum."Cmt"];

				if($inchSelectVal == "2"){
					$inchStatus = "fa fas fa-chart-bar";		//상태
				}else if($inchSelectVal == "1"){
					$inchStatus = "fa icon-bell";	//알람
				}else {
					$inchStatus = "";
				}

				if($inchStatusVal == "1"){
					$inch_bgColor = "#76bc57";	// 정상
				}else if($inchStatusVal == "2"){
					$inch_bgColor = "#e57b80";	// 신호가 들어오지 않음
				}else if($inchStatusVal == "0"){	//알 수 없는 신호
					$inch_bgColor = "#fff";
				}
			if($inchSelectVal != '0'){?>
				<td style="background-color:<?=$inch_bgColor?>; color:#fff" >
					<em class="<?=$inchStatus?>"></em>
                    <p class="line2-ellisis">
                        <?=$inchCmtVal?>
                    </p>
				</td>
			<?}else{
				echo $offTd;	
			}?>
		<?}?>
		<!-- 입력 -->
		
		<!-- 출력 -->
		<?
			for($i=0; $i<3; $i++){
				$outchCmtNum = $i+1;

				$outchSelectVal = $deviceRow["outch".$outchCmtNum."Select"];
				$outchStatusVal = $deviceRow["outch".$outchCmtNum];
				$outchOnOFFVal = $deviceRow["outch".$outchCmtNum."OnOff"];
				$outchCmt = $deviceRow["outch".$outchCmtNum."Cmt"];

				if($outchSelectVal == '3'){
					$outchIcon = "fa far fa-clock";
				}else {
					$outchIcon = "fa fas fa-desktop";
				}
				
				if($outchOnOFFVal  == '1' || $outchOnOFFVal  == '3'){
					$outch_bgColor = "#e57b80";	//빨간색, 출력
				}else if($outchOnOFFVal  == '2' || $outchOnOFFVal  == '4'){
					$outch_bgColor = "#76bc57";	//초록색, 미출력
				}

			if($outchSelectVal == '1' || $outchSelectVal == '3'){?>	
				<td style="background-color:<?=$outch_bgColor?>; color:#fff;" class="<?=($_SESSION['user_auth'] >= 2)?"outch":""?>  text-truncate" data-OnOff=<?=$outchOnOFFVal?>>
                    <em class="<?=$outchIcon?>"></em>
                    <p class="line2-ellisis">
                        <span><?=$outchCmt?></span>
                    </p>
				</td>
			<?}else {?>
				<td style="background-color:#656565; color:#fff;" data-OnOff=<?=$outchOnOFFVal?>></td>
			<?}
		}?>
		<!-- 출력 End-->

		<!-- 온도 -->
		<?if($deviceRow['tempYN'] == '1'){?>
			<td>
                <?=$deviceRow['temperature']?>&deg;C
                <p class="line2-ellisis">
                    <span><?=$deviceRow['tempCmt']?></span>
                </p>

			</td>
		<?}else{
			echo $offTd;
		}?>
		<!-- 습도 -->
		<?if($deviceRow['huYN'] == '1'){?>
			<td>
				<?=$deviceRow['humidity']?>%
                <p class="line2-ellisis">
                    <span><?=$deviceRow['huCmt']?></span>
                </p>
			</td>
		<?}else{
			echo $offTd;
		}?>
		<!-- Gas -->
		<?if($deviceRow['gasYN'] == '1'){?>
			<td>
				<?=$deviceRow['gas']?>%
                <p class="line2-ellisis">
                    <span><?=$deviceRow['gasCmt']?></span>
                </p>
			</td>
		<?}else{
			echo $offTd;
		}?>
	</tr>
<?
	}
}

$output = ob_get_contents();
ob_end_clean();

$result['data'] = $apiResult['data'];
$result['html'] = $output;

echo json_encode($result);
?>