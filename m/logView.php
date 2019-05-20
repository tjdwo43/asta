<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
$today = date("Y-m-d");
?>
<!DOCTYPE HTML>

<html>
<head>
    <? include $_SERVER["DOCUMENT_ROOT"]."/m/head.php"?>
</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/m/mHeader.php"?>

<section class="logSearch">
    <div class="text-center">
        <div class="calendar-div d-inline-block">
            <div class="input-group date" >
                <input class="form-control" type="text" id="sDate" value="<?=$today?>">
                <span class="input-group-append input-group-addon">
                <span class="fa-calendar-alt fas input-group-text"></span>
             </span>
            </div>
        </div>
        ~
        <div class="calendar-div d-inline-block">
            <div class="input-group date">
                <input class="form-control" type="text" id="eDate" value="<?=$today?>">
                <span class="input-group-append input-group-addon">
                <span class="fa-calendar-alt fas input-group-text"></span>
             </span>
            </div>
        </div>
    </div>

    <div class="text-center p-3 searchBtn">
        <button class="btn btn-info" onclick="getMobileLog()">조회</button>
    </div>

</section>

<section class="logList">
    <table class="mTable">
        <colgroup>
            <col width="20%">
            <col width="30%">
            <col>
        </colgroup>
        <thead>
            <tr>
                <th>시간</th>
                <th>빌딩명</th>
                <th>상황</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</section>

<script src="/js/jquery.datetimepicker.js"></script><!-- datetimepicker -->
<script>
    $(function (){
        //기간설정
        $( '#sDate' ).datetimepicker({
            lang: 'ko',
            format:'Y-m-d',
            timepicker:false,
            onSelectDate: function () {
                $( '#sDate' ).datetimepicker("hide");
                $( '#eDate' ).datetimepicker("show");
            }
        });
        $( '#eDate' ).datetimepicker({
            lang: 'ko',
            format:'Y-m-d',
            formatDate:'Y-m-d',
            timepicker:false,
            closeOnDateSelect: true,
            onShow: function () {
                var sDate = $( '#sDate' ).val();
                this.setOptions({
                    minDate: sDate
                })
            }
        });
    })
</script>

<? include $_SERVER["DOCUMENT_ROOT"]."/m/bottom.php"; ?>