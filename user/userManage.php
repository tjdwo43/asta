<?
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php";

include $_SERVER[DOCUMENT_ROOT] ."/user/asidebar.php";

$pattern = '/^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/';

?>
    <section class="section-container userMangement">
        <!-- Page content-->
        <div class="row">
            <div class="col-xl-12">
                <div class="row mt-n2">
                    <div class="col-6">
                        <h3 class="d-inline-block mr-4 contentTitle">사용자 상세정보</h3>
                    </div>
                    <div class="col-6 text-right optBtnArea">
                        <?if($_SESSION['user_auth'] > 2){?>
                        <button class="btn btn-info btn-xs" type="button" id="regist" >등록</button>
                        <button class="btn btn-info btn-xs" type="button" id="modify">수정</button>
                        <button class="btn btn-danger btn-xs" type="button" onclick="showDeleteModal()">삭제</button>
                        <?}?>
                        <button class="btn btn-green btn-xs" type="button" onclick="exportTableToCsv('user_table','userList')">엑셀저장</button>
                        <?if($_SESSION['user_auth'] > 2){?>
                        <button class="btn btn-green btn-xs" type="button" onclick="excelModal();">엑셀불러오기</button>
                        <?}?>
                    </div>
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
                                        <col width="45px" />
                                        <col width="200px" />
                                        <col span="3" width="140px" />
                                        <col width="170px" />
                                        <col width="120px" />
                                        <col width="*" />
                                    </colgroup>
                                    <thead>
                                    <tr>
                                        <th class="text-left listSortBtn" onclick="sortTable(0, 'user_table')">No <i class="fas fa-sort-up"></i></th>
                                        <th>
                                            <div class="checkbox c-checkbox d-inline-block">
                                                <label class="mb-0">
                                                    <input type="checkbox" name="userCheckAll"><span class="fa fa-check"></span>
                                                </label>
                                            </div>
                                        </th>
                                        <th class="text-left listSortBtn" onclick="sortTable(2, 'user_table')">대표 건물 명 <i class="fas fa-sort-up"></i></th>
                                        <th class="listSortBtn" onclick="sortTable(3, 'user_table')">이름 <i class="fas fa-sort-up"></i></th>
                                        <th class="listSortBtn" onclick="sortTable(4, 'user_table')">부서 <i class="fas fa-sort-up"></i></th>
                                        <th class="listSortBtn" onclick="sortTable(5, 'user_table')">직위 <i class="fas fa-sort-up"></i></th>
                                        <th class="listSortBtn" onclick="sortTable(6, 'user_table')">휴대폰 <i class="fas fa-sort-up"></i></th>
                                        <th class="listSortBtn" onclick="sortTable(7, 'user_table')">사용권한 <i class="fas fa-sort-up"></i></th>
                                        <th class="listSortBtn" onclick="sortTable(8, 'user_table')">비고 <i class="fas fa-sort-up"></i></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="table-responsive table-bordered tableContent">
                                <table id="user_table" class="table text-center">
                                    <colgroup>
                                        <col width="50px" />
                                        <col width="45px" />
                                        <col width="200px" />
                                        <col span="3" width="140px" />
                                        <col width="170px" />
                                        <col width="120px" />
                                        <col width="*" />
                                    </colgroup>
                                    <thead class="d-none">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>대표 건물 명</th>
                                        <th>이름</th>
                                        <th>부서</th>
                                        <th>직위</th>
                                        <th>휴대폰</th>
                                        <th>사용권한</th>
                                        <th>비고</th>
                                    </tr>
                                    </thead>
                                    <tbody id="user_tbody"></tbody>
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

    <div class="modal userRegist" id="userRegist" style="display:none" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" name="user-modal-title">사용자 등록</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="userRegistFrm" class="form-horizontal" action="#" data-parsley-validate="" novalidate="">
                    <input type="hidden" id="modal-mode">
                    <input type="hidden" id="modal-duplicatePass" value="1">
                    <input type="hidden" name="modal-seq">
                    <input type="hidden" id="sessionAuth" value="<?=$_SESSION['user_auth']?>">
                    <input type="hidden" id="modal-pushId" >

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group row essential" name="div-userId">
                            <label class="col-4 col-form-label">아이디</label>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="form-control input-sm" type="text" name="userId" required="required" onkeydown="duCheckInit();">
                                    </div>
                                    <div class="col-4 pl-0 pr-0">
                                        <button type="button" class="btn btn-info btn-xs letter-n-1 ml-3" onclick="duplicateIdCheck()">중복확인</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row essential" name="div-currentPW">
                            <label class="col-4 col-form-label pr-0">현재 비밀번호</label>
                            <div class="col-8">
                                <input class="form-control input-sm" type="password" name="currentPW" required="required" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row essential">
                            <label class="col-4 col-form-label pr-0">신규 비밀번호</label>
                            <div class="col-8">
                                <input class="form-control input-sm" id="newPW" type="password" name="newPW" required="required" autocomplete="off" data-parsley-minlength="8"
                                pattern="<?=$pattern?>" data-parsley-pattern="<?=$pattern?>" placeholder="영문,숫자,특수문자 조합 8~15자" maxlength="15">
                            </div>
                        </div>
                        <div class="form-group row essential">
                            <label class="col-4 col-form-label pr-0">신규 비밀번호 확인</label>
                            <div class="col-8">
                                <input class="form-control input-sm" type="password" name="reEnterNewPW" required="required" data-parsley-equalto="#newPW" autocomplete="off"
                                       maxlength="15">
                            </div>
                        </div>
                        <div class="form-group row essential">
                            <label class="col-4 col-form-label pr-0">이름</label>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="form-control input-sm" type="text" name="userName" required="required" >
                                    </div>
                                    <div class="col-4 pl-1 text-center">
                                        <div class="checkbox c-checkbox d-inline-block mt-1">
                                            <label class="mb-0">
                                                <input type="checkbox" id="multiChk">
                                                <span class="fa fa-check"></span>
                                                <em class="text-mediumGray">다중</em>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row essential">
                            <label class="col-4 col-form-label pr-0">부서</label>
                            <div class="col-8">
                                <input class="form-control input-sm" type="text" name="department" required="required" >
                            </div>
                        </div>
                        <div class="form-group row essential">
                            <label class="col-4 col-form-label pr-0">직위</label>
                            <div class="col-8">
                                <input class="form-control input-sm" type="text" name="position" required="required" >
                            </div>
                        </div>
                        <div class="form-group row essential">
                            <label class="col-4 col-form-label pr-0">휴대폰</label>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-4">
                                        <select name="firstNumber" class="form-control input-sm pr-0" >
                                            <option value="010">010</option>
                                            <option value="011">011</option>
                                            <option value="016">016</option>
                                            <option value="017">017</option>
                                            <option value="017">018</option>
                                            <option value="019">019</option>
                                        </select>
