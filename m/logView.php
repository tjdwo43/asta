<!DOCTYPE HTML>

<head>
    <? include $_SERVER["DOCUMENT_ROOT"]."/m/head.php"?>
</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/m/mHeader.php"?>

<section class="logSearch">

    <div class="text-center">
        <div class="calendar-div d-inline-block">
            <div class="input-group date" id="datetimepicker1">
                <input class="form-control" type="text">
                <span class="input-group-append input-group-addon">
                <span class="fa-calendar-alt fas input-group-text"></span>
             </span>
            </div>
        </div>
        ~
        <div class="calendar-div d-inline-block">
            <div class="input-group date" id="datetimepicker1">
                <input class="form-control" type="text">
                <span class="input-group-append input-group-addon">
                <span class="fa-calendar-alt fas input-group-text"></span>
             </span>
            </div>
        </div>
    </div>

    <div class="text-center p-3 searchBtn">
        <button class="btn btn-info">조회</button>
    </div>

</section>

<section class="logList">
    <table class="mTable">
        <colgroup>
            <col>
            <col>
            <col>
        </colgroup>
        <thead>
            <tr>
                <th>시간</th>
                <th>빌딩명</th>
                <th>상황</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>13:40:52</td>
                <td>가산 SK V1 Center</td>
                <td>기계실-누수1 발생함</td>
            </tr>
            <tr>
                <td>13:40:52</td>
                <td>가산 SK V1 Center</td>
                <td>기계실-누수1 발생함</td>
            </tr>
            <tr>
                <td>13:40:52</td>
                <td>가산 SK V1 Center</td>
                <td>기계실-누수1 확인함 (확인자:홍길동)</td>
            </tr>
            <tr>
                <td>13:40:52</td>
                <td>가산 SK V1 Center</td>
                <td>기계실-누수1 발생함</td>
            </tr>
        </tbody>
    </table>
</section>

</body>