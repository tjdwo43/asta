<!DOCTYPE html>
<html lang="kr">
<body>
<button id="testBtn">Test111</button>
</body>
</html>
<script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>

<script type="text/javascript">
	var loginYN = document.getElementById("loginYN").value;
	var loginId = '<?=$_SESSION["user_id"]?>';
	var loginCode = '<?=$_SESSION["user_orgCode"]?>';

	if(loginYN == 1){
		var socket =  io.connect('http://dev.sh-system.co.kr:3000');
		socket.on('connect', function(){
			socket.emit('adduser', loginId, loginCode);
			socket.emit('ping', 1);
		});
		
		socket.on('disconnect', function(reason)  {
			console.log(reason);
			socket.connect();
		});

		socket.on('updatechat', function(username, data) {
			console.log(username);
			console.log(data);
			if(data != null && data.indexOf("{") == 0) {
				var alertMsgObj = JSON.parse(data);
					alert(alertMsgObj.data);
				
			}
		});

		socket.on('error', function(error) {
		  console.log(error);
		});
		
		socket.on('pong', function(data) {
			console.log('Receive "pong"');
		 });


</script>