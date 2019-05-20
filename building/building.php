<?
    function buildingList($data){
        $url = "/ASTA-API/api/user/getBuildingList";
        $apiResult = callRestApi($data, $url);

        return $apiResult;
    }

    function setBuildingBIdg($data){
        $url = "/ASTA-API/api/user/setLastBldg";
        $apiResult = callRestApi($data, $url);

        return $apiResult;
    }
?>