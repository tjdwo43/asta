<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include_once $_SERVER['DOCUMENT_ROOT']."/inc/fnc.php";
include_once $_SERVER['DOCUMENT_ROOT']."/building/building.php";

$mode = $_POST['mode'];

switch($mode) {
    case 'getBuildingList' :
        $orgCode = $_SESSION["user_orgCode"];
        if ($_SESSION["user_auth"] == 4) {
            $orgCode = '';
        }

        $postData = Array(
            'auth' => $_SESSION["user_auth"],
            'org_code' => $orgCode
        );

        $getBuildingList = buildingList($postData);

        //$getBuildingList["lastBuidingBIdg"] = $_SESSION['user_lastOrg'];
        $lastOrgCode = ($_SESSION['user_lastOrg'] == '') ? $_SESSION['user_orgCode']:$_SESSION['user_lastOrg'];

        if(!empty($getBuildingList['data'])){
            foreach($getBuildingList['data'] as $val){
                if($val['org_code'] == $lastOrgCode){
                    $getBuildingList['lastBuildingInfo'] = $val;
                }
            }
        }
        $buildingListJson = json_encode($getBuildingList);

        echo $buildingListJson;
        break;
    case 'setLastBidg' :
        $_SESSION['user_lastOrg'] = $_POST['org_code'];

        $postData = Array(
            'seq' => $_SESSION['user_seq'],
            'org_code' => $_POST['org_code']
        );

        $buildingLastIdg = setBuildingBIdg($postData);

        echo json_encode($buildingLastIdg);

        break;
}
?>