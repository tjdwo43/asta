<?
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE HTML>

<html>
<head>
    <? include $_SERVER["DOCUMENT_ROOT"]."/m/head.php"?>
</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/m/mHeader.php"?>

<section class="userList">
    <table class="mTable">
        <colgroup>
            <col>
        </colgroup>
        <thead>
        <tr>
            <th></th>
            <th>이름</th>
            <th>직책</th>
            <th>연락처</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</section>

<script>
    userList()
</script>

<? include $_SERVER["DOCUMENT_ROOT"]."/m/bottom.php"; ?>
