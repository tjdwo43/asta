<?
	include_once $_SERVER_["DOCUMENT_ROOT"]."/inc/fnc.php";

	function getDeviceList($data){
		$url = "/ASTA-API/api/device/getDeviceList";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function regDevice($data){
		$url = "/ASTA-API/api/device/registDevice";
		$apiResult = callRestApi($data, $url);
		
		return $apiResult;
	}

	function delDevice($data){
		$url = "/ASTA-API/api/device/deleteDevice";
		$apiResult = callRestApi($data, $url);
		
		return $apiResult;
	}

	function updateDevice($data){
		$url ="/ASTA-API/api/device/updateDevice";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function getGWDevice($data){
		$url = "/ASTA-API/api/gateway/getList";
		$apiResult = callRestApi($data, $url);
		
		return $apiResult;
	}

	function updateGWDevice($data){
		$url = "/ASTA-API/api/gateway/updateGWMain";
		$apiResult = callRestApi($data, $url);
		
		return $apiResult;
	}

	function updateOutch($data){
		$url = "/ASTA-API/api/gateway/updateGWDetail";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function updateGWTS($data){
		$url = "/ASTA-API/api/gateway/updateGWTS";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function allDeleteGW($data) { //Gateway 일괄 삭제
		$url = "/ASTA-API/api/gateway/deleteGW";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

?>