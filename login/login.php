<?
	function loginProc($data = Array()){
		// POST the data to an api
		$url = '/ASTA-API/api/user/login';
		
		//ASTA-API/api 호출
		$apiResult = callRestApi($data, $url);
		
		return $apiResult;
	}

	function logoutProc($data = Array()){
		$url = "/ASTA-API/api/user/logOut";

		$apiResult = callRestApi($data, $url);

		$result = $apiResult;
		
		return $result;
	}
	
?>