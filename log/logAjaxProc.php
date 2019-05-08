<?
	session_start();

	include $_SERVER[DOCUMENT_ROOT]."/log/logApi.php";
	
	$mode = $_POST['mode'];

	switch ($mode) {
		case 'getHistoryList' :
			$postData = Array(
				'org_code' => $_SESSION['user_orgCode'],
				'typex' => $_POST['typex'],
				'startDate' => $_POST['startDate']." 00:00:00",
				'endDate' => $_POST['endDate']." 23:59:59",
				'key'=> $_POST['key'],
				'auth' => $_SESSION['user_auth']
			);

			$apiResult = getHistoryList($postData);

			$typeArr1 = Array();	// 로그인,로그아웃
			$typeArr2 = Array();	// 사용자 등록 , 삭제 , 변경
			$typeArr3 = Array();	// I/O 장비 등록 , 삭제 , 변경
			$typeArr4 = Array();	// G/W 사용함,사용 안함
			$typeArr5 = Array();	// INCH/OUTCH 변동 알림
			$typeArr6 = Array();	// 온도,습도,가스 최대 최소치 초과 미달로그
			$typeArr7 = Array();	// 일간 타임스케줄 등록, 변경, 삭제
			$typeArr8 = Array();	// 주간 타임스케줄 등록, 변경, 삭제
			$typeArr9 = Array();	// 푸쉬로그

			foreach($apiResult['data'] as $key => $apiDataArr){
				$regDate = substr($apiDataArr['regDate'], 0, 16);
				switch ($apiDataArr['type']){
					case '1' : 
						array_push($typeArr1, Array(
									'seq' => $apiDataArr['key'],
									'regDate' => $regDate,
									'depart' => $apiDataArr['etc1'],
									'phone' => $apiDataArr['etc2'],
									'authName' => $apiDataArr['etc3'],
									'status' => $apiDataArr['etc4']
								));
						break;
					case '2' :
						array_push(
							$typeArr2, 
							Array(
								'seq' => $apiDataArr['key'],
								'regDate' => $regDate,
								'depart' => $apiDataArr['etc1'],
								'phone' => $apiDataArr['etc2'],
								'authName' => $apiDataArr['etc3'],
								'wId' => $apiDataArr['etc4'],
								'wName' => $apiDataArr['etc5'],
								'wAuth' => $apiDataArr['etc6'],
								'status' => $apiDataArr['etc7']
							)
						);
						break;
					case '3' :
						array_push(
							$typeArr3, 
							Array(
								'SerialNo' => $apiDataArr['key'],
								'regDate' => $regDate,
								'Location' => $apiDataArr['etc1'],
								'DeviceId' => $apiDataArr['etc2'],
								'MACAddr' => $apiDataArr['etc3'],
								'IPAddr' => $apiDataArr['etc4'],
								'Port' => $apiDataArr['etc5'],
								'useYN' => $apiDataArr['etc6'],
								'status' => $apiDataArr['etc7']
							)
						);
						break;
					case '4' :
						array_push($typeArr4, Array(
							'SerialNo' => $apiDataArr['key'],
							'regDate' => $regDate,
							'GatewayKey' => $apiDataArr['etc1'],
							'gwChange' => $apiDataArr['etc2']
						));
						break;
					case '5' :
						array_push($typeArr5, Array(
							'SerialNo' => $apiDataArr['key'],
							'regDate' => $regDate,
							'GatewayKey' => $apiDataArr['etc1'],
							'inOutChange' => $apiDataArr['etc2']
						));
						break;
					case '6' :
						array_push($typeArr6, Array(
							'SerialNo' => $apiDataArr['key'],
							'regDate' => $regDate,
							'GatewayKey' => $apiDataArr['etc1'],
							'thgMaximum' => $apiDataArr['etc2'],
							'thgStatus' => $apiDataArr['etc3']
						));
						break;
					case '7' :
						array_push($typeArr7, Array(
							'dayTS' => $apiDataArr['etc1'],
							'regDate' => $regDate
						));
						break;
					case '8' :
						array_push($typeArr8, Array(
							'regDate' => $regDate,
							'weekTS' => $apiDataArr['etc1']
						));
						break;
					case '9' :
						array_push($typeArr9, Array(
							'regDate' => $regDate,
							'orgName' => $apiDataArr['etc1'],
							'pushText' => $apiDataArr['etc2'],
							'deviceId' => $apiDataArr['etc3'],
							'gatewayKey' => $apiDataArr['etc4']
						));
						break;
				}
			}
			
			if(count($typeArr1) != 0) $typeArr['login'] = $typeArr1;
			if(count($typeArr2) != 0) $typeArr['userLog'] = $typeArr2;
			if(count($typeArr3) != 0) $typeArr['IODevice'] = $typeArr3;
			if(count($typeArr4) != 0) $typeArr['GWInfo'] = $typeArr4;
			if(count($typeArr5) != 0) $typeArr['InOutChange'] = $typeArr5;
			if(count($typeArr6) != 0) $typeArr['thgLog'] = $typeArr6;
			if(count($typeArr7) != 0) $typeArr['dayLog'] = $typeArr7;
			if(count($typeArr8) != 0) $typeArr['weekLog'] = $typeArr8;
			if(count($typeArr9) != 0) $typeArr['pushLog'] = $typeArr9;
			
			//p($typeArr);
			include $_SERVER[DOCUMENT_ROOT]."/log/cBoardHistory.php";
			
			break;
	}
?>