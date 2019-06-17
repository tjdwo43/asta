let alertModifyRealTime = function (config, deviceSerialNoListJson) {
    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }

    let db = firebase.firestore();

    for(sn in deviceSerialNoListJson)
    {
        let i = sn;
        let v = deviceSerialNoListJson[sn];

        db.collection("tb_gateway").where("SerialNo", "==", i).onSnapshot(function (snapshot)
        {
            snapshot.docChanges.forEach(function (change)
            {

                let tempStatus = 0;
                let huStatus = 0;
                let gasStatus = 0;

                if (sessionStorage.getItem(change.doc.data().GatewayKey) == null) {
                    //console.log('sessinStroge null')
                    tempStatus = 0;
                    huStatus = 0;
                    gasStatus = 0;
                }
                else
                {
                    //console.log('sessinStroge not null')
                    let inchSessionVal = JSON.parse(sessionStorage.getItem(change.doc.data().GatewayKey));

                    tempStatus = inchSessionVal.temp;
                    huStatus = inchSessionVal.humid;
                    gasStatus = inchSessionVal.gas;
                }

                if (change.type === "add")
                {
                    console.log(change.doc.data())
                }

                if (change.type === "modified")
                {

                    let inchSessionVal = JSON.parse(sessionStorage.getItem(change.doc.data().GatewayKey));

                    console.log("이전상태값", inchSessionVal);
                    console.log(change.doc.data())

                    if (change.doc.data().GatewayUseYN === "1")
                    {
                        inch_item(
                            change.doc.data().inch1,
                            change.doc.data().inch1Select,
                            "1",
                            change.doc.data().inch1Cmt,
                            inchSessionVal.inch1,
                            change.doc.data().SerialNo,
                            change.doc.data().GatewayKey,
                            change.doc.data().GatewayCmt
                        );

                        inch_item(
                            change.doc.data().inch2,
                            change.doc.data().inch2Select,
                            "2",
                            change.doc.data().inch2Cmt,
                            inchSessionVal.inch2,
                            change.doc.data().SerialNo,
                            change.doc.data().GatewayKey,
                            change.doc.data().GatewayCmt
                        );

                        inch_item(
                            change.doc.data().inch3,
                            change.doc.data().inch3Select,
                            "3",
                            change.doc.data().inch3Cmt,
                            inchSessionVal.inch3,
                            change.doc.data().SerialNo,
                            change.doc.data().GatewayKey,
                            change.doc.data().GatewayCmt
                        );

                        inch_item(
                            change.doc.data().inch4,
                            change.doc.data().inch4Select,
                            "4",
                            change.doc.data().inch4Cmt,
                            inchSessionVal.inch4,
                            change.doc.data().SerialNo,
                            change.doc.data().GatewayKey,
                            change.doc.data().GatewayCmt
                        );

                        inch_item(
                            change.doc.data().inch5,
                            change.doc.data().inch5Select,
                            "5",
                            change.doc.data().inch5Cmt,
                            inchSessionVal.inch5,
                            change.doc.data().SerialNo,
                            change.doc.data().GatewayKey,
                            change.doc.data().GatewayCmt
                        );

                        inch_item(
                            change.doc.data().inch6,
                            change.doc.data().inch6Select,
                            "6",
                            change.doc.data().inch6Cmt,
                            inchSessionVal.inch6,
                            change.doc.data().SerialNo,
                            change.doc.data().GatewayKey,
                            change.doc.data().GatewayCmt
                        );

                        tempStatus = etc_item(
                            change.doc.data().tempYN,
                            inchSessionVal.temp,
                            change.doc.data().temperature,
                            change.doc.data().tempMax,
                            change.doc.data().tempMin,
                            change.doc.data().tempAgreeRange,
                            change.doc.data().tempCmt,
                            "10",
                            change.doc.data().GatewayKey,
                            change.doc.data().GatewayCmt,
                            change.doc.data().SerialNo,
                            "&deg;C"
                        );

                        huStatus = etc_item(
                            change.doc.data().huYN,
                            inchSessionVal.temp,
                            change.doc.data().humidity,
                            change.doc.data().huMax,
                            change.doc.data().huMin,
                            change.doc.data().huAgreeRange,
                            change.doc.data().huCmt,
                            "11",
                            change.doc.data().GatewayKey,
                            change.doc.data().GatewayCmt,
                            change.doc.data().SerialNo,
                            "%"
                        );

                        gasStatus = etc_item(
                            change.doc.data().gasYN,
                            inchSessionVal.temp,
                            change.doc.data().gas,
                            change.doc.data().gasMax,
                            change.doc.data().gasMin,
                            change.doc.data().gasAgreeRange,
                            change.doc.data().gasCmt,
                            "11",
                            change.doc.data().GatewayKey,
                            change.doc.data().GatewayCmt,
                            change.doc.data().SerialNo,
                            "%"
                        )

                    } // E : Gateway use YN

                } // E:modify

                let inchStatus = {
                    "gatewayNae": change.doc.data().GatewayName,
                    "inch1": change.doc.data().inch1,
                    "inch2": change.doc.data().inch2,
                    "inch3": change.doc.data().inch3,
                    "inch4": change.doc.data().inch4,
                    "inch5": change.doc.data().inch5,
                    "inch6": change.doc.data().inch6,
                    "temp": tempStatus,
                    "humid": huStatus,
                    "gas": gasStatus
                };

                sessionStorage.setItem(change.doc.data().GatewayKey, JSON.stringify(inchStatus))

            }); // E : onSnapshot.foreach
        }); // E : onSnapshot
    }
};
/*
* parameter
* * status: 상태값 0:없음, 1:정상, 2:이상
* * chType: 0:사용안함, 1:경보, 2:상태
* * chNo: 입력 채널 번호(1~6)
* * chCmt: 입력 채널 코멘트
* * pastStatus: 이전값(sessionStorage)
* * serialNo: 제어보드 고유 아이디
* * gwKey : 게이트웨이 고유 아이디
* * gwCmt : 게이트웨이 코멘트
* */
let inch_item = function(status, chType, chNo, chCmt, pastStatus, serialNo, gwKey, gwCmt)
{
    let currentDateStr = getTimeStamp();

    if ( (status === "2") && (chType==="1") )
    { // inch 상태 값이 비정상이고 경보 일 때

        if (!pastStatus || pastStatus === 1)
        {
            let alertMessage = currentDateStr+"-"+gwCmt+"-"+"-"+chCmt+" "+"경보 발생";
            alertModal(alertMessage,chCmt, gwKey, chNo,  gwCmt, serialNo);
        }

    }
};

let etc_item = function(etcYN, pastStatus, currentVal, max, min, agreeRange, cmt, chNo, gwKey, gwCmt, serialNo, unit)
{
    let saveStatusVal;
    let currentDateStr = getTimeStamp();

    if(etcYN === "1")
    {
        if(pastStatus == 0)
        {
            if ( ( ( Number(max) + Number(agreeRange) ) >= currentVal ) && ( ( Number(min) - Number(agreeRange) ) <= currentVal ) )
            {
                saveStatusVal = 0
            }
            else if ( ( Number(max) + Number(agreeRange) ) < currentVal )
            {
                let alertMessage = currentDateStr+"-"+gwCmt+"-"+cmt+" 허용 범위 "+ ( Number(max) + Number(agreeRange) )+unit+"초과"

                alertModal(alertMessage, cmt, gwKey, chNo, gwCmt, serialNo)

                saveStatusVal = 1
            }
            else if( ( Number(min) - Number(agreeRange)  > currentVal ) )
            {
                let alertMessage = currentDateStr+"-"+gwCmt+"-"+cmt+" 허용 범위 "+ ( Number(min) - Number(agreeRange) )+unit+"미만"

                alertModal(alertMessage, cmt, gwKey, chNo, gwCmt, serialNo)

                saveStatusVal = 2
            }
        }
        else
        {
            if ( ( Number(max) - Number(agreeRange) ) >= currentVal &&  ( Number(min) + Number(agreeRange) ) <= currentVal )
            {
                saveStatusVal = 0;
            }
            else
            {
                saveStatusVal = pastStatus
            }
        }
    }

    return saveStatusVal;
};

