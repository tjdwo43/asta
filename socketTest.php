<!DOCTYPE html>
<html lang="kr">
<body>
<button id="btnTest">TEST BTN
</button>

<script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
<script type="text/javascript">

		console.log('2');

		var socket =  io.connect('http://dev.sh-system.co.kr:3000');
		socket.on('connect', function(){
			console.log('3');

			socket.emit('adduser', 'tester', '0000001');

		});

		
		socket.on('disconnect', function(reason)  {
			console.log(reason);
			socket.connect();
		});

		socket.on('updatechat', function(username, data) {
			console.log('4');
			console.log(username);
			console.log(data);

		
		});

		socket.on('error', function(error) {
		  console.log(error);
		});
		
</script>
</body>
</html>
