<?
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php";

include_once $_SERVER['DOCUMENT_ROOT']."/building/asidebar.php"

?>

<section class="section-container buildingMangement">
    <!-- Page content-->
    <div class="row">
        <div class="col-xl-12">
            <div class="row mt-n2">
                <div class="col-xl-6">
                    <h3 class="d-inline-block mr-4 contentTitle">건물 상세정보</h3>
                </div>
                <?if($_SESSION['user_auth'] == '4'){?>
                    <div class="col-xl-6 text-right optBtnArea">
                        <button class="btn btn-info btn-xs" type="button" id="regist">등록</button>
                        <button class="btn btn-info btn-xs" type="button" id="modify" onclick="modifyBidg();">수정</button>
                        <button class="btn btn-danger btn-xs" type="button" onclick="showDeleteModal();">삭제</button>
                    </div>
                <?}?>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-xl-12">
            <div class="card card-default card-demo mb-0">
                <div class="card-wrapper">
                    <div class="card-body card_content">
                        <div class="table-responsive table-bordered tableHeader">
                            <table class="table text-center">
                                <colgroup>
                                    <col width="50px" />
                                    <col width="50px" />
                                    <col width="180px" />
                                    <col width="*" />
                                    <col span="2" width="120px" />
                                    <col width="90px" />
                                    <col width="120px" />
                                    <col span="7" width="90px" />
                                </colgroup>
                                <thead>
                                <tr>
                                    <th class="listSortBtn" onclick="sortTable(0, 'bIdg_table')">No <i class="fas fa-sort-up"></i></th>
                                    <th></th>
                                    <th class="listSortBtn" onclick="sortTable(2, 'bIdg_table')">건물명 <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(3, 'bIdg_table')">주소 <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(4, 'bIdg_table')">계약시작일 <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(5, 'bIdg_table')">계약종료일 <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(6, 'bIdg_table')">층수 <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(7, 'bIdg_table')">연면적(m<sup>2</sup>) <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(8, 'bIdg_table')">경보 <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(9, 'bIdg_table')">상태 <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(10, 'bIdg_table')">제어 <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(11, 'bIdg_table')">온도 <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(12, 'bIdg_table')">습도 <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(13, 'bIdg_table')">가스 <i class="fas fa-sort-up"></i></th>
                                    <th class="listSortBtn" onclick="sortTable(14, 'bIdg_table')">합계 <i class="fas fa-sort-up"></i></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="table-responsive table-bordered tableContent">
                            <table id="bIdg_table" class="table text-center">
                                <colgroup>
                                    <col width="50px" />
                                    <col width="50px"/>
                                    <col width="180px" />
                                    <col width="*" />
                                    <col span="2" width="120px" />
                                    <col width="90px" />
                                    <col width="120px" />
                                    <col span="7" width="90px" />
                                </colgroup>
                                <thead class="d-none">
                                <tr>
                                    <th class="listSortBtn" onclick="sortTable(0, 'bIdg_table')">No <i class="fas fa-sort-up"></i></th>
                                    <th></th>
                                    <th>건물명</th>
                                    <th>주소</th>
                                    <th>계약시작일</th>
                                    <th>계약종료일</th>
                                    <th>층수</th>
                                    <th>연면적(m<sup>2</sup>)</th>
                                    <th>경보</th>
                                    <th>상태</th>
                                    <th>제어</th>
                                    <th>온도</th>
                                    <th>습도</th>
                                    <th>가스</th>
                                    <th>합계</th>
                                </tr>
                                </thead>
                                <tbody id="building_tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PageContent End -->