let updateMornViewRealTime = function (config, deviceSerialNoListJson) {

    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }

    var db = firebase.firestore();

    $.each(deviceSerialNoListJson, function (i, v) {

        db.collection("tb_gateway").where("SerialNo", "==", i)
            .onSnapshot(function (snapshot) {
                snapshot.docChanges.forEach(function (change) {

                    if (change.type === "modified") {

                        if (change.doc.data().SerialNo == i) {
                            $.ajax({
                                url: "/device/deviceAjaxProc.php",
                                type: "post",
                                data: {
                                    'mode': 'getMornDevice_n',
                                    'SerialNo': i
                                },
                                success: function (data) {
                                    returnData = $.parseJSON(data);

                                    returnDataArr = returnData['data'];
                                    $("#gwList").html(returnData['html']);
                                },
                                beforeSend: function () {
                                    $(".wrapper").addClass("whirl traditional");
                                },
                                complete: function () {
                                    $(".wrapper").removeClass("whirl traditional");
                                }
                            });
                        }
                    }
                }); // E : onSnapshot.foreach
            }); // E : onSnapshot
    })

};

let updateGWViewRealTime = function (config, deviceSerialNoListJson) {

    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }

    var db = firebase.firestore();

    $.each(deviceSerialNoListJson, function (i, v) {

        db.collection("tb_gateway").where("SerialNo", "==", i)
            .onSnapshot(function (snapshot) {
                snapshot.docChanges.forEach(function (change) {

                    if (change.type === "added") {
                        //console.log("GW: ", change.doc.data());
                    }

                    if (change.type === "modified") {

                        // if ($("#inputSerialNo").val() == change.doc.data().SerialNo) {
                        //
                        //     for (let i = 0; i < (document.getElementById("gwList").rows.length / 2); i++) {
                        //
                        //         if (document.getElementsByName("gw" + i)[0].value == change.doc.data().GatewayKey) {
                        //             let parent_tr = document.getElementsByName("gw" + i)[0].parentElement;
                        //             let parent_tr_cmt = parent_tr.nextElementSibling;
                        //
                        //             parent_tr.getElementsByTagName("td")[0].children[0].children[0].value = change.doc.data().GatewayUseYN;
                        //             if (change.doc.data().GatewayUseYN == 1) parent_tr.getElementsByTagName("td")[0].children[0].children[0].checked = true;
                        //             else parent_tr.getElementsByTagName("td")[0].children[0].children[0].checked = false;
                        //
                        //             parent_tr.getElementsByTagName("td")[2].children[0].value = change.doc.data().inch1Select;
                        //
                        //             parent_tr.getElementsByTagName("td")[3].children[0].value = change.doc.data().inch2Select;
                        //             parent_tr.getElementsByTagName("td")[4].children[0].value = change.doc.data().inch3Select;
                        //             parent_tr.getElementsByTagName("td")[5].children[0].value = change.doc.data().inch4Select;
                        //             parent_tr.getElementsByTagName("td")[6].children[0].value = change.doc.data().inch5Select;
                        //             parent_tr.getElementsByTagName("td")[7].children[0].value = change.doc.data().inch6Select;
                        //
                        //             parent_tr.getElementsByTagName("td")[8].children[0].value = change.doc.data().outch1Select;
                        //             parent_tr.getElementsByTagName("td")[9].children[0].value = change.doc.data().outch2Select;
                        //             parent_tr.getElementsByTagName("td")[10].children[0].value = change.doc.data().outch3Select;
                        //
                        //             parent_tr.getElementsByTagName("td")[11].value = change.doc.data().tempYN;
                        //             if (change.doc.data().tempYN == 1) parent_tr.getElementsByTagName("td")[11].children[0].children[0].checked = true;
                        //             else parent_tr.getElementsByTagName("td")[11].children[0].children[0].checked = false;
                        //
                        //             parent_tr.getElementsByTagName("td")[12].value = change.doc.data().huYN;
                        //             if (change.doc.data().huYN == 1) parent_tr.getElementsByTagName("td")[12].children[0].children[0].checked = true;
                        //             else parent_tr.getElementsByTagName("td")[12].children[0].children[0].checked = false;
                        //
                        //             parent_tr.getElementsByTagName("td")[13].value = change.doc.data().gasYN;
                        //             if (change.doc.data().gasYN == 1) parent_tr.getElementsByTagName("td")[13].children[0].children[0].checked = true;
                        //             else parent_tr.getElementsByTagName("td")[13].children[0].children[0].checked = false;
                        //
                        //             /*cmt*/
                        //             parent_tr_cmt.getElementsByTagName("td").item(0).children[0].value = change.doc.data().GatewayCmt;
                        //             parent_tr_cmt.getElementsByTagName("td").item(1).children[0].value = change.doc.data().inch1Cmt;
                        //             parent_tr_cmt.getElementsByTagName("td").item(2).children[0].value = change.doc.data().inch2Cmt;
                        //             parent_tr_cmt.getElementsByTagName("td").item(3).children[0].value = change.doc.data().inch3Cmt;
                        //             parent_tr_cmt.getElementsByTagName("td").item(4).children[0].value = change.doc.data().inch4Cmt;
                        //             parent_tr_cmt.getElementsByTagName("td").item(5).children[0].value = change.doc.data().inch5Cmt;
                        //             parent_tr_cmt.getElementsByTagName("td").item(6).children[0].value = change.doc.data().inch6Cmt;
                        //
                        //             parent_tr_cmt.getElementsByTagName("td").item(7).children[0].value = change.doc.data().outch1Cmt;
                        //             parent_tr_cmt.getElementsByTagName("td").item(8).children[0].value = change.doc.data().outch2Cmt;
                        //             parent_tr_cmt.getElementsByTagName("td").item(9).children[0].value = change.doc.data().outch3Cmt;
                        //
                        //             parent_tr_cmt.getElementsByTagName("td").item(10).children[0].value = change.doc.data().tempCmt;
                        //             parent_tr_cmt.getElementsByTagName("td").item(11).children[0].value = change.doc.data().huCmt;
                        //             parent_tr_cmt.getElementsByTagName("td").item(12).children[0].value = change.doc.data().gasCmt
                        //
                        //         }
                        //     }
                        //
                        // }

                    } // E : modified

                    if (change.type === "removed") {
                        console.log("Removed GW: ", change.doc.data());
                    }

                });
            }); // E : onSnapShot
    })

};