<!--                                        <input class="form-control input-sm" type="text" name="firstNumber" required="required" data-parsley-type="number" data-parsley-length="[3, 3]">-->
                                    </div>
                                    <div class="col-4 phoneLine">
                                        <input class="form-control input-sm" type="text" name="middleNumber" required="required" data-parsley-type="number" data-parsley-length="[3, 4]" maxlength="4">
                                    </div>
                                    <div class="col-4">
                                        <input class="form-control input-sm" type="text" name="lastNumber" required="required" data-parsley-type="number" data-parsley-length="[3, 4]" maxlength="4">
                                    </div>
                                </div>
                                <ul id="phoneValidate" class="parsley-errors-list filled d-none"><li class="parsley-required">번호를 정확히 입력해주세요.</li></ul>
                            </div>
                        </div>
                        <div class="form-group row essential nameOfBelonging">
                            <label class="col-4 col-form-label pr-0">소속명</label>
                            <div class="col-8">
                                <select class="form-control input-sm" name="org_code">
                                    <?foreach($getBuildingList['data'] as $k => $datum){?>
                                        <option value="<?=$datum['org_code']?>"><?=$datum['org_name']?></option>
                                    <?}?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row essential">
                            <label class="col-4 col-form-label pr-0">권한</label>
                            <div class="col-8">
                                <select name="auth" class="form-control input-sm">
                                    <option value="3">관리자</option>
                                    <option value="2" checked>일반 사용자</option>
                                    <option value="1">디바이스</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label pr-0" style="text-indent:5px;">비고</label>
                            <div class="col-8">
                                <textarea name="comment" class="form-control input-sm" data-parsley-maxlength="300">
                                </textarea>
                            </div>
                        </div>
