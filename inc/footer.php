		<?if($isMobileBar){?>
			<!-- 모바일 하단 탭바 -->
			<div class="mobile-navbar">
				<a data-toggle-state="aside-toggled" data-no-persist="true">
					<em class="fas fa-bars"></em>
				</a>
				<a onclick="movetop();">
					<em class="fas fa-chevron-up"></em>
				</a>
			</div>
		<?}?>

		<script type="text/javascript">
            
            //시리얼 리스트
            var deviceSerialNoList = '<?=json_encode($getSerialNo)?>';
            var deviceSerialNoListJson = $.parseJSON(deviceSerialNoList);

            $(document).ready(function(){
                let currentDateStr = getTimeStamp();

                var config = {
                    apiKey: "AIzaSyB5fynBW8XxyKncF0jfF5zkl6Ea9V7pm_g",
                    authDomain: "asta-49744.firebaseapp.com",
                    databaseURL: "https://asta-49744.firebaseio.com",
                    projectId: "asta-49744",
                    storageBucket: "asta-49744.appspot.com",
                    messagingSenderId: "409436546529"
                };

                if (!firebase.apps.length) {
                    firebase.initializeApp(config);
                }

                var db = firebase.firestore();

                let currentSerialNo = $("[name=deviceList]").find(".getDeviceList ").data("serialnum");

                $("[name=deviceList]").find(".getDeviceList ").each(function(){

                    if($(this).hasClass("clickedList") ) currentSerialNo = $(this).data("serialnum");

                })

                console.log(deviceSerialNoListJson)

                var deviceRef = db.collection("tb_gateway")

                $.each ( deviceSerialNoListJson, function (i, v){

                    db.collection("tb_gateway").where("SerialNo", "==", v)
                        .onSnapshot(function(snapshot) {
                            snapshot.docChanges.forEach(function(change) {

                                if (change.type === "modified") {

                                    if (change.doc.data().inch1 == 2) {
                                        if (change.doc.data().GatewayCmt != '') alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch1에서 감지 발생");
                                        else alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch1에서 감지 발생");
                                    }

                                    if (change.doc.data().inch2 == 2) {
                                        if (change.doc.data().GatewayCmt != '') alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch2에서 감지 발생");
                                        else alert(currentDateStr + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch2에서 감지 발생");
                                    }

                                    if (change.doc.data().inch3 == 2) {
                                        if (change.doc.data().GatewayCmt != '') alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch3에서 감지 발생");
                                        else alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch3에서 감지 발생");
                                    }

                                    if (change.doc.data().inch4 == 2) {
                                        if (change.doc.data().GatewayCmt != '') alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch4에서 감지 발생");
                                        else alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch4에서 감지 발생");
                                    }

                                    if (change.doc.data().inch5 == 2) {
                                        if (change.doc.data().GatewayCmt != '') alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch5에서 감지 발생");
                                        else alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch5에서 감지 발생");
                                    }

                                    if (change.doc.data().inch6 == 2) {
                                        if (change.doc.data().GatewayCmt != '') alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch6에서 감지 발생");
                                        else alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ")의 inch6에서 감지 발생");
                                    }

                                    if (change.doc.data().tempYN == 1) {

                                        if (change.doc.data().tempMax < change.doc.data().temperature) {
                                            if (change.doc.data().GatewayCmt != '') alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 온도 최대값 초과");
                                            else alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 온도 최대값 초과");
                                        }

                                        if (change.doc.data().tempMin > change.doc.data().temperature) {
                                            if (change.doc.data().GatewayCmt != '') alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 온도 최소값 미달");
                                            else alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 온도 최소값 미달");
                                        }

                                    }

                                    if (change.doc.data().huYN == 1) {

                                        if (change.doc.data().huMax < change.doc.data().humidity) {
                                            if (change.doc.data().GatewayCmt != '') alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 습도 최대값 초과");
                                            else alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 습도 최대값 초과");
                                        }

                                        if (change.doc.data().tempMin > change.doc.data().humidity) {
                                            if (change.doc.data().GatewayCmt != '') alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 습도 최소값 미달");
                                            else alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 습도 최소값 미달");
                                        }

                                    }

                                    if (change.doc.data().gasYN == 1) {

                                        if (change.doc.data().gasMax < change.doc.data().gas) {
                                            if (change.doc.data().GatewayCmt != '') alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 가스 최대값 초과");
                                            else alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 가스 최대값 초과");
                                        }

                                        if (change.doc.data().gasMin > change.doc.data().gas) {
                                            if (change.doc.data().GatewayCmt != '') alert(currentDateStr + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 가스 최소값 미달");
                                            else alert(currentDateStr + " " + change.doc.data().GatewayCmt + "(" + change.doc.data().GatewayName + ") 가스 최소값 미달");
                                        }

                                    }

                                }
                            }); // E : onSnapshot.foreach
                        }); // E : onSnapshot

                })


            }); // E : realTime document.ready

			var loginYN = document.getElementById("loginYN").value;
			var loginId = '<?=$_SESSION["user_id"]?>';
			var loginCode = '<?=$_SESSION["user_orgCode"]?>';
/*
			if(loginYN == 1){
				//var socket =  io.connect('http://dev.sh-system.co.kr:3000', {transports: ["htmlfile", "xhr-multipart", "xhr-polling", "jsonp-polling", "websocket", "flashsocket"]},{'force new connection': true});
				var socket =  io.connect('http://dev.sh-system.co.kr:3000', {transports:['websocket'], upgrade: false}, {'force new connection': true});
				//var socket =  io.connect('http://dev.sh-system.co.kr:3000');
				socket.on('connect', function(){
					socket.emit('adduser', loginId, loginCode);
					socket.emit('ping', 1);
				});
				
				socket.on('disconnect', function(reason)  {
					console.log("disconnect : " + reason);
					socket.connect();
				});

				socket.on('updatechat', function(username, data) {
					console.log(data);
					if(data != null && data.indexOf("{") == 0) {
						var alertMsgObj = JSON.parse(data);

						if(alertMsgObj.time == 'realTime3'){
							if('<?=$basename?>' == 'deviceMornView.php'){
								var outch1OnOff = alertMsgObj.data.outch1OnOff;
								var outch2OnOff = alertMsgObj.data.outch2OnOff;
								var outch3OnOff = alertMsgObj.data.outch3OnOff;
								//var SerialNo =  alertMsgObj.data.SerialNo;
								var gatewayKey = alertMsgObj.data.GatewayKey;
								//var id = alertMsgObj.data.id;

								var gatewayKeyPosition = document.getElementsByName('gatewayKey');
								var gatewayKeyInput;

								for(var i=0; i < gatewayKeyPosition.length; i++){
									if(gatewayKeyPosition[i].value == gatewayKey) gatewayKeyInput = gatewayKeyPosition[i];
								}

								var outch1Td = gatewayKeyInput.parentNode.cells[7];
								var outch2Td = gatewayKeyInput.parentNode.cells[8];
								var outch3Td = gatewayKeyInput.parentNode.cells[9];

								if(outch1Td.classList.contains( 'outch' )){
									if(outch1OnOff == 1) {
										outch1Td.style.backgroundColor  = "#e57b80";
										outch1Td.dataset.onoff = 1;
									}
									else{
										outch1Td.style.backgroundColor  = "#76bc57";
										outch1Td.dataset.onoff = 2;
									}
								}

								if(outch2Td.classList.contains( 'outch' )){
									if(outch2OnOff == 1) {
										outch2Td.style.backgroundColor  = "#e57b80";
										outch2Td.dataset.onoff = 1;
									}
									else{
										outch2Td.style.backgroundColor  = "#76bc57";
										outch2Td.dataset.onoff = 2;
									}
								}

								if(outch3Td.classList.contains( 'outch' )){
									if(outch3OnOff == 1) {
										outch3Td.style.backgroundColor  = "#e57b80";
										outch3Td.dataset.onoff = 1;
									}
									else{
										outch3Td.style.backgroundColor  = "#76bc57";
										outch3Td.dataset.onoff = 2;
									}
								}
							}

							return;
						}
						
						if(alertMsgObj.time == 'realTime2'){
							if('<?=$basename?>' == 'deviceMornView.php'){
								$.ajax({
									url : "/device/deviceAjaxProc.php",
									type : "post",
									data : {
										'mode' : 'getMornDevice_n',
										'SerialNo' : alertMsgObj.data.SerialNo
									},
									success : function(data){
										returnData = $.parseJSON(data);
										
										returnDataArr = returnData['data'];
										$("#gwList").html(returnData['html']);
									}
								});
							}

							else if('<?=$basename?>' == 'deviceConfView.php'){
								$.ajax({
									url : "/device/deviceAjaxProc.php",
									type : "post",
									data : {
										'mode' : 'getGWDevice',
										'SerialNo' : alertMsgObj.data.SerialNo
									},
									success : function(data){
										//console.log(data);
										$("#gwList").html(data);
									}
								});
							}

							return;
						}
						
						if(alertMsgObj.time == 'realTime') {
							if('<?=$basename?>' == 'deviceMornView.php'){
								var gatewayKey = alertMsgObj.data.GatewayKey;
								
								var outch = [];
								outch.push(alertMsgObj.data.outch1);
								outch.push(alertMsgObj.data.outch2);
								outch.push(alertMsgObj.data.outch3);
								
								var inch = [];
								inch.push(alertMsgObj.data.inch1);
								inch.push(alertMsgObj.data.inch2);
								inch.push(alertMsgObj.data.inch3);
								inch.push(alertMsgObj.data.inch4);
								inch.push(alertMsgObj.data.inch5);
								inch.push(alertMsgObj.data.inch6);

								var temperature = alertMsgObj.data.temperature;;
								var gas = alertMsgObj.data.gas;
								var humidity = alertMsgObj.data.humidity;

								var gatewayKeyPosition = document.getElementsByName('gatewayKey');
								var gatewayKeyInput;

								for(var i=0; i < gatewayKeyPosition.length; i++){
									if(gatewayKeyPosition[i].value == gatewayKey) gatewayKeyInput = gatewayKeyPosition[i];
								}
								
								var inTd = [];
								for(var i=1; i<7; i++){
									inTd.push(gatewayKeyInput.parentNode.cells[i]);
								}
								
								var outTd = [];
								for(var i=7; i<10; i++){
									outTd.push(gatewayKeyInput.parentNode.cells[i]);
								}

								var temTd = gatewayKeyInput.parentNode.cells[10];
								var huTd = gatewayKeyInput.parentNode.cells[11];
								var gasTd = gatewayKeyInput.parentNode.cells[12];

								for(var i=0; i<6; i++){
									if(inTd[i].classList.contains('text-truncate') ){
										if(inch[i] == 1) {	//정상 채널
											inTd[i].style.backgroundColor = '#76bc57';
										}
										else {	//비정상 채널
											inTd[i].style.backgroundColor = '#e57b80';
										}
									}
								}

								if(temTd.classList.contains('text-truncate')){
									temTd.innerHTML = temperature + "°C";
								}

								if(huTd.classList.contains('text-truncate')){
									huTd.innerHTML = humidity + "%";
								}

								if(gasTd.classList.contains('text-truncate')){
									gasTd.innerHTML = gas + "%";
								}
							}

							return;
						}
						
						if(alertMsgObj.data != ""){
							alert(alertMsgObj.data);
						}
					}
				});

				socket.on('error', function(error) {
				  console.log(error);
				});
				
				socket.on('pong', function(data) {
					console.log('Receive "pong"');
				 });

				socket.on('reconnect_attempt', function() {
				  socket.io.opts.transports = ['polling', 'websocket'];
				});

				var logoutMinute = 29;
				setInterval(function() {

					if(logoutMinute == 0){
						timeLogout();
					}else{
						if(logoutMinute > 0){
							logoutMinute--;
						}
					}

					$( 'body' ).click(function(){
						lockMinute = 29;
					});
				}, 1000 * 60 * 30);
			}
			*/
		</script>
	</body>
</html>