let updateMainViewRealTime = function (config, deviceSerialNoListJson) {
    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }

    var db = firebase.firestore();

    $.each(deviceSerialNoListJson, function (i, v) {
        //main I/O board
        db.collection("tb_device").where("SerialNo", "==", i)
            .onSnapshot(function (querySnapshot) {
                querySnapshot.forEach(function (doc) {

                    if ($("#inputSerialNo").val() == doc.data().SerialNo) {
                        $("#inputBoardName").val(doc.data().BoardName);
                        $("#inputLocation").val(doc.data().Location);
                        $("#inputMACAddr").val(doc.data().MACAddr);
                        $("#inputIPAddr").val(doc.data().IPAddr);
                        $("#inputPort").val(doc.data().Port);
                    }
                });
            });
    })

};

let mobileMornitoringView = function (config, serialNoList, auth ) {
    var orgName = document.getElementById("lastOrgName").value
    var org_code = document.getElementById("lastOrg").value

    let alarmHtml = document.getElementById("alarm-contents")
    let statusHtml = document.getElementById("status-contents")
    let controlHtml = document.getElementById("control-contents")
    let climateHtml = document.getElementById("climate-contents")

    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }
    var db = firebase.firestore();

    let realtimeCollection = db.collection("tb_gateway")
    let reatimeSerialList

    $.each(serialNoList, function (i, v) {
        if(i != ""){
            let retimeRef = realtimeCollection.orderBy("GatewayKey", "asc").startAt(i).endAt(i + "\uf8ff");

            retimeRef.onSnapshot(function (querySnapshot) {
                alarmHtml.innerHTML = ''
                statusHtml.innerHTML = ''
                controlHtml.innerHTML = ''
                climateHtml.innerHTML = ''
                querySnapshot.forEach(function (doc) {
                    if (doc.data().GatewayUseYN == '1') {
                        if (doc.data().inch1Select == '1' || doc.data().inch1Select == '2') { //select 1,2 경보, 상태
                            let element = document.createElement('div')
                            let subElement = document.createElement('p')
                            let subCommentEle = document.createElement('div')

                            if (doc.data().inch1 == '2' || doc.data().inch1 == '3') element.classList.add('status-danger')  //이상 신호 감지

                            if(doc.data().inch1Select == '1'){
                                if (doc.data().inch1 == '2') element.classList.add('danger_blink')  //이상 신호 감지
                                element.onclick = function () {
                                    recentHistoryModal2(org_code, doc.data().SerialNo, doc.data().GatewayKey, "1", "1",
                                        orgName, doc.data().GatewayCmt, doc.data().inch1Cmt, doc.data().inch1)
                                }
                            }
                            element.classList.add('m-item')

                            if (doc.data().inch1Select == '2') {
                                subElement.innerHTML = (doc.data().inch1 == '2') ? "ON" : "OFF"
                                element.onclick = function () {
                                    recentHistoryModal(org_code, doc.data().SerialNo, doc.data().GatewayKey, "2", "1", doc.data().inch1Cmt)
                                }
                            }else subElement.innerHTML = ''

                            subCommentEle.innerHTML = (doc.data().inch1Cmt == '') ? '미입력' : doc.data().inch1Cmt
                            subCommentEle.classList.add('text-truncate')

                            // element.onclick = function () {
                            //     moveInchLog('inch' + (i + 1), doc.data().GatewayKey)
                            // }

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)
                            if (doc.data().inch1Select == '1') {
                                if (doc.data().inch1 == '2') element.classList.add('alarm-inch')
                                alarmHtml.appendChild(element)
                            } else statusHtml.appendChild(element)

                        }
                        if (doc.data().inch2Select == '1' || doc.data().inch2Select == '2') { //select 1,2 경보, 상태
                            let element = document.createElement('div')
                            let subElement = document.createElement('p')
                            let subCommentEle = document.createElement('div')

                            if (doc.data().inch2 == '2' || doc.data().inch2 == '3') element.classList.add('status-danger')  //이상 신호 감지

                            if(doc.data().inch2Select == '1'){
                                if (doc.data().inch2 == '2') element.classList.add('danger_blink')  //이상 신호 감지
                                element.onclick = function () {
                                    recentHistoryModal2(org_code, doc.data().SerialNo, doc.data().GatewayKey, "1", "2",
                                        orgName, doc.data().GatewayCmt, doc.data().inch2Cmt, doc.data().inch2)
                                }
                            }
                            element.classList.add('m-item')

                            if (doc.data().inch2Select == '2') {
                                subElement.innerHTML = (doc.data().inch2 == '2') ? "ON" : "OFF"
                                element.onclick = function () {
                                    recentHistoryModal(org_code, doc.data().SerialNo, doc.data().GatewayKey, "2", "2", doc.data().inch2Cmt)
                                }
                            }else subElement.innerHTML = ''

                            subCommentEle.innerHTML = (doc.data().inch2Cmt == '') ? '미입력' : doc.data().inch2Cmt
                            subCommentEle.classList.add('text-truncate')

                            // element.onclick = function () {
                            //     moveInchLog('inch' + (i + 1), doc.data().GatewayKey)
                            // }

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)
                            if (doc.data().inch2Select == '1') {
                                if (doc.data().inch2 == '2') element.classList.add('alarm-inch')
                                alarmHtml.appendChild(element)
                            } else statusHtml.appendChild(element)

                        }
                        if (doc.data().inch3Select == '1' || doc.data().inch3Select == '2') { //select 1,2 경보, 상태
                            let element = document.createElement('div')
                            let subElement = document.createElement('p')
                            let subCommentEle = document.createElement('div')

                            if (doc.data().inch3 == '2' || doc.data().inch3 == '3') element.classList.add('status-danger')  //이상 신호 감지

                            if(doc.data().inch3Select == '1'){
                                if (doc.data().inch3 == '2') element.classList.add('danger_blink')  //이상 신호 감지
                                element.onclick = function () {
                                    recentHistoryModal2(org_code, doc.data().SerialNo, doc.data().GatewayKey, "1", "3",
                                        orgName, doc.data().GatewayCmt, doc.data().inch3Cmt, doc.data().inch3)
                                }
                            }
                            element.classList.add('m-item')

                            if (doc.data().inch3Select == '2') {
                                subElement.innerHTML = (doc.data().inch3 == '2') ? "ON" : "OFF"
                                element.onclick = function () {
                                    recentHistoryModal(org_code, doc.data().SerialNo, doc.data().GatewayKey, "2", "3", doc.data().inch3Cmt)
                                }
                            }else subElement.innerHTML = ''

                            subCommentEle.innerHTML = (doc.data().inch3Cmt == '') ? '미입력' : doc.data().inch3Cmt
                            subCommentEle.classList.add('text-truncate')

                            // element.onclick = function () {
                            //     moveInchLog('inch' + (i + 1), doc.data().GatewayKey)
                            // }

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)
                            if (doc.data().inch3Select == '1') {
                                if (doc.data().inch3 == '2') element.classList.add('alarm-inch')
                                alarmHtml.appendChild(element)
                            } else statusHtml.appendChild(element)

                        }
                        if (doc.data().inch4Select == '1' || doc.data().inch4Select == '2') { //select 1,2 경보, 상태
                            let element = document.createElement('div')
                            let subElement = document.createElement('p')
                            let subCommentEle = document.createElement('div')

                            if (doc.data().inch4 == '2' || doc.data().inch4 == '3') element.classList.add('status-danger')  //이상 신호 감지

                            if(doc.data().inch4Select == '1'){
                                if (doc.data().inch4 == '2') element.classList.add('danger_blink')  //이상 신호 감지
                                element.onclick = function () {
                                    recentHistoryModal2(org_code, doc.data().SerialNo, doc.data().GatewayKey, "1", "4",
                                        orgName, doc.data().GatewayCmt, doc.data().inch4Cmt, doc.data().inch4)
                                }
                            }
                            element.classList.add('m-item')

                            if (doc.data().inch4Select == '2') {
                                subElement.innerHTML = (doc.data().inch4 == '2') ? "ON" : "OFF"
                                element.onclick = function () {
                                    recentHistoryModal(org_code, doc.data().SerialNo, doc.data().GatewayKey, "2", "4", doc.data().inch4Cmt)
                                }
                            }else subElement.innerHTML = ''

                            subCommentEle.innerHTML = (doc.data().inch4Cmt == '') ? '미입력' : doc.data().inch4Cmt
                            subCommentEle.classList.add('text-truncate')

                            // element.onclick = function () {
                            //     moveInchLog('inch' + (i + 1), doc.data().GatewayKey)
                            // }

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)
                            if (doc.data().inch4Select == '1') {
                                if (doc.data().inch4 == '2') element.classList.add('alarm-inch')
                                alarmHtml.appendChild(element)
                            } else statusHtml.appendChild(element)

                        }
                        if (doc.data().inch5Select == '1' || doc.data().inch5Select == '2') { //select 1,2 경보, 상태
                            let element = document.createElement('div')
                            let subElement = document.createElement('p')
                            let subCommentEle = document.createElement('div')

                            if (doc.data().inch5 == '2' || doc.data().inch5 == '3') element.classList.add('status-danger')  //이상 신호 감지

                            if(doc.data().inch5Select == '1'){
                                if (doc.data().inch5 == '2') element.classList.add('danger_blink')  //이상 신호 감지
                                element.onclick = function () {
                                    recentHistoryModal2(org_code, doc.data().SerialNo, doc.data().GatewayKey, "1", "5",
                                        orgName, doc.data().GatewayCmt, doc.data().inch5Cmt, doc.data().inch5)
                                }
                            }
                            element.classList.add('m-item')

                            if (doc.data().inch5Select == '2') {
                                subElement.innerHTML = (doc.data().inch5 == '2') ? "ON" : "OFF"
                                element.onclick = function () {
                                    recentHistoryModal(org_code, doc.data().SerialNo, doc.data().GatewayKey, "2", "5", doc.data().inch5Cmt)
                                }
                            }else subElement.innerHTML = ''

                            subCommentEle.innerHTML = (doc.data().inch5Cmt == '') ? '미입력' : doc.data().inch5Cmt
                            subCommentEle.classList.add('text-truncate')

                            // element.onclick = function () {
                            //     moveInchLog('inch' + (i + 1), doc.data().GatewayKey)
                            // }

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)
                            if (doc.data().inch5Select == '1') {
                                if (doc.data().inch5 == '2') element.classList.add('alarm-inch')
                                alarmHtml.appendChild(element)
                            } else statusHtml.appendChild(element)

                        }
                        if (doc.data().inch6Select == '1' || doc.data().inch6Select == '2') { //select 1,2 경보, 상태
                            let element = document.createElement('div')
                            let subElement = document.createElement('p')
                            let subCommentEle = document.createElement('div')

                            if (doc.data().inch6 == '2' || doc.data().inch6 == '3') element.classList.add('status-danger')  //이상 신호 감지

                            if(doc.data().inch6Select == '1'){
                                if (doc.data().inch6 == '2') element.classList.add('danger_blink')  //이상 신호 감지
                                element.onclick = function () {
                                    recentHistoryModal2(org_code, doc.data().SerialNo, doc.data().GatewayKey, "1", "6",
                                        orgName, doc.data().GatewayCmt, doc.data().inch6Cmt, doc.data().inch6)
                                }
                            }
                            element.classList.add('m-item')

                            if (doc.data().inch6Select == '2') {
                                subElement.innerHTML = (doc.data().inch6 == '2') ? "ON" : "OFF"
                                element.onclick = function () {
                                    recentHistoryModal(org_code, doc.data().SerialNo, doc.data().GatewayKey, "2", "6", doc.data().inch6Cmt)
                                }
                            }else subElement.innerHTML = ''

                            subCommentEle.innerHTML = (doc.data().inch6Cmt == '') ? '미입력' : doc.data().inch6Cmt
                            subCommentEle.classList.add('text-truncate')

                            // element.onclick = function () {
                            //     moveInchLog('inch' + (i + 1), doc.data().GatewayKey)
                            // }

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)
                            if (doc.data().inch6Select == '1') {
                                if (doc.data().inch6 == '2') element.classList.add('alarm-inch')
                                alarmHtml.appendChild(element)
                            } else statusHtml.appendChild(element)

                        }
                        if (doc.data().outch1Select == '1' || doc.data().outch1Select == '3') { //출력 사용, 스케줄 사용
                            let element = document.createElement('div')
                            let subElement = document.createElement('p')
                            let subCommentEle = document.createElement('div')

                            subCommentEle.innerHTML = (doc.data().outch1Cmt == '') ? '미입력' : doc.data().outch1Cmt
                            subCommentEle.classList.add('text-truncate')

                            subElement.innerHTML = (doc.data().outch1OnOff == '1') ? "ON" : "OFF"

                            if (doc.data().outch1OnOff == '1') element.classList.add('status-danger')
                            element.classList.add('m-item')

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)

                            if(auth > 2){
                                element.onclick = function () {
                                    outchControl(doc.data().SerialNo, doc.data().GatewayKey, doc.data().outch1OnOff, doc.data().outch2OnOff, doc.data().outch3OnOff, "1",
                                        org_code, "3", "7", doc.data().outch1Cmt)
                                }
                            }
                            element.value = doc.data().outch1OnOff

                            controlHtml.appendChild(element)
                        }
                        if (doc.data().outch2Select == '1' || doc.data().outch2Select == '3') { //출력 사용, 스케줄 사용
                            let element = document.createElement('div')
                            let subElement = document.createElement('p')
                            let subCommentEle = document.createElement('div')

                            subCommentEle.innerHTML = (doc.data().outch2Cmt == '') ? '미입력' : doc.data().outch2Cmt
                            subCommentEle.classList.add('text-truncate')

                            subElement.innerHTML = (doc.data().outch2OnOff == '1') ? "ON" : "OFF"

                            if (doc.data().outch2OnOff == '1') element.classList.add('status-danger')
                            element.classList.add('m-item')

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)

                            if(auth > 2){
                                element.onclick = function () {
                                    outchControl(doc.data().SerialNo, doc.data().GatewayKey, doc.data().outch1OnOff, doc.data().outch2OnOff, doc.data().outch3OnOff, "2",
                                        org_code, "3", "8", doc.data().outch2Cmt)
                                }
                            }
                            element.value = doc.data().outch2OnOff

                            controlHtml.appendChild(element)
                        }
                        if (doc.data().outch3Select == '1' || doc.data().outch3Select == '3') { //출력 사용, 스케줄 사용
                            let element = document.createElement('div')
                            let subElement = document.createElement('p')
                            let subCommentEle = document.createElement('div')

                            subCommentEle.innerHTML = (doc.data().outch3Cmt == '') ? '미입력' : doc.data().outch3Cmt
                            subCommentEle.classList.add('text-truncate')

                            subElement.innerHTML = (doc.data().outch3OnOff == '1') ? "ON" : "OFF"

                            if (doc.data().outch3OnOff == '1') element.classList.add('status-danger')
                            element.classList.add('m-item')

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)

                            if(auth > 2){
                                element.onclick = function () {
                                    outchControl(doc.data().SerialNo, doc.data().GatewayKey, doc.data().outch1OnOff, doc.data().outch2OnOff, doc.data().outch3OnOff, "3",
                                        org_code, "3", "9", doc.data().outch3Cmt)
                                }
                            }
                            element.value = doc.data().outch3OnOff

                            controlHtml.appendChild(element)
                        }

                        //온도
                        if (doc.data().tempYN == '1') {
                            let element = document.createElement('div')
                            element.classList.add('m-item')
                            if (doc.data().temperature > (doc.data().tempMax + doc.data().tempAgreeRange) || doc.data().temperature < (doc.data().tempMin - doc.data().tempAgreeRange)) {
                                element.classList.add('status-danger')
                            }

                            let subElement = document.createElement('p')
                            subElement.innerHTML = doc.data().temperature + "&deg;C"

                            let subCommentEle = document.createElement('div')
                            subCommentEle.innerHTML = (doc.data().tempCmt == '') ? '미입력' : doc.data().tempCmt
                            subCommentEle.classList.add('text-truncate')

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)

                            element.onclick = function () {
                                recentHistoryModal(org_code, doc.data().SerialNo, doc.data().GatewayKey, "4", "10", doc.data().tempCmt)
                            }

                            climateHtml.appendChild(element)
                        }
                        //습도
                        if (doc.data().huYN == '1') {
                            let element = document.createElement('div')
                            element.classList.add('m-item')
                            if (doc.data().humidity > (doc.data().huMax + doc.data().huAgreeRange)|| doc.data().humidity < (doc.data().huMin-doc.data().huAgreeRange)) {
                                element.classList.add('status-danger')
                            }

                            let subElement = document.createElement('p')
                            subElement.innerHTML = doc.data().humidity + "%"

                            let subCommentEle = document.createElement('div')
                            subCommentEle.innerHTML = (doc.data().huCmt == '') ? '미입력' : doc.data().huCmt
                            subCommentEle.classList.add('text-truncate')

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)

                            element.onclick = function () {
                                recentHistoryModal(org_code, doc.data().SerialNo, doc.data().GatewayKey, "5", "11", doc.data().huCmt)
                            }

                            climateHtml.appendChild(element)
                        }
                        //가스
                        if (doc.data().gasYN == '1') {
                            let element = document.createElement('div')
                            element.classList.add('m-item')
                            if (doc.data().gas > (doc.data().gasMax + doc.data().gasAgreeRange) || doc.data().gas < (doc.data().gasMin - doc.data().gasAgreeRange)) {
                                element.classList.add('status-danger')
                            }

                            let subElement = document.createElement('p')
                            subElement.innerHTML = doc.data().gas + "%"

                            let subCommentEle = document.createElement('div')
                            subCommentEle.innerHTML = (doc.data().gasCmt == '') ? '미입력' : doc.data().gasCmt
                            subCommentEle.classList.add('text-truncate')

                            element.appendChild(subCommentEle)
                            element.appendChild(subElement)

                            element.onclick = function () {
                                recentHistoryModal(org_code, doc.data().SerialNo, doc.data().GatewayKey, "6", "11", doc.data().gasCmt)
                            }

                            climateHtml.appendChild(element)
                        }
                    }//E: gateway yn
                });

                if(alarmHtml.childElementCount > 0){
                    alarmHtml.parentElement.classList.add("d-block")
                }
                else{
                    alarmHtml.parentElement.classList.add("d-none")
                }

                if(statusHtml.childElementCount > 0){
                    statusHtml.parentElement.classList.add("d-block")
                }
                else{
                    statusHtml.parentElement.classList.add("d-none")
                }

                if(controlHtml.childElementCount > 0){
                    controlHtml.parentElement.classList.add("d-block")
                }
                else{
                    controlHtml.parentElement.classList.add("d-none")
                }

                if(climateHtml.childElementCount > 0){
                    climateHtml.parentElement.classList.add("d-block")
                }
                else{
                    climateHtml.parentElement.classList.add("d-none")
                }

                document.getElementsByTagName('body')[0].classList.remove("whirl", "traditional");
                var mItem = document.querySelectorAll('.m-item');
                $(mItem).each(function(i, el){
                    $(el).css({
                        'padding':'0',
                        'height':'70px',
                        'lineHeight':'110%',
                        'display':'block',
                        'float':'left'
                    });
                    if($(el).parent().attr('id') === 'alarm-contents'){
                        if($(el).find('div').text().length > 16){
                            $(el).find('div').html($(el).find('div').text().substring(0,8)+"<br/>"+$(el).find('div').text().substring(8,15)+"...");
                            $(el).css('paddingTop','10px');
                        } else {
                            if($(el).find('div').text().length > 8){
                                $(el).find('div').html($(el).find('div').text().substring(0,8)+"<br/>"+$(el).find('div').text().substring(8,$(el).find('div').text().length));
                                $(el).css('paddingTop','17px');
                            } else {
                                $(el).css('paddingTop','25px');
                            }
                        }
                    } else {
                        if($(el).find('div').text().length > 16){
                            $(el).find('div').html($(el).find('div').text().substring(0,8)+"<br/>"+$(el).find('div').text().substring(8,15)+"...");
                            $(el).css('paddingTop','10px');
                        } else {
                            if($(el).find('div').text().length > 8){
                                $(el).find('div').html($(el).find('div').text().substring(0,8)+"<br/>"+$(el).find('div').text().substring(8,$(el).find('div').text().length));
                                $(el).css('paddingTop','10px');
                            } else {
                                $(el).css('paddingTop','17px');
                            }
                        }
                    }
                });
            });
        }else{
            document.getElementsByTagName('body')[0].classList.remove("whirl", "traditional");
            document.getElementsByTagName('section')[0].classList.remove("d-none");
            document.getElementsByTagName('section')[1].classList.remove("d-none");
            document.getElementsByTagName('section')[2].classList.remove("d-none");
            document.getElementsByTagName('section')[3].classList.remove("d-none");
        }
    }) // E : each

}//E:fnc

