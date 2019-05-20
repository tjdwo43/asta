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

?>

