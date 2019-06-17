<?

include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php";

?>
<section class="section-container buildManagement">
    <input type="hidden" id="tabCond" value="1">
    <input type="hidden" id="tabCond2" value="">
    <!-- Page content-->
    <!-- S:빌딩명, 설치위치 셀릭트 박스 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="row mt-n2">
                <div class="col-xl-8 buildingFilter">
                    <h3 class="d-inline-block mr-2 contentTitle">건물명</h3>
                    <div class="d-inline-block">
                        <select class="form-control" id="select-buildingName" onchange="org_deviceLocation(this.value);">
                            <?foreach($getBuildingList['data'] as $val){?>
                                <option value="<?=$val['org_code']?>"><?=$val['org_name']?></option>
                            <?}?>
                        </select>
                    </div>
                    <h3 class="d-inline-block ml-4 mr-2 contentTitle">설치위치</h3>
                    <div class="d-inline-block">
                        <select class="form-control" id="deviceLocation"></select>
                    </div>
                </div>
                <?if($_SESSION['user_auth'] == 4){?>
                    <div class="col-xl-4 text-right optBtnArea">
                        <button class="btn btn-info btn-xs" type="button" onclick="web_device_conf_search();">조회</button>
                        <button class="btn btn-info btn-xs" type="button" onclick="update_MainDevice();">수정</button>
                        <button class="btn btn-danger btn-xs" type="button" onclick="showDeleteModal();">삭제</button>
                        <button class="btn btn-green btn-xs" type="button" id="manuaRegistBtn">수동등록</button>
                    </div>
                <?}?>
            </div>
        </div>
    </div>
    <!-- E:빌딩명, 설치위치 셀릭트 박스 -->
    <div class="row mt-2">
        <div class="col-xl-12">
            <div class="card card-default card-demo mb-0 IO_controlArea">
                <div class="card-header">
                    <div class="card-title font-weight-middle font-middleGray">I/O Control Board</div>
                </div>
                <div class="card-wrapper">
                    <div class="card-body card_content p-0">
                        <div class="table-responsive table-bordered">
                            <table class="table text-center">
                                <colgroup>
                                    <col width="240px" />
                                    <col width="180px" />
                                    <col width="*" />
                                    <col width="180px" />
                                    <col width="140px" />
                                    <col width="120px" />
                                    <col width="80px" />
                                </colgroup>
                                <thead>
                                <tr>
                                    <th>건물명</th>
                                    <th>설치위치</th>
                                    <th>비고</th>
                                    <th>S/N</th>
                                    <th>MAC</th>
                                    <th>IP</th>
                                    <th>PORT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <input class="form-control" type="text" id="textbidgName" value="" />
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" id="textbidgLocation" value="" />
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" id="textbidgCmt" />
                                    </td>
                                    <td id="textBidgSN"></td>
                                    <td id="textMac"></td>
                                    <td id="textIP"></td>
                                    <td id="textPort"></td>
                                    <input type="hidden" id="textUseYN">
                                    <input type="hidden" id="textDeviceId">
                                    <input type="hidden" id="textDeviceOrgCode">
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3 GWconfig">
        <div class="col-xl-12">
            <div role="tabpanel">
                <!-- Nav tabs-->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#GW1" aria-controls="GW1" role="tab" data-index="1" data-toggle="tab" aria-selected="true">GW1</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW2" aria-controls="GW2" role="tab" data-index="2" data-toggle="tab">GW2</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW3" aria-controls="GW3" role="tab" data-index="3" data-toggle="tab">GW3</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW4" aria-controls="GW4" role="tab" data-index="4" data-toggle="tab">GW4</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW5" aria-controls="GW5" role="tab" data-index="5" data-toggle="tab">GW5</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW6" aria-controls="GW6" role="tab" data-index="6" data-toggle="tab">GW6</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW7" aria-controls="GW7" role="tab" data-index="7" data-toggle="tab">GW7</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW8" aria-controls="GW8" role="tab" data-index="8" data-toggle="tab">GW8</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW9" aria-controls="GW9" role="tab" data-index="9" data-toggle="tab">GW9</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW10" aria-controls="GW10" role="tab" data-index="10" data-toggle="tab">GW10</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW11" aria-controls="GW11" role="tab" data-index="11" data-toggle="tab">GW11</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW12" aria-controls="GW12" role="tab" data-index="12" data-toggle="tab">GW12</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW13" aria-controls="GW13" role="tab" data-index="13" data-toggle="tab">GW13</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW14" aria-controls="GW14" role="tab" data-index="14" data-toggle="tab">GW14</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW15" aria-controls="GW15" role="tab" data-index="15" data-toggle="tab">GW15</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#GW16" aria-controls="GW16" role="tab" data-index="16" data-toggle="tab">GW16</a></li>
                </ul>
                <!-- Tab panes-->
                <div class="tab-content bg-white">
                    <?
                        for($j=1; $j<17; $j++){
                        $GWLIST = "gw".$j;
                        $GWID = "GW".$j;

                        $active = ($j==1)?"active":'';
                    ?>
                        <div class="tab-pane <?=$active?>" id='<?=$GWID?>' role="tabpanel">
                        <div class="GWposition">
                            <h4 class="d-inline-block mr-2 contentTitle font-weight-bold">GW 설치위치</h4>
                            <div class="d-inline-block">
                                <input class="form-control changeYN <?=$GWLIST?>" type="text" name="" />
                            </div>
                            <div class="d-inline-block float-right onOffBtn">
                                <div class="form-group row mb-0">
                                    <div class="col-md-7 p-0">
                                        <div class="d-inline-block">
                                            <select class="form-control changeYN <?=$GWLIST?>" name="">
                                                <option value="1">사용</option>
                                                <option value="2">미사용</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 pr-0" style="padding-top:1px;">
                                        <button class="btn btn-info btn-xs w-100" type="button" name="gwSaveBtn" onclick="modifyGateway(<?=$j?>);">저장</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-dashed">
                        <div class="row GWconfig_panel">
                            <!-- S:입력 -->
                            <div class="col-xl-4 GWconfig_left">
                                <ul class="list-unstyled mb-0">

                                    <?for($i=1; $i<7; $i++){?>
                                        <li>
                                            <div class="d-inline-block GWconfig_label">
                                                <?= "입력".$i?>
                                            </div>
                                            <div class="d-inline-block GWconfig_slt">
                                                <select class="form-control changeYN <?=$GWLIST?>" name="">
                                                    <option value="1">경보</option>
                                                    <option value="2">상태</option>
                                                    <option value="0">미사용</option>
                                                </select>
                                            </div>
                                            <div class="d-inline-block GWconfig_input">
                                                <input class="form-control changeYN <?=$GWLIST?>" type="text" name="" />
                                            </div>
                                        </li>
                                    <?}?>
                                </ul>
                            </div>
                            <!--E:입력-->
                            <!--S:출력-->
                            <div class="col-xl-4 GWconfig_center">
                                <ul class="list-unstyled mb-0">
                                    <?for($k=1; $k<4; $k++){?>
                                        <li>
                                            <!--S:출력 Condition-->
                                            <div class="mb-2">
                                                <div class="d-inline-block GWconfig_label">
                                                    <?="출력".$k?>
                                                </div>
                                                <div class="d-inline-block GWconfig_slt">
                                                    <select class="form-control changeYN <?=$GWLIST?>" name="">
                                                        <option value="1">사용</option>
                                                        <option value="2">미사용</option>
                                                    </select>
                                                </div>
                                                <div class="d-inline-block GWconfig_input">
                                                    <input class="form-control changeYN <?=$GWLIST?>" type="text" name=""/>
                                                </div>
                                            </div>
                                            <!--E:출력 Condition -->
                                            <!--S:출력 피드백 -->
                                            <div>
                                                <div class="d-inline-block GWconfig_label">
                                                    Feedback
                                                </div>
                                                <div class="d-inline-block GWconfig_slt">
                                                    <select class="form-control changeYN <?=$GWLIST?>" name="">
                                                        <option value="2">사용</option>
                                                        <option value="1">미사용</option>
                                                    </select>
                                                </div>
                                                <div class="d-none">
                                                    <input class="form-control changeYN <?=$GWLIST?>" type="text" name="" />
                                                </div>
                                            </div>
                                            <!--E:출력 피드백 -->
                                        </li>
                                    <?}?>
                                </ul>
                            </div>
                            <!--E:출력-->
                            <!-- S:etc -->
                            <div class="col-xl-4 GWconfig_right">
                                <ul class="list-unstyled mb-0">
                                    <!-- S: 온도 -->
                                    <li>
                                        <div class="mb-2">
                                            <div class="d-inline-block GWconfig_label">
                                                온도(℃)
                                            </div>
                                            <div class="d-inline-block GWconfig_slt">
                                                <select class="form-control changeYN <?=$GWLIST?>" name="">
                                                    <option value="1">사용</option>
                                                    <option value="2">미사용</option>
                                                </select>
                                            </div>
                                            <div class="d-inline-block GWconfig_input">
                                                <input class="form-control changeYN <?=$GWLIST?>" type="text" name="" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-inline-block GWconfig_label">
                                                허용범위
                                            </div>
                                            <div class="d-inline-block GWconfig_tempRange">
                                                <input class="form-control changeYN <?=$GWLIST?>" type="text" name="" />
                                                <span class="ml-3 mr-3">~</span>
                                                <input class="form-control changeYN <?=$GWLIST?>" type="text" name="" />
                                            </div>
                                            <div class="d-inline-block GWconfig_errorNum">
                                                <span class="mr-3">오차</span>
                                                <input class="form-control d-inline-block changeYN <?=$GWLIST?>" type="text" name="" />
                                            </div>
                                        </div>
                                    </li>
                                    <!-- E: 온도 -->
                                    <!-- S: 습도 -->
                                    <li>
                                        <div class="mb-2">
                                            <div class="d-inline-block GWconfig_label">
                                                습도(%)
                                            </div>
                                            <div class="d-inline-block GWconfig_slt">
                                                <select class="form-control changeYN <?=$GWLIST?>" name="">
                                                    <option value="1">사용</option>
                                                    <option value="2">미사용</option>
                                                </select>
                                            </div>
                                            <div class="d-inline-block GWconfig_input">
                                                <input class="form-control <?=$GWLIST?>" type="text" name=""/>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-inline-block GWconfig_label">
                                                허용범위
                                            </div>
                                            <div class="d-inline-block GWconfig_tempRange">
                                                <input class="form-control changeYN <?=$GWLIST?>" type="text" name="" />
                                                <span class="ml-3 mr-3">~</span>
                                                <input class="form-control changeYN <?=$GWLIST?>" type="text" name="" />
                                            </div>
                                            <div class="d-inline-block GWconfig_errorNum">
                                                <span class="mr-3">오차</span>
                                                <input class="form-control d-inline-block changeYN <?=$GWLIST?>" type="text" name=""  />
                                            </div>
                                        </div>
                                    </li>
                                    <!--E:습도 -->
                                    <!--S:가스 -->
                                    <li>
                                        <div class="mb-2">
                                            <div class="d-inline-block GWconfig_label">
                                                가스(%)
                                            </div>
                                            <div class="d-inline-block GWconfig_slt">
                                                <select class="form-control changeYN <?=$GWLIST?>" name="">
                                                    <option value="1">사용</option>
                                                    <option value="2">미사용</option>
                                                </select>
                                            </div>
                                            <div class="d-inline-block GWconfig_input">
                                                <input class="form-control changeYN <?=$GWLIST?>" type="text" name="" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-inline-block GWconfig_label">
                                                허용범위
                                            </div>
                                            <div class="d-inline-block GWconfig_tempRange">
                                                <input class="form-control changeYN <?=$GWLIST?>" type="text" name=""  />
                                                <span class="ml-3 mr-3">~</span>
                                                <input class="form-control changeYN <?=$GWLIST?>" type="text" name=""  />
                                            </div>
                                            <div class="d-inline-block GWconfig_errorNum">
                                                <span class="mr-3">오차</span>
                                                <input class="form-control d-inline-block changeYN <?=$GWLIST?>" type="text" name=""  />
                                            </div>
                                        </div>
                                    </li>
                                    <!--E:가스 -->
                                </ul>
                            </div>
                            <!-- E:etc -->
                            <input type="hidden" class="<?=$GWLIST?>" />
                            <input type="hidden" class="<?=$GWLIST?>" />
                        </div>
                    </div>
                    <?}?>
                </div>
                <!-- E: Tab panes-->
            </div>
        </div>
    </div>
    <!-- PageContent End -->
