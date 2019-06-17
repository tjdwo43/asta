<?
include $_SERVER[DOCUMENT_ROOT] . "/inc/header.php";

include_once $_SERVER['DOCUMENT_ROOT']."/building/building.php";

$orgCode = $_SESSION["user_orgCode"];
if ($_SESSION["user_auth"] == 4) {
    $orgCode = '';
}

$postData = Array(
    'auth' => $_SESSION["user_auth"],
    'seq' => $_SESSION['user_seq']
);

$getBuildingList = buildingList($postData);
?>
    <section class="section-container">
        <input type="hidden" id="param-orgCode">
        <!-- Page content-->
        <div class="row mt-n2">
            <div class="col-10 searchArea">
                <h3 class="d-inline-block mr-5 contentTitle">검색 조건 설정</h3>
                <div class="d-inline-block dateInputWarp">
                    <div class="input-group">
                        <div class="calendar-div input-group date" id="sDate" data-target-input="nearest">
                            <input type="text" id="input-sDate" class="form-control datetimepicker-input" data-target="#sDate" value="<?=$today?>"/>
                            <div class="input-group-append" data-target="#sDate" data-toggle="datetimepicker">
                                <div class="input-group-text"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-inline-block pl-1 pr-1">~</div>
                <div class="d-inline-block dateInputWarp">
                    <div class="input-group">
                        <div class="calendar-div input-group date" id="eDate" data-target-input="nearest">
                            <input type="text" id="input-eDate" class="form-control datetimepicker-input" data-target="#eDate" value="<?=$today?>"/>
                            <div class="input-group-append" data-target="#eDate" data-toggle="datetimepicker">
                                <div class="input-group-text"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-inline-block searchRangeBtn ml-3">
                    <button class="btn btn-secondary btn-xs" type="button" data-type="today">오늘</button>
                    <button class="btn btn-secondary btn-xs" type="button" data-type="three">3일</button>
                    <button class="btn btn-secondary btn-xs" type="button" data-type="week">1주</button>
                    <button class="btn btn-secondary btn-xs" type="button" data-type="month">1개월</button>
                </div>
                <div class="d-inline-block ml-4 searchResult">
                    검색내용
                    <input class="form-control d-inline ml-1 text-left" type="text" id="message">
                </div>
            </div>
            <div class="col-2 text-right optBtnArea">
                <button class="btn btn-info btn-xs" type="button" onclick="getLogView();">조회</button>
                <button class="btn btn-green btn-xs" type="button" onclick="exportTableToCsv('log-table', 'logList');">엑셀저장</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-1 pt-3">
                <button class="btn btn-secondary w-100 ml-0" type="button" onclick="selectBIdg();">건물선택</button>
            </div>
            <div class="col-xl-10">
                <div class="filterChkWrap ml-0">
                    <div class="checkbox c-checkbox d-inline-block">
                        <label class="mb-0">
                            <input type="checkbox" checked="" name="checkAll"><span class="fa fa-check"></span> 전체
                        </label>
                    </div>
                    <div class="checkbox c-checkbox d-inline-block">
                        <label class="mb-0">
                            <input type="checkbox" checked="" name="checkOne" value="1"><span
                                    class="fa fa-check"></span> 경보
                        </label>
                    </div>
                    <div class="checkbox c-checkbox d-inline-block">
                        <label class="mb-0">
                            <input type="checkbox" checked="" name="checkOne" value="2"><span
                                    class="fa fa-check"></span> 상태
                        </label>
                    </div>
                    <div class="checkbox c-checkbox d-inline-block">
                        <label class="mb-0">
                            <input type="checkbox" checked="" name="checkOne" value="3"><span
                                    class="fa fa-check"></span> 제어
                        </label>
                    </div>
                    <div class="checkbox c-checkbox d-inline-block">
                        <label class="mb-0">
                            <input type="checkbox" checked="" name="checkOne" value="4"><span
                                    class="fa fa-check"></span> 온도
                        </label>
                    </div>
                    <div class="checkbox c-checkbox d-inline-block">
                        <label class="mb-0">
                            <input type="checkbox" checked="" name="checkOne" value="5"><span
                                    class="fa fa-check"></span> 습도
                        </label>
                    </div>
                    <div class="checkbox c-checkbox d-inline-block">
                        <label class="mb-0">
                            <input type="checkbox" checked="" name="checkOne" value="6"><span
                                    class="fa fa-check"></span> 가스
                        </label>
                    </div>
                    <div class="checkbox c-checkbox d-inline-block">
                        <label class="mb-0">
                            <input type="checkbox" checked="" name="checkOne" value="7"><span
                                    class="fa fa-check"></span> 기타
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <!-- S:list -->
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="table-responsive bg-white logTableWarp">
                    <table id="log-table" class="table text-center mb-0">
                        <colgroup>
                            <col id="bldgCol" width="210px"/>
                            <col width="180px"/>
                            <col width="200px"/>
                            <col width="*"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th id="bldgTH" class="text-left listSortBtn" onclick="sortTable(0, 'log-table')">건물명<i class="fas fa-sort-down"></i></th>
                            <th class="text-left listSortBtn" onclick="sortTable(1, 'log-table')">날짜 및 시간 <i class="fas fa-sort-down"></i></th>
                            <th class="listSortBtn" onclick="sortTable(2, 'log-table')">구분 <i class="fas fa-sort-down"></i></th>
                            <th class="text-left">내용</th>
                        </tr>
                        </thead>
                        <tbody id="log-tbody">
