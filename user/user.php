<?
	function getListUser($data){
		$url = "/ASTA-API/api/user/getUserList";
		$apiResult = callRestApi($data, $url);
		
		return $apiResult;
	}

	function registerUser($data){
		$url = "/ASTA-API/api/user/join";
		$apiResult = callRestApi($data, $url);
		
		return $apiResult;
	}
	
	function delUser($data){
		$url = "/ASTA-API/api/user/deleteUser";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function updateUser($data){
		$url = "/ASTA-API/api/user/updateUser";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}
?>