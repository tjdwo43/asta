<?
	session_start();

	include $_SERVER[DOCUMENT_ROOT]."/device/device.php";
	
	$mode = $_POST['mode'];

	switch($mode){
        case 'getMainDeivce' :
            if($_SESSION["user_auth"] == 4 ){	//관리자 A
                $regist_seq = 0;
            }else if($_SESSION["user_auth"] == 3){	//관리자 B
                $regist_seq = $_SESSION["user_seq"];
            }else {	//사용자
                $regist_seq = $_SESSION["user_superId"];
            }

            $postData = Array(
                'regist_seq' => $regist_seq,
                'org_code' => $_POST["org_code"]
            );

            $getDeviceList = getDeviceList($postData);

            $deviceListJson = json_encode($getDeviceList);

            echo $deviceListJson;
            break;
		case 'registDevice' :	//control I/O 등록
			$postData = Array(
							'SerialNo' => $_POST['SerialNo'],
							'BoardName' => $_POST['BoardName'],
							'Location' => $_POST['Location'],
							'DeviceId' => $_POST['DeviceId'],
							'MACAddr' => $_POST['MACAddr'],
							'IPAddr' => $_POST['IPAddr'],
							'Port' => $_POST['Port'],
							'regist_seq' => $_POST['regist_seq'],
							'org_code' => $_POST['org_code'],
							'useYN' => $_POST['useYN'],
							'id' => $_POST['id']
						);
			$apiResult = regDevice($postData);

			echo $apiResult['result'];

			break;
		case 'deleteDevice' :	//control I/O 삭제
			$postData = Array(
							'SerialNo' => $_POST['serialNo'],
							'BoardName' => $_POST['BoardName'],
							'Location' => $_POST['Location'],
							'DeviceId' => $_POST['DeviceId'],
							'MACAddr' => $_POST['MACAddr'],
							'IPAddr' => $_POST['Port'],
							'Port' => $_POST['Port'],
							'org_code' => $_SESSION['user_orgCode'],
							'useYN' => $_POST['useYN'],
							'id' => $_SESSION['user_id']
						);

			$apiResult = delDevice($postData);

			echo $apiResult['result'];

			break;
		case 'updateDevice' :	//control I/O 수정
			$postData = Array(
							'SerialNo' => $_POST['SerialNo'],
							'BoardName' => $_POST['BoardName'],
							'Location' => $_POST['location'],
							'IPAddr' => $_POST['IPAddr'],
							'Port' => $_POST['Port'],
							'regist_seq' => $_POST['regist_seq'],
							'useYN' => $_POST['useYN'],
							'id' => $_SESSION['user_id'],
							'DeviceId' => $_POST['DeviceId'],
							'MACAddr' => $_POST['MACAddr'],
							'org_code' => $_SESSION['user_orgCode']
						);

			$apiReuslt = updateDevice($postData);

			echo $apiResult['result'];

			break;
		case 'getGWDevice' :	//Gateway 리스트
			$postData = Array(
							'SerialNo' => $_POST['SerialNo']
						);
			$apiResult = getGWDevice($postData);

			if(count($apiResult[data]) == 0){?>
				<tr>
					<td colspan="15">
						<div class="card-defalut">
							<div class="card-header"><h4>등록 된 GW가 없습니다.</h4></div>
						</div>
					</td>
				</tr>
				
			<?
			
			//return;
			}
			
			foreach($apiResult[data] as $key => $gwList){
				$gwName = "gw".$key;
				$cmtName = "cmt".$key;

				$tempMaxName = "tempMax".$key;
				$tempMinName = "tempMin".$key;

				$huMaxName = "huMax".$key;
				$huMinName = "huMin".$key;

				$gasMaxName = "gasMax".$key;
				$gasMinName = "gasMin".$key;

				$gatewayUseYN = ($gwList["GatewayUseYN"] == 1)?"checked":""; 
				?>
				<tr>
					<input type="hidden" name="keyValue" value="<?=$key?>" />
					<input type="hidden" name="<?=$gwName?>" value="<?=$gwList["GatewayKey"]?>">
					<input type="hidden" name="<?=$tempMaxName?>" value="<?=$gwList["tempMax"]?>"/>
					<input type="hidden" name="<?=$tempMinName?>" value="<?=$gwList["tempMin"]?>"/>
					<input type="hidden" name="<?=$huMaxName?>" value="<?=$gwList["huMax"]?>"/>
					<input type="hidden" name="<?=$huMinName?>" value="<?=$gwList["huMin"]?>"/>
					<input type="hidden" name="<?=$gasMaxName?>" value="<?=$gwList["gasMax"]?>"/>
					<input type="hidden" name="<?=$gasMinName?>" value="<?=$gwList["gasMin"]?>"/>
					<input type="hidden" name="useChangeVal" value="0" />
					<input type="hidden" name="inChangeVal" value="0" />
					<input type="hidden" name="outChangeVal" value="0" />
					<input type="hidden" name="addBtnYN" value="0" />
					<input type="hidden" name="outch1TS" value="<?=$gwList["outch1TS"]?>"/>
					<input type="hidden" name="outch2TS" value="<?=$gwList["outch2TS"]?>"/>
					<input type="hidden" name="outch3TS" value="<?=$gwList["outch3TS"]?>"/>
					<input type="hidden" name="outch1OnOff" value="<?=$gwList["outch1OnOff"]?>"/>
					<input type="hidden" name="outch2OnOff" value="<?=$gwList["outch2OnOff"]?>"/>
					<input type="hidden" name="outch3OnOff" value="<?=$gwList["outch3OnOff"]?>"/>

					<td rowspan="2">
						<label class="switch">
							<input type="checkbox" <?=$gatewayUseYN?> class="useChange" value="<?=$gwList["GatewayUseYN"]?>">
							<span></span>
						</label>
					</td>

					<td>
						<input class="form-control inputChange" placeholder="Comment" autocomplete="off" name="<?=$gwName?>" value="<?=$gwList[GatewayName]?>" disabled>
					</td>
					
					<!-- INPUT -->
					<?
						for($i=0; $i<6; $i++){
							$inchNum = $i+1;
							$offSelect = ($gwList["inch".$inchNum."Select"] == "0")?"selected":"";
							$smsSelect = ($gwList["inch".$inchNum."Select"] == "3")?"selected":"";
							$statusSelect = ($gwList["inch".$inchNum."Select"] == "2")?"selected":"";
							$alramSelect = ($gwList["inch".$inchNum."Select"] == "1")?"selected":"";
					?>
							<td>
								<select class="custom-select custom-select-sm inputChange" name="<?=$gwName?>">
									<option value="2" <?=$statusSelect?>>상태</option>
									<option value="1" <?=$alramSelect?>>경보</option>
									<option value="0" <?=$offSelect?>>OFF</option>
								</select>
							</td>
					<?
						}
					?>

					<!-- OUT -->
					<?
						for($i=0; $i<3; $i++){
							$outchNum = $i+1;
							$noSelect = ($gwList["outch".$outchNum."Select"] == "")?"selected":"";
							$onSelect = ($gwList["outch".$outchNum."Select"] == "1")?"selected":"";
							$offSelect = ($gwList["outch".$outchNum."Select"] == "2")?"selected":"";
							$schedulesSelect = ($gwList["outch".$outchNum."Select"] == "3")?"selected":"";
					?>
						<td>
							<select class="custom-select custom-select-sm outChange" name="<?=$gwName?>" data-outch="<?=$i+1?>">
								<option value="1" <?=$onSelect?>>사용</option>
								<option value="2" <?=$offSelect?>>사용안함</option>
								<option value="3" <?=$schedulesSelect?>>스케쥴</option>
							</select>
						</td>
					<?}?>
					<!-- OUT -->

					<td> 
						<label class="switch d-block m-0">
							<input type="checkbox" <?=($gwList[tempYN] == '1')?"checked":"";?> class="tempModal" name="<?=$gwName?>" value="<?=$gwList[tempYN]?>">
							<span></span>
						</label>
					</td>
					<!-- 습도 -->
					<td> 
						<label class="switch d-block m-0">
							<input type="checkbox" <?=($gwList[huYN] == '1')?"checked":"";?> class="huModal" name="<?=$gwName?>" value="<?=$gwList[huYN]?>" > 
							<span></span>
						</label>
					</td>
					<!-- Gas -->
					<td >
						<label class="switch d-block m-0">
							<input type="checkbox" <?=($gwList[gasYN] == '1')?"checked":"";?> class="gasModal" name="<?=$gwName?>" value="<?=$gwList[gasYN]?>" >
							<span></span>
						</label>
					</td>
					<td rowspan="2">
						<div class="btn-group">
							<button class="btn btn-info" name="updateGW" value="<?=$key?>">수정</button>
							<!-- <button class="btn btn-outline-danger" name="delGWBtn" >삭제</button> -->
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<input class="form-control cmt" placeholder="Comment" autocomplete="off" name="<?=$cmtName?>" value="<?=$gwList[GatewayCmt]?>" >
					</td>
					<?
						for($i=0; $i<6; $i++){
							$inchCmtNum = $i+1;
							$inchCmtVal = $gwList["inch".$inchCmtNum."Cmt"];
					?>
						<td>
							<input class="form-control cmt" placeholder="Comment" autocomplete="off" name="<?=$cmtName?>" value="<?=$inchCmtVal?>" >
						</td>
					<?}?>
					
					<?
						for($i=0; $i<3; $i++){
							$outchCmtNum = $i+1;
							$outchCmtVal = $gwList["outch".$outchCmtNum."Cmt"];
					?>
							<td>
								<input class="form-control cmt" placeholder="Comment" autocomplete="off" name="<?=$cmtName?>" value="<?=$outchCmtVal?>" >
							</td>
					<?
						}
					?>

					<td>
						<input class="form-control cmt" placeholder="Comment" autocomplete="off" name="<?=$cmtName?>" value="<?=$gwList[tempCmt]?>" >
					</td>
					<td>
						<input class="form-control cmt" placeholder="Comment" autocomplete="off" name="<?=$cmtName?>" value="<?=$gwList[huCmt]?>">
					</td>
					<td>
						<input class="form-control cmt" placeholder="Comment" autocomplete="off" name="<?=$cmtName?>" value="<?=$gwList[gasCmt]?>" >
					</td>
				</tr>
			<?}
			break;
		case 'updateGW' :		//Gateway 수정
			$postData = $_POST;

			array_splice( $postData, 0, 1 );

			$postData['id'] = $_SESSION['user_id'];
			$postData['org_code'] = $_SESSION['user_orgCode'];

			$apiResult = updateGWDevice($postData);

			echo $apiResult['result'];

			break;
		case 'deleteGW' :		//Gateway 삭제
			break;
		case 'getMornDevice_n' :	//Gateway모니터링 리스트
			$postData = Array(
				'SerialNo' => $_POST['SerialNo']
			);
			$apiResult = getGWDevice($postData);
			
			include $_SERVER['DOCUMENT_ROOT']."/device/deviceMornTable.php";
			break;	
		case 'updateOutch' :		//출력 채널 On/Off 바꾸기		
			$postData = Array(
							"SerialNo" => $_POST["SerialNo"],
							"GatewayKey" => $_POST["GatewayKey"],
							"outch1OnOff" => $_POST["outch1"],
							"outch2OnOff" => $_POST["outch2"],
							"outch3OnOff" => $_POST["outch3"],
							"id" => $_SESSION["user_id"]
						);
			$apiResult = updateOutch($postData);

			echo $apiResult['result'];
			
			break;
		case 'getScheduleTemplate' :	//스케줄 템플릿 가져오기
			include_once $_SERVER['DOCUMENT_ROOT']."/schedule/scheduleApi.php";
				$user_superId = ($_SESSION['user_superId'])?$_SESSION["user_superId"]:"";

				$data = array(
					"org_code" => $_SESSION["user_orgCode"],
					"superId" => $user_superId
				);

				$weekTemplateList = getTimeWeekTemplate($data);
				
				foreach($weekTemplateList['data'] as $weekTemp){
					$optionHtml .= '<option value='.$weekTemp['seq'].'>'.$weekTemp['wTempName'].'</option>';
				}

				echo $optionHtml;
			break;
		case 'updateGWTS' :		//출력에서 예약 설정
			$outch1TS = $_POST["outch1TS"] ?? "";
			$outch2TS = $_POST["outch2TS"] ?? "";
			$outch3TS = $_POST["outch3TS"] ?? "";

			$postData = Array(
							"SerialNo" => $_POST["serialNo"],
							"GatewayKey" => $_POST["gatewayKey"],
							"outch1TS" => $outch1TS ,
							"outch2TS" => $outch2TS,
							"outch3TS" => $outch3TS,
							"id" => $_SESSION["user_id"]
						);
			
			$apiResult = updateGWTS($postData);

			echo $apiResult;

			break;
		case 'allDeleteGW' : //gateway 일괄 삭제
			$postData = Array(
				"SerialNo" => $_POST["serialNo"],
				"id" => $_SESSION["user_id"]
			);
			
			$apiResult = allDeleteGW($postData);

			echo $apiResult['result'];

			break;
	}
?>