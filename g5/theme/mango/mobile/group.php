<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!$is_admin && $group['gr_device'] == 'pc')
    alert($group['gr_subject'].' 그룹은 PC에서만 접근할 수 있습니다.');

include_once(G5_THEME_MOBILE_PATH.'/head.php');
?>

<?php

/* 최신글을 노출시킬 페이지 */

 

echo latest_group("theme/basic", "a", 출력갯수, 글자수); 

?>

<?php
include_once(G5_THEME_MOBILE_PATH.'/tail.php');
?>