let mobileMornitoringView2 = function (config, serialNoList, auth ) {
    let alarmHtml = document.getElementById("alarm-contents")
    let statusHtml = document.getElementById("status-contents")
    let controlHtml = document.getElementById("control-contents")
    let climateHtml = document.getElementById("climate-contents")

    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }
    var db = firebase.firestore();

    let realtimeCollection = db.collection("tb_gateway")
    let reatimeSerialList

    $.each(serialNoList, function (i, v) {
        if(i != ""){
            let retimeRef = realtimeCollection.orderBy("GatewayKey", "asc").startAt(i).endAt(i + "\uf8ff");

            retimeRef.onSnapshot(function (querySnapshot) {
                alarmHtml.innerHTML = ''
                statusHtml.innerHTML = ''
                controlHtml.innerHTML = ''
                climateHtml.innerHTML = ''
                querySnapshot.forEach(function (doc) {
                    mobill_monitoring_add(doc.data(), reatimeSerialList, alarmHtml, statusHtml, controlHtml, climateHtml)
                });

                document.getElementsByTagName('body')[0].classList.remove("whirl", "traditional");
                document.getElementsByTagName('section')[0].classList.remove("d-none");
                document.getElementsByTagName('section')[1].classList.remove("d-none");
                document.getElementsByTagName('section')[2].classList.remove("d-none");
                document.getElementsByTagName('section')[3].classList.remove("d-none");
            });
        }else{
            document.getElementsByTagName('body')[0].classList.remove("whirl", "traditional");
            document.getElementsByTagName('section')[0].classList.remove("d-none");
            document.getElementsByTagName('section')[1].classList.remove("d-none");
            document.getElementsByTagName('section')[2].classList.remove("d-none");
            document.getElementsByTagName('section')[3].classList.remove("d-none");
        }
    }) // E : each

}//E:fnc

