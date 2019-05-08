<?
	function getTimeTemplate($data){
		$url = "/ASTA-API/api//TS/getTSList";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function getTimeWeekTemplate($data){
		$url = "/ASTA-API/api/wTS/getwTSList";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function updateTS($data){
		$url = "/ASTA-API/api/TS/updateTS";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function addTS($data){
		$url = "/ASTA-API/api/TS/registTS";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function delTS($data){
		$url = "/ASTA-API/api/TS/deleteTS";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function addWTS($data){
		$url = "/ASTA-API/api/wTS/registwTS";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function updateWTS($data){
		$url = "/ASTA-API/api/wTS/updatewTS";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}

	function delWTS($data){
		$url = "/ASTA-API/api/wTS/deletewTS";
		$apiResult = callRestApi($data, $url);

		return $apiResult;
	}
?>