<!--                        <div class="form-group row">-->
<!--                            <label class="col-4 col-form-label" style="text-indent:5px;">다중 셀렉트</label>-->
<!--                            <div class="col-8">-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <p class="guideText essential">필수입력항목</p>
                        <button type="button" class="btn btn-info btn-xs" id="registBtn" onclick="regUser()">등록</button>
                        <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">취소</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal userRegist" id="excelUpload" style="display:none" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" name="user-modal-title">사용자 등록</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="excelUpload" class="form-horizontal" method="post" enctype="multipart/form-data" action="/user/user_excel.php">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="file" name="csv_file" class="form-control">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <p class="guideText essential">필수입력항목</p>
                        <button type="button" class="btn btn-info btn-xs" onclick="document.location.href='/user/regUserSample.csv'" >샘플 CSV</button>
                        <button type="submit" class="btn btn-info btn-xs">등록</button>
                        <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">취소</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        let bIdgList = '<?=json_encode($getBuildingList['data'])?>';
        let bIdgListJson = JSON.parse(bIdgList);

        $(document).ready(function() {
            $("[name=userCheckAll]").click(function () {	//체크 박스 전체 선택
                allCheckUser(this);
            });

            $(document).on("click", "[name=userCheck]", function () {
                oneCheckUser($(this));
            })

            $(document).on("click", "[name=org_codeAll]", function () {
                multiUserCheck($(this));
            })

            $(document).on("click", "[name=org_code]", function () {
                multiUserOne($(this));
            })


            $(".listSortBtn").click(function() {
                $(this).find("i").toggleClass("fa-sort-up fa-sort-down");
            });
            // 테이블 최대높이값 설정
            $(".tableContent").css("maxHeight", getHeight());

            $("#regist").click(function() {
                userValidateReset();

                let modalTitle = document.getElementsByName("user-modal-title")[0]
                let mode = document.getElementById("modal-mode");
                let regBtn = document.getElementById("registBtn");

                mode.value = "registerUser";
                modalTitle.innerHTML = "사용자 등록";
                regBtn.innerHTML = "등록"

                document.getElementsByName("div-currentPW")[0].classList.add("d-none");
                document.getElementsByName("div-userId")[0].classList.remove("d-none");

                document.getElementById("multiChk").checked = false;
                var singleSlt = '<select class="form-control input-sm" name="org_code">';
                for (var i = 0; i < userCharges.length; i++) {
                    singleSlt += '<option value="' + userCharges[i].org_code + '">' + userCharges[i].org_name + '</option>';
                }
                singleSlt += '</select>';
                //console.log(singleSlt)
                $(".nameOfBelonging > div").html(singleSlt);

                //============== 모달 초기화 ===========//
                userModalInit();
                //=====================================//

                $("#userRegist").modal({backdrop: 'static', keyboard: false});
            });

            $("#modify").click(function(){
                let mode = document.getElementById("modal-mode");
                let auth = document.getElementById("sessionAuth");

                let modalPass = document.getElementById("modal-duplicatePass");

                let regBtn = document.getElementById("registBtn");

                modalPass.value = 2;

                mode.value = "updateUser";

                regBtn.innerHTML = "수정"

                document.getElementsByName("div-userId")[0].classList.add("d-none");
                if(auth.value == "4"){
                    document.getElementsByName("div-currentPW")[0].classList.add("d-none");
                }else{
                    document.getElementsByName("div-currentPW")[0].classList.remove("d-none");
                }
                modifyUser();

            })
            //사용자 등록 - 다중 체크박스 이벤트
            // var userCharges = [{
            //     bdName: '가산 SK V1 Center',
            //     checkVal: 'checked',
            //     sltVal: 'selected'
            // }, {
            //     bdName: '문래 SK V1 Center',
            //     checkVal: 'checked',
            //     sltVal: ''
            // }, {
            //     bdName: '구리 SK V1 Center',
            //     checkVal: '',
            //     sltVal: ''
            // }]
            var userCharges = bIdgListJson
            $("#multiChk").change(function() {
                if ($(this).is(":checked")) {
                    var multiSlt = '<div class="dropDown multiSlt">';
                    multiSlt += '<input type="text" class="form-control input-sm pl-2 btn_drop" readonly value="" />';
                    multiSlt += '<div class="dropBox">';
                    multiSlt += '<ul class="list-unstyled mb-0">';

                    multiSlt += '<li>';
                    multiSlt += '    <div class="checkbox c-checkbox d-inline-block mt-1">';
                    multiSlt += '        <label class="mb-0">';
                    multiSlt += '        <input name="org_codeAll" type="checkbox">';
                    multiSlt += '        <span class="fa fa-check"></span>';
                    multiSlt += '        <em class="text-mediumGray">전체</em>';
                    multiSlt += '    </label>';
                    multiSlt += '    </div>';
                    multiSlt += '</li>';

                    for (var i = 0; i < userCharges.length; i++) {
                        multiSlt += '<li>';
                        multiSlt += '    <div class="checkbox c-checkbox d-inline-block mt-1">';
                        multiSlt += '        <label class="mb-0">';
                        multiSlt += '        <input name="org_code" type="checkbox" value="'+userCharges[i].org_code+'">';
                        multiSlt += '        <span class="fa fa-check"></span>';
                        multiSlt += '        <em class="text-mediumGray">' + userCharges[i].org_name + '</em>';
                        multiSlt += '    </label>';
                        multiSlt += '    </div>';
                        multiSlt += '</li>';
                    }

                    multiSlt += '</ul>';
                    multiSlt += '</div>';
                    multiSlt += '</div>';
                    $(".nameOfBelonging > div").html(multiSlt);
                    multiChkStatus();
                } else {
                    var singleSlt = '<select class="form-control input-sm" name="org_code">';
                    for (var i = 0; i < userCharges.length; i++) {
                        singleSlt += '<option value="' + userCharges[i].org_code + '">' + userCharges[i].org_name + '</option>';
                    }
                    singleSlt += '</select>';
                    //console.log(singleSlt)
                    $(".nameOfBelonging > div").html(singleSlt);
                }
            });
            multiChkStatus();

            $(document).on('change', '.dropBox input[type="checkbox"]', function() {
                multiChkStatus();
            });

            $(".modal-content").click(function(e){
                //console.log($(e.target).parents(".dropBox").length)
                if( $(e.target).parents(".dropBox").length == 0){
                    $(".dropBox").removeClass("on")
                }else{
                    $(this).next().addClass("on")
                }

                $(document).on('click', '.btn_drop', function(e) {
                    console.log($(this).next())
                    if($(this).next().hasClass("on")){
                        $(this).next().removeClass("on");
                    }else{
                        $(this).next().addClass("on")
                    }
                    multiChkStatus();
                });
            })

            // var chPass = getParameter("chPass");
            //
            // if(chPass == 1){
            //
            //     $("#multiChk").trigger("click")
            // }

        });

        function getHeight() {
            return window.innerHeight - document.querySelector(".tableContent").getBoundingClientRect().top - 20;
        }

        function exportTableToCsv(tableId, filename) {
            if (filename == null || typeof filename == undefined)
                filename = tableId;
            filename += ".csv";

            var BOM = "\uFEFF";

            var table = document.getElementById(tableId);
            var csvString = BOM;
            for (var rowCnt = 0; rowCnt < table.rows.length; rowCnt++) {
                var rowData = table.rows[rowCnt].cells;
                for (var colCnt = 0; colCnt < rowData.length; colCnt++) {
                    if(colCnt == 0 || colCnt == 1) continue;

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
            console.log(csvString)
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

                a.click();
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
                a.click();
                a.remove();
            }
        }
        //유저 UI 생성.//,,,.....

    </script>
<? include $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"?>