let mobill_monitoring_add = function(data, reatimeSerialList, alarmHtml, statusHtml, controlHtml, climateHtml){
    reatimeSerialList = [[], [], [], [], [], [], [], [], []]
    //console.log("monitoring", doc.data())
    reatimeSerialList[0].push(data.inch1Cmt)
    reatimeSerialList[0].push(data.inch1)
    reatimeSerialList[0].push(data.inch1Select)
    reatimeSerialList[1].push(data.inch2Cmt)
    reatimeSerialList[1].push(data.inch2)
    reatimeSerialList[1].push(data.inch2Select)
    reatimeSerialList[2].push(data.inch3Cmt)
    reatimeSerialList[2].push(data.inch3)
    reatimeSerialList[2].push(data.inch3Select)
    reatimeSerialList[3].push(data.inch4Cmt)
    reatimeSerialList[3].push(data.inch4)
    reatimeSerialList[3].push(data.inch4Select)
    reatimeSerialList[4].push(data.inch5Cmt)
    reatimeSerialList[4].push(data.inch5)
    reatimeSerialList[4].push(data.inch5Select)
    reatimeSerialList[5].push(data.inch6Cmt)
    reatimeSerialList[5].push(data.inch6)
    reatimeSerialList[5].push(data.inch6Select)

    reatimeSerialList[6].push(data.outch1Cmt)
    reatimeSerialList[6].push(data.outch1OnOff)
    reatimeSerialList[6].push(data.outch1Select)
    reatimeSerialList[7].push(data.outch2Cmt)
    reatimeSerialList[7].push(data.outch2OnOff)
    reatimeSerialList[7].push(data.outch2Select)
    reatimeSerialList[8].push(data.outch3Cmt)
    reatimeSerialList[8].push(data.outch3OnOff)
    reatimeSerialList[8].push(data.outch3Select)
    //console.log("monitoringArr",reatimeSerialList);

    let domJSON = {'key':'', 'inch':[]}

    domJSON.key = data.SerialNo

    if (data.GatewayUseYN == '1') {
        let inchArray = [[],[],[],[],[],[]]
        //inch
        for (let i = 0; i < 6; i++) {
            if (reatimeSerialList[i][2] == '1' || reatimeSerialList[i][2] == '2') { //select 1,2 경보, 상태
                let element = document.createElement('div')
                let subElement = document.createElement('p')
                let subCommentEle = document.createElement('div')

                if (reatimeSerialList[i][1] == '2') element.classList.add('status-danger')  //이상 신호 감지
                element.classList.add('m-item')

                if (reatimeSerialList[i][2] == '2') {
                    subElement.innerHTML = (reatimeSerialList[i][1] == '2') ? "ON" : "OFF"
                }else subElement.innerHTML = ''

                subCommentEle.innerHTML = (reatimeSerialList[i][0] == '') ? '미입력' : reatimeSerialList[i][0]
                subCommentEle.classList.add('text-truncate')

                // element.onclick = function () {
                //     moveInchLog('inch' + (i + 1), data.GatewayKey)
                // }

                element.appendChild(subCommentEle)
                element.appendChild(subElement)
                if (reatimeSerialList[i][2] == '1') {
                    if (reatimeSerialList[i][1] == '2') element.classList.add('alarm-inch')
                    alarmHtml.appendChild(element)
                } else statusHtml.appendChild(element)

                inchArray[i] = element
            }
            domJSON.inch = inchArray
        }
        //outch
        for (let i = 0; i < 3; i++) {
            if (reatimeSerialList[i + 6][2] == '1' || reatimeSerialList[i + 6][2] == '3') { //출력 사용, 스케줄 사용
                let element = document.createElement('div')
                let subElement = document.createElement('p')
                let subCommentEle = document.createElement('div')

                subCommentEle.innerHTML = (reatimeSerialList[i][0] == '') ? '미입력' : reatimeSerialList[i + 6][0]
                subCommentEle.classList.add('text-truncate')

                subElement.innerHTML = (reatimeSerialList[i + 6][1] == '1') ? "ON" : "OFF"

                if (reatimeSerialList[i + 6][1] == '1') element.classList.add('status-danger')
                element.classList.add('m-item')

                element.appendChild(subCommentEle)
                element.appendChild(subElement)

                if(auth > 2){
                    element.onclick = function () {
                        outchControl(data.SerialNo, data.GatewayKey, data.outch1OnOff, data.outch2OnOff, data.outch3OnOff, i + 1)
                    }
                }
                if(i == 0) element.value = data.outch1OnOff
                else if(i == 1) element.value = data.outch2OnOff
                else if(i == 2) element.value = data.outch3OnOff

                controlHtml.appendChild(element)
            }
        }
        //온도
        if (data.tempYN == '1') {
            let element = document.createElement('div')
            element.classList.add('m-item')
            if (data.temperature > data.tempMax || data.temperature < data.tempMin) element.classList.add('status-danger')

            let subElement = document.createElement('p')
            subElement.innerHTML = data.temperature + "&deg;C"

            let subCommentEle = document.createElement('div')
            subCommentEle.innerHTML = (data.tempCmt == '') ? '미입력' : data.tempCmt
            subCommentEle.classList.add('text-truncate')

            element.appendChild(subCommentEle)
            element.appendChild(subElement)

            climateHtml.appendChild(element)
        }
        //습도
        if (data.huYN == '1') {
            let element = document.createElement('div')
            element.classList.add('m-item')
            if (data.humidity > data.huMax || data.humidity < data.huMin) element.classList.add('status-danger')

            let subElement = document.createElement('p')
            subElement.innerHTML = data.humidity + "%"

            let subCommentEle = document.createElement('div')
            subCommentEle.innerHTML = (data.huCmt == '') ? '미입력' : data.huCmt
            subCommentEle.classList.add('text-truncate')

            element.appendChild(subCommentEle)
            element.appendChild(subElement)

            climateHtml.appendChild(element)
        }
        //가스
        if (data.gasYN == '1') {
            let element = document.createElement('div')
            element.classList.add('m-item')
            if (data.gas > data.gasMax || data.gas < data.gasMin) element.classList.add('status-danger')

            let subElement = document.createElement('p')
            subElement.innerHTML = data.gas + "%"

            let subCommentEle = document.createElement('div')
            subCommentEle.innerHTML = (data.gasCmt == '') ? '미입력' : data.gasCmt
            subCommentEle.classList.add('text-truncate')

            element.appendChild(subCommentEle)
            element.appendChild(subElement)

            climateHtml.appendChild(element)
        }
    }//E: gateway yn

}