</section>
</div>
<div class="modal manualRegist" id="manualRegist" style="display:none" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">수동등록</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-xl-4 col-form-label">건물명</label>
                        <div class="col-xl-8">
                            <input class="form-control input-sm" type="text" name="buildingName" id="modalBuildingName">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-4 col-form-label">설치위치</label>
                        <div class="col-xl-8">
                            <input class="form-control input-sm" type="text" name="installPosition" id="modalLocation">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-4 col-form-label">비고</label>
                        <div class="col-xl-8">
                            <textarea class="form-control input-sm" id="modalCmt"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-4 col-form-label">S/N</label>
                        <div class="col-xl-8">
                            <input class="form-control input-sm" type="text" name="serialNum" id="modalSerialNo">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-4 col-form-label">MAC</label>
                        <div class="col-xl-8">
                            <input class="form-control input-sm" type="text" name="MAC" id="modalMAC">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-4 col-form-label">IP</label>
                        <div class="col-xl-8">
                            <input class="form-control input-sm" type="text" name="IP" id="modalIP">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-4 col-form-label">PORT</label>
                        <div class="col-xl-8">
                            <input class="form-control input-sm" type="text" name="port" id="modalPort">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-xs" id="saveBtn" onclick="registDevice()">등록</button>
                <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">취소</button>
            </div>

        </div>
    </div>
