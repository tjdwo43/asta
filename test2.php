<?
$date = "2019-06-05";
$testD = strtotime($date);

$timestamp = strtotime($date + 1);

$testDt = $testD + $timestamp;

echo "현재로부터 1일 뒤 : ".data("Y-m-d", $timestamp)."<br/>";

?>