let statusCounting = function (config, orgCode) {
    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }
    let db = firebase.firestore();

    orgCode.forEach(function (e) {
        let buidingEle = document.getElementById(e.org_code);

        db.collection("tb_org").doc(e.org_code)
            .onSnapshot(function (doc) {
                if (doc.data() == undefined) {
                    buidingEle.classList.add('status-nomal');
                    buidingEle.innerHTML = '0/0'
                } else {
                    if (doc.data().alertWarning > 0) {
                        buidingEle.classList.remove('status-nomal');
                        buidingEle.classList.remove('status-danger');

                        buidingEle.classList.add('status-danger');
                        buidingEle.innerHTML = doc.data().alertWarning + "/" + doc.data().alert
                    } else {
                        buidingEle.classList.remove('status-nomal');
                        buidingEle.classList.remove('status-danger');

                        buidingEle.classList.add('status-nomal');
                        buidingEle.innerHTML = doc.data().warning + "/" + doc.data().status
                    }
                }
            });
    })

};

let headerCounting = function(config){
    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }
    console.log("headerCounting")
    let count = document.getElementById("curBldgCount")

    let db = firebase.firestore();

    db.collection("tb_org").doc(count.dataset.orgcode)
        .onSnapshot(function (doc)
        {
            if (doc.data() == undefined)
            {
                count.innerHTML = "N/N"
            }
            else
            {
                if (doc.data().alertWarning > 0)
                {
                    count.classList.remove('status-nomal');
                    count.classList.remove('status-danger');

                    count.classList.add('status-danger');
                    count.innerHTML = doc.data().alertWarning + "/" + doc.data().alert
                }
                else
                {
                    count.classList.remove('status-nomal');
                    count.classList.remove('status-danger');

                    count.classList.add('status-nomal');
                    count.innerHTML = doc.data().warning + "/" + doc.data().status
                }
            }
        });
}