</section>
</div>
<div class="modal buildingRegist" id="buildingRegist" style="display:none" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">건물 등록</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form class="form-horizontal">
                    <input type="hidden" id="modal-orgCode">
                    <input type="hidden" id="modal-mode">
                    <div class="form-group row essential">
                        <label class="col-xl-4 col-form-label">건물명</label>
                        <div class="col-xl-8">
                            <div class="row">
                                <div class="col-8 pr-0">
                                    <input class="form-control input-sm" type="text" name="buildingName" required="required" onkeyup="initDuplicateFeild(this.value)">
                                    <input type="hidden" name="bIdgCheck" value="1">
                                    <input type="hidden" name="duplicateName">
                                </div>
                                <div class="col-4 pl-0 pr-0">
                                    <button type="button" class="btn btn-info btn-xs letter-n-1 ml-3" id="duplicateBtn" onclick="duplicateBIdgCheck()">중복확인</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-4 col-form-label" style="text-indent:6px;">주소</label>
                        <div class="col-xl-8">
                            <input class="form-control input-sm mb-1" type="text" name="addr1">
                            <input class="form-control input-sm" type="text" name="addr2">
                        </div>
                    </div>
                    <div class="form-group row essential mt-2">
                        <label class="col-xl-4 col-form-label">계약기간</label>
                        <div class="col-xl-8">
                            <div class="d-inline-block dateInputWarp">
                                <div class="input-group">
                                    <div class="calendar-div input-group date" id="sDate" data-target-input="nearest">
                                        <input type="text" id="input-sDate" class="form-control datetimepicker-input" data-target="#sDate"/>
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
                                        <input type="text" id="input-eDate" class="form-control datetimepicker-input" data-target="#eDate"/>
                                        <div class="input-group-append" data-target="#eDate" data-toggle="datetimepicker">
                                            <div class="input-group-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="checkbox c-checkbox d-inline-block mt-1">
                                <label class="mb-0">
                                    <input type="checkbox" id="noneDate" required="required" onclick="checkNoExpire();">
                                    <span class="fa fa-check"></span>
                                    <em class="text-mediumGray">기간지정없음</em>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-1">
                        <label class="col-xl-4 col-form-label" style="text-indent:6px; padding-top : 13px;">층수</label>
                        <div class="col-xl-8">
                            <div class="form-group row mt-1 ml-0">
                                <label class="col-form-label"><div style="padding-top:5px;">지하</div></label>
                                <div class="col-xl-3 pl-1 pr-1">
                                    <input class="form-control input-sm" type="text" name="floorNum" required="required">
                                </div>
                                <label class="col-form-label"><div style="padding-top:5px;">층</div></label>
                                <label class="col-form-label"><div style="padding-top:5px;">&nbsp;~&nbsp;</div></label>
                                <label class="col-form-label"><div style="padding-top:5px;">지상</div></label>
                                <div class="col-xl-3 pl-1 pr-1">
                                    <input class="form-control input-sm" type="text" name="floorNum" required="required">
                                </div>
                                <label class="col-form-label"><div style="padding-top:5px;">층</div></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-1 floorSpaceArea">
                        <label class="col-xl-4 col-form-label" style="text-indent:6px;">연면적</label>
                        <div class="col-xl-8">
                            <div class="row">
                                <div class="col-xl-8">
                                    <input class="form-control input-sm" type="text" name="floorSpace" onkeyup="meterToP(this.value)" required="required"> m&sup2;
                                </div>
                                <div class="col-xl-4 text-right text-lightGray">
                                    <span class="spaceNumber"></span>
                                    <span class="spaceUnit">평</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <p class="guideText essential">필수입력항목</p>
                <button type="button" class="btn btn-info btn-xs" id="saveBtn" onclick="registBuilding();">등록</button>
                <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">취소</button>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        oneCheckFunc($('[name=checkOne]'));

        let config = fireStoreConf();

        $(".listSortBtn").click(function() {
            $(this).find("i").toggleClass("fa-sort-up fa-sort-down");
        });
        // 테이블 최대높이값 설정
        $(".tableContent").css("maxHeight", getHeight());

        $("#regist").click(function() {
            $('[name=buildingName]').parsley().reset();
            $('#sDate').parsley().reset();
            $('#eDate').parsley().reset();

            document.getElementsByClassName('modal-title')[0].innerHTML = "건물 등록"
            document.getElementById('saveBtn').innerHTML = "등록"
            document.getElementById("duplicateBtn").disabled = false

            let address1 = document.getElementsByName("addr1")[0];
            let address2 = document.getElementsByName("addr2")[0];
            let org_name = document.getElementsByName("buildingName")[0];
            let sDate = document.getElementById("input-sDate");
            let eDate = document.getElementById("input-eDate");
            let floor = document.getElementsByName("floorNum")[0];
            let floor2 = document.getElementsByName("floorNum")[1];
            let floorSpace = document.getElementsByName("floorSpace")[0];
            let noneDate = document.getElementById("noneDate");
            let org_code = document.getElementById("modal-orgCode");
            let mode = document.getElementById("modal-mode");

            address1.value = '';
            address2.value = '';
            org_name.value = '';
            sDate.value = '';
            eDate.value = '';
            floor.value = '';
            floor2.value = '';
            floorSpace.value = "";
            noneDate.checked = false;
            document.getElementsByClassName("spaceNumber")[0].innerHTML = ""

            $("#modal-mode").val("registBidg");
            $("#buildingRegist").modal({backdrop: 'static', keyboard: false});
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
        $("#sDate").on("change.datetimepicker", function (e) {
            $('#eDate').datetimepicker('minDate', e.date);
        });
        $("#eDate").on("change.datetimepicker", function (e) {
            $('#sDate').datetimepicker('maxDate', e.date);
        });

        getBuidlingListView(config);
    });

    function getHeight() {
        return window.innerHeight - document.querySelector(".tableContent").getBoundingClientRect().top - 20;
    }

</script>
<? include $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"?>
