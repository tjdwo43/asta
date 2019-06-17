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

    function rstBidg($data){
        $url = "/ASTA-API/api/user/registBdlg";
        $apiResult = callRestApi($data, $url);

        return $apiResult;
    }

    function updateBidg($data){
        $url = "/ASTA-API/api/user/updateBdlg";
        $apiResult = callRestApi($data, $url);

        return $apiResult;
    }

    function deleteBidg($data){
        $url = "/ASTA-API/api/user/deleteBdlg";
        $apiResult = callRestApi($data, $url);

        return $apiResult;
    }

    function duplicateBIdgName($data){
        $url = "/ASTA-API/api/user/dupBldgCheck";
        $apiResult = callRestApi($data, $url);

        return $apiResult;
    }
?>