let web_device_conf = function (config) {
    let deviceSN = document.getElementById("deviceLocation").value;

    if (!firebase.apps.length) firebase.initializeApp(config);

    var db = firebase.firestore();

    let realtimeCollection = db.collection("tb_device").where("SerialNo", "==", deviceSN);

    realtimeCollection.onSnapshot(function (querySnapshot) {
        querySnapshot.forEach(function (doc) {
            realTime_add_device(doc.data())
        });
    });
}

let web_device_conf_search = function(){
    $(".tab-pane").removeClass("active");
    $(".nav-tabs .nav-link").removeClass("active");

    $(".tab-pane").eq(0).addClass("active");
    $(".nav-tabs .nav-link").eq(0).addClass("active");

    document.getElementById("tabCond").value = "1"
    document.getElementById("tabCond2").value = "1"

    let deviceSN = document.getElementById("deviceLocation").value;

    var db = firebase.firestore();

    if(deviceSN == ""){
        deviceInputInit();
        alertMessage("등록된 장비가 없습니다.");

        return;
    }

    let realtimeCollection = db.collection("tb_device").where("SerialNo", "==", deviceSN);

    // realtimeCollection.onSnapshot(function (querySnapshot) {
    //     querySnapshot.forEach(function (doc) {
    //         realTime_update_device(doc.data())
    //     });
    // });

    realtimeCollection.get().then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            // doc.data() is never undefined for query doc snapshots
            //console.log(doc.id, " => ", doc.data());
            realTime_add_device(doc.data())
        });
    })
        .catch(function(error) {
            console.log("Error getting documents: ", error);
        });

    //========================= Gateway ==================//

    let reailtimeGwCollection = db.collection("tb_gateway").orderBy("GatewayKey", "asc").startAt(deviceSN).endAt(deviceSN + "\uf8ff");

    reailtimeGwCollection.onSnapshot(function (snapshot) {
        let i =1;
        snapshot.docChanges.forEach(function (change) {
            if (change.type === "added") {
                realTime_add_GW(change.doc.data(), i);
                i++;
            }

            if (change.type === "modified") {
                //console.log(change.doc.data())
                //realTime_update_GW(change.doc.data())
            } // E : modified

            if (change.type === "removed") {

            }
        });

    });
}

let realTime_add_device = function(deviceData){
    let buildingName = document.getElementById("textbidgName");
    let location = document.getElementById("textbidgLocation");
    let cmt = document.getElementById("textbidgCmt");
    let serialNo = document.getElementById("textBidgSN");
    let mac = document.getElementById("textMac");
    let ip = document.getElementById("textIP");
    let port = document.getElementById("textPort");
    let deviceId = document.getElementById("textDeviceId");
    let useYN = document.getElementById("textUseYN");
    let deviceOrgCode = document.getElementById("textDeviceOrgCode");

    //console.log(deviceData)

    buildingName.value = deviceData.BoardName;
    location.value = deviceData.Location;
    cmt.value = (deviceData.comment == null)?"":deviceData.comment;
    serialNo.textContent = deviceData.SerialNo;
    mac.textContent = deviceData.MACAddr;
    ip.textContent = deviceData.IPAddr;
    port.textContent = deviceData.Port;
    deviceId.value = deviceData.DeviceId;
    useYN.value = deviceData.useYN;
    deviceOrgCode.value = deviceData.org_code;
}
let realTime_update_device = function(deviceData){
    let buildingName = document.getElementById("textbidgName");
    let location = document.getElementById("textbidgLocation");
    let cmt = document.getElementById("textbidgCmt");
    let serialNo = document.getElementById("textBidgSN");
    let mac = document.getElementById("textMac");
    let ip = document.getElementById("textIP");
    let port = document.getElementById("textPort");
    let deviceId = document.getElementById("textDeviceId");
    let useYN = document.getElementById("textUseYN");
    let deviceOrgCode = document.getElementById("textDeviceOrgCode");

    if(serialNo.textContent == deviceData.SerialNo){
        let org_code = document.getElementById("select-buildingName").value

        buildingName.value = deviceData.BoardName;
        location.value = deviceData.Location;
        cmt.value = (deviceData.cmt == null)?"":deviceData.cmt;
        serialNo.textContent = deviceData.SerialNo;
        mac.textContent = deviceData.MACAddr;
        ip.textContent = deviceData.IPAddr;
        port.textContent = deviceData.Port;
        deviceOrgCode.value = deviceData.org_code;
        deviceId.value = "1"
        useYN.value = "1"

        $.ajax({
            "url": "/device/deviceAjaxProc.php",
            "type": "post",
            "data":{
                "mode":"getMainDevice",
                "org_code":org_code,
                'dvcsBldn': true
            },
            success:function(data){
                let deviceList = JSON.parse(data).data

                //console.log(deviceList)
                let replaceMinArr = []

                for(k in deviceList){
                    //console.log()
                    replaceMinArr.push({text:deviceList[k].Location, value:deviceList[k].SerialNo})
                }
                //console.log(replaceMinArr)
                $("#deviceLocation").replaceOptions(replaceMinArr)
                //console.log(deviceList)
            }
        })
    }
}