</div>

<div class="modal manualRegist" id="changeModal" style="display:none" aria-hidden="true">
    <input type="hidden" id="pastIndex" >
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                변경 된 내용이 있습니다, 저장 하시겠습니까?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-xs" id="tabModalSave">저장</button>
                <button type="button" class="btn btn-danger btn-xs" id="tabModalCancle">취소</button>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript ">
    let deviceList = '<?=json_encode($getDeviceList['data'])?>';
    let deviceListJson = JSON.parse(deviceList);

    getHeaderName();

    $(document).ready(function() {
        let org = document.getElementById("select-buildingName").value;

        org_deviceLocation(org) //init device location

        $("#manuaRegistBtn").click(function() {
            $("#manualRegist").modal('show');
        });
        $("[name=gwSaveBtn]").click(function(){
            $("[name=gwSaveBtn]").index(this);
        });

        $(".changeYN").change(function(){

            document.getElementById("tabCond").value = "2"

        });

        $("a[data-toggle='tab']").on("shown.bs.tab", function(e) {
            let tabMoveCondition = document.getElementById("tabCond").value

            let pastIndex = $(e.relatedTarget).data("index");

            document.getElementById("pastIndex").value = pastIndex

            e.preventDefault();

            if(tabMoveCondition == "2"){

                deviceShowTabModal();

                $("#tabModalSave").click(function(){
                    modifyGatewayTab();
                })

                $("#tabModalCancle").click(function(){
                    closeTabModal();
                    $(e.relatedTarget).tab("show");
                })

                // let cond = confirm("변경 된 내용이 있습니다. 이동하시겠습니까?");
                //
                // if(cond){
                //     $(e.target).tab("show")
                //     tabMoveCondition = true;
                //     tabMoveEvent = true;
                // }else{
                //     tabMoveEvent = false;
                //     $(e.relatedTarget).tab("show");
                //     tabMoveEvent = true;
                // }
            }
        });

        $("#deviceLocation").change(function(){
            web_device_conf_search();
        })



    });


</script>
<? include $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"?>