<!--                        <tr>-->
<!--                            <td class="text-left">2019.03.01 13:40:52</td>-->
<!--                            <td>경보</td>-->
<!--                            <td class="text-left">기계실-누수1 발생함</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td class="text-left">2019.03.02 13:41:02</td>-->
<!--                            <td>경보</td>-->
<!--                            <td class="text-left">기계실-누수1발생 확인함 (확인자:홍길동)</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td class="text-left">2019.03.02 14:10:26</td>-->
<!--                            <td>경보</td>-->
<!--                            <td class="text-left">기계실-누수1 해제됨</td>-->
<!--                        </tr>-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- PageContent End -->
    </section>
    </div>
    <div class="modal" id="selectBldg" style="display:none" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-sm">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" name="user-modal-title">건물선택</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="userRegistFrm" class="form-horizontal" action="#" data-parsley-validate="" novalidate="">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="sel-modal-bidg">
                            <div>
                                <div class="checkbox c-checkbox d-inline-block">
                                    <label class="mb-0">
                                        <input type="checkbox" name="checkAll2">
                                        <span class="fa fa-check"></span>
                                    </label>
                                    전체
                                </div>
                            </div>
                            <?foreach($getBuildingList['data'] as $k => $datum){?>
                                <div>
                                    <div class="checkbox c-checkbox d-inline-block">
                                        <label class="mb-0">
                                            <input type="checkbox" name="checkOne2" value="<?=$datum['org_code']."_".$datum['org_name']?>">
                                            <span class="fa fa-check"></span>
                                        </label>
                                        <?=$datum['org_name']?>
                                    </div>
                                </div>
                            <?}?>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-xs" onclick="saveModalOrgcode()">선택</button>
                        <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">취소</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <button id="MOVE_TOP_BTN"><em class="fa-2x fas fa-angle-up"></em></button>

    <script type="text/javascript">
        $(document).ready(function () {
            logBIdgCheck();

            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('#MOVE_TOP_BTN').fadeIn();
                } else {
                    $('#MOVE_TOP_BTN').fadeOut();
                }
            });

            $("#MOVE_TOP_BTN").click(function () {
                $('html, body').animate({
                    scrollTop: 0
                }, 400);
                return false;
            });

            $(".listSortBtn").click(function() {
                $(this).find("i").toggleClass("fa-sort-up fa-sort-down");
            });

            $("[name=checkAll]").click(function () {	//체크 박스 전체 선택
                allCheckFunc(this);
            });

            $("[name=checkOne]").each(function () {	//체크 박스 하나 선택
                $(this).click(function () {
                    oneCheckFunc($(this));
                });
            });

            $("[name=checkAll2]").click(function () {	//체크 박스 전체 선택
                allCheckFunc2(this);
            });

            $("[name=checkOne2]").each(function () {	//체크 박스 하나 선택
                $(this).click(function () {
                    oneCheckFunc2($(this));
                });
            });

            // 모달 날짜 선택
            $('#sDate').datetimepicker({
                format: 'YYYY-MM-DD',
                extraFormats: [ 'YYYY-MM-DD', 'YY-MM-DD' ]
            });
            $('#eDate').datetimepicker({
                format: 'YYYY-MM-DD',
                extraFormats: [ 'YYYY-MM-DD', 'YY-MM-DD' ],
                useCurrent: false
            });

            $(".searchRangeBtn button").click(function () {
                var type = $(this).data("type");
                var thisYear = new Date().getFullYear();
                var thisMonth = zeroAddFunc(new Date().getMonth() + 1);
                var thisDay = zeroAddFunc(new Date().getDate());

                switch (type) {
                    case "today":
                        $("#input-sDate").val(thisYear + "-" + thisMonth + "-" + thisDay);
                        $("#input-eDate").val(thisYear + "-" + thisMonth + "-" + thisDay);
                        break;
                    case "three":
                        $("#input-sDate").val(dateMinus(3));
                        $("#input-eDate").val(thisYear + "-" + thisMonth + "-" + thisDay);
                        break;
                    case "week":
                        $("#input-sDate").val(dateMinus(7));
                        $("#input-eDate").val(thisYear + "-" + thisMonth + "-" + thisDay);
                        break;
                    case "month":
                        $("#input-sDate").val(dateMinus(30));
                        $("#input-eDate").val(thisYear + "-" + thisMonth + "-" + thisDay);
                        break;
                }
            });

            $($(".searchRangeBtn button")[0]).trigger("click");

            getLogView();

        });

        function zeroAddFunc(n) {
            var zero = '';
            n = n.toString();

            if (n.length < 2) {
                for (var i = 0; i < 2 - n.length; i++)
                    zero += '0';
            }
            return zero + n;
        }

        function dateMinus(days) {
            var today = new Date();
            today.setDate(today.getDate() - days);
            var yy = today.getFullYear();
            var mm = today.getMonth() + 1;
            var dd = today.getDate();

            if (mm < 10) mm = "0" + mm;
            if (dd < 10) dd = "0" + dd;
            return yy + "-" + mm + "-" + dd;
        }

        function exportTableToCsv(tableId, filename) {
            if (filename == null || typeof filename == undefined)
                filename = tableId;
            filename += ".csv";

            var BOM = "\uFEFF";

            var table = document.getElementById(tableId);
            var csvString = BOM;
            for (var rowCnt = 0; rowCnt < table.rows.length; rowCnt++) {
                if(rowCnt == 0){
                    csvString = csvString + '"건물명", 날짜 및 시간, 구분, 내용"'+ "\r\n"
                    continue;
                }

                var rowData = table.rows[rowCnt].cells;
                for (var colCnt = 0; colCnt < rowData.length; colCnt++) {
                    var columnData = rowData[colCnt].innerHTML;
                    if (columnData == null || columnData.length == 0) {
                        columnData = "".replace(/"/g, '""');
                    }
                    else {
                        columnData = columnData.toString().replace(/"/g, '""'); // escape double quotes
                    }
                    csvString = csvString + '"' + columnData + '",';
                }
                csvString = csvString.substring(0, csvString.length - 1);
                csvString = csvString + "\r\n";
            }

            csvString = csvString.substring(0, csvString.length - 1);

            // IE 10, 11, Edge Run
            if (window.navigator && window.navigator.msSaveOrOpenBlob) {

                var blob = new Blob([decodeURIComponent(csvString)], {
                    type: 'text/csv;charset=utf8'
                });

                window.navigator.msSaveOrOpenBlob(blob, filename);

            } else if (window.Blob && window.URL) {
                // HTML5 Blob
                var blob = new Blob([csvString], { type: 'text/csv;charset=utf8' });
                var csvUrl = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.setAttribute('style', 'display:none');
                a.setAttribute('href', csvUrl);
                a.setAttribute('download', filename);
                document.body.appendChild(a);

                a.click()
                a.remove();
            } else {
                // Data URI
                var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csvString);
                var blob = new Blob([csvString], { type: 'text/csv;charset=utf8' });
                var csvUrl = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.setAttribute('style', 'display:none');
                a.setAttribute('target', '_blank');
                a.setAttribute('href', csvData);
                a.setAttribute('download', filename);
                document.body.appendChild(a);
                a.click()
                a.remove();
            }
        }
    </script>
<? include $_SERVER[DOCUMENT_ROOT] . "/inc/footer.php"; ?>