let realTime_add_GW = function(gwData, i){
    let gwId = "gw"+i;
    let gw = document.getElementsByClassName(gwId);

    gw[0].value = gwData.GatewayCmt;
    gw[1].value = gwData.GatewayUseYN;
    gw[2].value = gwData.inch1Select;
    gw[3].value = gwData.inch1Cmt;
    gw[4].value = gwData.inch2Select;
    gw[5].value = gwData.inch2Cmt;
    gw[6].value = gwData.inch3Select;
    gw[7].value = gwData.inch3Cmt;
    gw[8].value = gwData.inch4Select;
    gw[9].value = gwData.inch4Cmt;
    gw[10].value = gwData.inch5Select;
    gw[11].value = gwData.inch5Cmt;
    gw[12].value = gwData.inch6Select;
    gw[13].value = gwData.inch6Cmt;
    gw[14].value = gwData.outch1Select;
    gw[15].value = gwData.outch1Cmt;
    gw[16].value = gwData.outch1FeedYN// feedback on/off
    gw[17].value = "피드백";
    gw[18].value = gwData.outch2Select;
    gw[19].value = gwData.outch2Cmt;
    gw[20].value = gwData.outch2FeedYN;
    gw[21].value = "피드백2";
    gw[22].value = gwData.outch3Select;
    gw[23].value = gwData.outch3Cmt;
    gw[24].value = gwData.outch3FeedYN;
    gw[25].value = "피드백3";
    gw[26].value = gwData.tempYN;
    gw[27].value = gwData.tempCmt;
    gw[28].value = gwData.tempMin;
    gw[29].value = gwData.tempMax;
    gw[30].value = gwData.tempAgreeRange //오차범위
    gw[31].value = gwData.huYN;
    gw[32].value = gwData.huCmt;
    gw[34].value = gwData.huMax;
    gw[33].value = gwData.huMin;
    gw[35].value = gwData.huAgreeRange; // 오차범위
    gw[36].value = gwData.gasYN;
    gw[37].value = gwData.gasCmt;
    gw[39].value = gwData.gasMax;
    gw[38].value = gwData.gasMin;
    gw[40].value = gwData.gasAgreeRange; // 오차범위
    gw[41].value = gwData.GatewayKey;
    gw[42].value = gwData.GatewayName;

    gw[0].name = gwData.GatewayKey;
    gw[1].name = gwData.GatewayKey;
    gw[2].name = gwData.GatewayKey;
    gw[3].name = gwData.GatewayKey;
    gw[4].name = gwData.GatewayKey;
    gw[5].name = gwData.GatewayKey;
    gw[6].name = gwData.GatewayKey;
    gw[7].name = gwData.GatewayKey;
    gw[8].name = gwData.GatewayKey;
    gw[9].name = gwData.GatewayKey;
    gw[10].name = gwData.GatewayKey;
    gw[11].name = gwData.GatewayKey;
    gw[12].name = gwData.GatewayKey;
    gw[13].name = gwData.GatewayKey;
    gw[14].name = gwData.GatewayKey;
    gw[15].name = gwData.GatewayKey;
    gw[16].name = gwData.GatewayKey// feedback on/off
    gw[17].name = gwData.GatewayKey;
    gw[18].name = gwData.GatewayKey;
    gw[19].name = gwData.GatewayKey;
    gw[20].name = gwData.GatewayKey;
    gw[21].name = gwData.GatewayKey;
    gw[22].name = gwData.GatewayKey;
    gw[23].name = gwData.GatewayKey;
    gw[24].name = gwData.GatewayKey;
    gw[25].name = gwData.GatewayKey;
    gw[26].name = gwData.GatewayKey;
    gw[27].name = gwData.GatewayKey;
    gw[28].name = gwData.GatewayKey;
    gw[29].name = gwData.GatewayKey;
    gw[30].name = gwData.GatewayKey //오차범위
    gw[31].name = gwData.GatewayKey;
    gw[32].name = gwData.GatewayKey;
    gw[34].name = gwData.GatewayKey;
    gw[33].name = gwData.GatewayKey;
    gw[35].name = gwData.GatewayKey; // 오차범위
    gw[36].name = gwData.GatewayKey;
    gw[37].name = gwData.GatewayKey;
    gw[39].name = gwData.GatewayKey;
    gw[38].name = gwData.GatewayKey;
    gw[40].name = gwData.GatewayKey; // 오차범위
    gw[41].name = gwData.GatewayKey;
    gw[42].name = gwData.GatewayKey;
}
let realTime_update_GW = function(gwData){
    let gw = document.getElementsByName(gwData.GatewayKey);

    if(gw.length == 0) return

    gw[0].value = gwData.GatewayCmt;
    gw[1].value = gwData.GatewayUseYN;
    gw[2].value = gwData.inch1Select;
    gw[3].value = gwData.inch1Cmt;
    gw[4].value = gwData.inch2Select;
    gw[5].value = gwData.inch2Cmt;
    gw[6].value = gwData.inch3Select;
    gw[7].value = gwData.inch3Cmt;
    gw[8].value = gwData.inch4Select;
    gw[9].value = gwData.inch4Cmt;
    gw[10].value = gwData.inch5Select;
    gw[11].value = gwData.inch5Cmt;
    gw[12].value = gwData.inch6Select;
    gw[13].value = gwData.inch6Cmt;
    gw[14].value = gwData.outch1Select;
    gw[15].value = gwData.outch1Cmt;
    gw[16].value = gwData.outch1FeedYN// feedback on/off
    gw[17].value = "피드백";
    gw[18].value = gwData.outch2Select;
    gw[19].value = gwData.outch2Cmt;
    gw[20].value = gwData.outch2FeedYN;
    gw[21].value = "피드백2";
    gw[22].value = gwData.outch3Select;
    gw[23].value = gwData.outch3Cmt;
    gw[24].value = gwData.outch3FeedYN;
    gw[25].value = "피드백3";
    gw[26].value = gwData.tempYN;
    gw[27].value = gwData.tempCmt;
    gw[28].value = gwData.tempMin;
    gw[29].value = gwData.tempMax;
    gw[30].value = gwData.tempAgreeRange //오차범위
    gw[31].value = gwData.huYN;
    gw[32].value = gwData.huCmt;
    gw[34].value = gwData.huMax;
    gw[33].value = gwData.huMin;
    gw[35].value = gwData.huAgreeRange; // 오차범위
    gw[36].value = gwData.gasYN;
    gw[37].value = gwData.gasCmt;
    gw[39].value = gwData.gasMax;
    gw[38].value = gwData.gasMin;
    gw[40].value = gwData.gasAgreeRange; // 오차범위
    gw[41].value = gwData.GatewayKey;
    gw[42].value = gwData.GatewayName;
}

let web_building_counting = function (config, org_code, alarm, status, control, temp, hu, gas, sum) {
    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }
    let db = firebase.firestore();

    db.collection("tb_org").doc(org_code)
        .onSnapshot(function (doc) {
            if(doc.data() == undefined){
                alarm.innerHTML = 'N';
                status.innerHTML = 'N';
                control.innerHTML = 'N';
                temp.innerHTML = 'N';
                hu.innerHTML = 'N';
                gas.innerHTML = 'N';
                sum.innerHTML = 'N';
            }else{
                alarm.innerHTML = (doc.data().danger == undefined)?0:doc.data().danger;
                status.innerHTML = (doc.data().normal == undefined)?0:doc.data().normal;
                control.innerHTML = (doc.data().out == undefined)?0:doc.data().out;
                temp.innerHTML = (doc.data().temp == undefined)?0:doc.data().temp;
                hu.innerHTML = (doc.data().hum == undefined)?0:doc.data().hum;
                gas.innerHTML = (doc.data().gas == undefined)?0:doc.data().gas;
                sum.innerHTML = (doc.data().total == undefined)?0:doc.data().total;
            }
        });

}
