<?
	include_once $_SERVER["DOCUMENT_ROOT"]."/inc/fnc.php";

	function loginProc($data = Array()){
		// POST the data to an api
		$url = '/ASTA-API/api/user/login';
		
		//API 호출
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