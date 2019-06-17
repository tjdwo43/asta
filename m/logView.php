<?
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
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
    <div class="row pl-3 pr-3 m-0">
        <div class="min-320 w-48">
            <div class="form-group mb-0">
                <div class="calendar-div input-group date" id="sDate" data-target-input="nearest">
                    <input type="text" id="input-sDate" class="form-control datetimepicker-input" data-target="#sDate" value="2019-06-14"/>
                    <div class="input-group-append" data-target="#sDate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa-calendar-alt fas"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <span style="text-align: center" class="min-320">~</span>
        <div class="min-320 w-48">
            <div class="form-group mb-0">
                <div class="calendar-div input-group date" id="eDate" data-target-input="nearest">
                    <input type="text" id="input-eDate" class="form-control datetimepicker-input" data-target="#eDate" value="2019-06-14"/>
                    <div class="input-group-append" data-target="#eDate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa-calendar-alt fas"></i></div>
                    </div>
                </div>
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
                <th>구분</th>
                <th>내용</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</section>


<script>
    $(function () {
        $('#sDate').datetimepicker({
            format: 'YYYY-MM-DD',
            extraFormats: [ 'YYYY-MM-DD', 'YY-MM-DD' ]
        });
        $('#eDate').datetimepicker({
            format: 'YYYY-MM-DD',
            extraFormats: [ 'YYYY-MM-DD', 'YY-MM-DD' ],
            useCurrent: false
        });
        // $("#sDate").on("change.datetimepicker", function (e) {
        //     $('#eDate').datetimepicker('minDate', e.date);
        //     $('#eDate').datetimepicker("show");
        // });
        // $("#eDate").on("change.datetimepicker", function (e) {
        //     $('#sDate').datetimepicker('maxDate', e.date);
        // });
    });
</script>

<? include $_SERVER["DOCUMENT_ROOT"]."/m/bottom.php"; ?>