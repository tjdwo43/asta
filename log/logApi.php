<?
include $_SERVER['DOCUMENT_ROOT'] . "/inc/fnc.php";

function getHistoryList($data)
{        //로그 가져오기
    $url = "/ASTA-API/api/history/getHistoryList";
    $apiResult = callRestApi($data, $url);

    return $apiResult;
}

function writeAlarmLog($data)   //로그 저장
{
    $url = "/ASTA-API/api/history/confirmHistory";
    $apiResult = callRestApi($data, $url);

    return $apiResult;
}

function getChHistoryList($data){
    $url = "/ASTA-API/api/history/getChHistoryList";
    $apiResult = callRestApi($data, $url);

    return $apiResult;
}

function getLogList($data){
    $url = "/ASTA-API/api/history/getLogList";
    $apiResult = callRestApi($data, $url);

    return $apiResult;
}

function getMobileLogList($data){
    $url = "/ASTA-API/api/history/getLogListMobile";
    $apiResult = callRestApi($data, $url);

    return $apiResult;
}

function getOneLogList($data){
    $url = "/ASTA-API/api/history/getChHistoryList";
    $apiResult = callRestApi($data, $url);

    return $apiResult;
}
?>

