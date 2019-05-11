let alertModifyRealTime = function ( config, deviceSerialNoListJson, currentDateStr ) {

    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }

    var db = firebase.firestore();

    $.each ( deviceSerialNoListJson, function (i, v){

        db.collection("tb_gateway").where("SerialNo", "==", i)
            .onSnapshot(function(snapshot) {
                snapshot.docChanges.forEach(function(change) {

                    let tempStatus = 0;
                    let huStatus = 0;
                    let gasStatus = 0;

                    if (change.type === "modified") {

                        let inchSessionVal = JSON.parse(sessionStorage.getItem(change.doc.data().GatewayKey))

                        console.log(inchSessionVal)
                        console.log(change.doc.data().gas)

                        if( change.doc.data().GatewayUseYN == 1 ){  //게이트웨이를 사용 중 일 때

                            if ((change.doc.data().inch1 == 2) && (change.doc.data().inch1Select == 1))  { // inch 상태 값이 비정상이고 경보 일 때

                                if( !inchSessionVal.inch1 || inchSessionVal.inch1 == 1) {

                                    if( change.doc.data().inch1Cmt != '' ){
                                        alert( currentDateStr + " " + v.boardName + "-" + change.doc.data().inch1Cmt + "에서 경보 발생" );
                                    }else {
                                        alert( currentDateStr + " " + v.boardName + "-" + "입력1에서 경보 발생" );
                                    }

                                }

                            }

                            if ((change.doc.data().inch2 == 2) && (change.doc.data().inch2Select == 1)) {
                                if( !inchSessionVal.inch2 || inchSessionVal.inch2 == 1) {
                                    if (change.doc.data().inch2Cmt != '') {
                                        alert(currentDateStr + " " + v.boardName + "-" + change.doc.data().inch2Cmt + "에서 경보 발생");
                                    } else {
                                        alert(currentDateStr + " " + v.boardName + "-" + "입력2에서 경보 발생");
                                    }
                                }

                            }

                            if ((change.doc.data().inch3 == 2) && (change.doc.data().inch3Select == 1)) {
                                if( !inchSessionVal.inch3 || inchSessionVal.inch3 == 1) {
                                    if (change.doc.data().inch3Cmt != '') {
                                        alert(currentDateStr + " " + v.boardName + "-" + change.doc.data().inch3Cmt + "에서 경보 발생");
                                    } else {
                                        alert(currentDateStr + " " + v.boardName + "-" + "입력3에서 경보 발생");
                                    }
                                }

                            }

                            if ((change.doc.data().inch4 == 2) && (change.doc.data().inch4Select == 1)) {
                                if( !inchSessionVal.inch4 || inchSessionVal.inch4 == 1) {
                                    if (change.doc.data().inch4Cmt != '') {
                                        alert(currentDateStr + " " + v.boardName + "-" + change.doc.data().inch4Cmt + "에서 경보 발생");
                                    } else {
                                        alert(currentDateStr + " " + v.boardName + "-" + "입력14에서 경보 발생");
                                    }
                                }

                            }

                            if ((change.doc.data().inch5 == 2) && (change.doc.data().inch5Select == 1)) {
                                if( !inchSessionVal.inch5 || inchSessionVal.inch5 == 2) {
                                    if (change.doc.data().inch5Cmt != '') {
                                        alert(currentDateStr + " " + v.boardName + "-" + change.doc.data().inch5Cmt + "에서 경보 발생");
                                    } else {
                                        alert(currentDateStr + " " + v.boardName + "-" + "입력5에서 경보 발생");
                                    }
                                }

                            }

                            if ((change.doc.data().inch6 == 2) && (change.doc.data().inch6Select == 1)) {

                                if( !inchSessionVal.inch6 || inchSessionVal.inch6 == 2) {
                                    if (change.doc.data().inch6Cmt != '') {
                                        alert(currentDateStr + " " + v.boardName + "-" + change.doc.data().inch6Cmt + "에서 경보 발생");
                                    } else {
                                        alert(currentDateStr + " " + v.boardName + "-" + "입력6에서 경보 발생");
                                    }
                                }

                            }

                            if (change.doc.data().tempYN == 1) {

                                if( inchSessionVal.temp == 0 ) {
                                    if ( (change.doc.data().tempMax >= change.doc.data().temperature) &&  (change.doc.data().tempMin <= change.doc.data().temperature) ){
                                        tempStatus = 0;
                                    }else if (change.doc.data().tempMax < change.doc.data().temperature) {
                                        tempStatus = 1;
                                        alert( currentDateStr + " " + v.boardName + "-"+ "온도 최대값 초과" );
                                    }else if (change.doc.data().tempMin > change.doc.data().temperature) {
                                        tempStatus = 2;
                                        alert( currentDateStr + " " + v.boardName + "-"+ "온도 최소값 미달" );
                                    }
                                }else {
                                    if ( (change.doc.data().tempMax >= change.doc.data().temperature) &&  (change.doc.data().tempMin <= change.doc.data().temperature) ){
                                        tempStatus = 0;
                                    }else {
                                        tempStatus = inchSessionVal.temp;
                                    }
                                }

                            }

                            if (change.doc.data().huYN == 1) {

                                if( inchSessionVal.humid == 0 ) {
                                    if ( (change.doc.data().huMax >= change.doc.data().humidity) &&  (change.doc.data().huMin <= change.doc.data().humidity) ){
                                        huStatus = 0;
                                    }else if (change.doc.data().huMax < change.doc.data().humidity) {
                                        huStatus = 1;
                                        alert( currentDateStr + " " + v.boardName + "-"+ "습도 최대값 초과" );
                                    }else if (change.doc.data().huMin > change.doc.data().humidity) {
                                        huStatus = 2;
                                        alert( currentDateStr + " " + v.boardName + "-"+ "습도 최소값 미달" );
                                    }
                                }else {
                                    if ( (change.doc.data().huMax >= change.doc.data().humidity) &&  (change.doc.data().huMin <= change.doc.data().humidity) ){
                                        huStatus = 0;
                                    }else {
                                        huStatus = inchSessionVal.humid;
                                    }
                                }

                            }

                            if (change.doc.data().gasYN == 1) {

                                if( inchSessionVal.gas == 0 ) {
                                    if ( (change.doc.data().gasMax >= change.doc.data().gas) &&  (change.doc.data().gasMin <= change.doc.data().gas) ){
                                        gasStatus = 0;
                                    }else if (change.doc.data().gasMax < change.doc.data().gas) {
                                        gasStatus = 1;
                                        console.log("gas max!")
                                        alert( currentDateStr + " " + v.boardName + "-"+ "가스 최대값 초과" );
                                    }else if (change.doc.data().gasMin > change.doc.data().gas) {
                                        gasStatus = 2;
                                        console.log("gas min!")
                                        alert( currentDateStr + " " + v.boardName + "-"+ "가스 최소값 미달" );
                                    }
                                }else {
                                    if ( (change.doc.data().gasMax >= change.doc.data().gas) &&  (change.doc.data().gasMin <= change.doc.data().gas) ){
                                        gasStatus = 0;
                                    }else {
                                        gasStatus = inchSessionVal.gas;
                                    }
                                }

                            }

                        } // E : Gateway use YN

                    } // E:modify

                    let inchStatus = {
                        "inch1" : change.doc.data().GatewayName,
                        "inch1" : change.doc.data().inch1,
                        "inch2" : change.doc.data().inch2,
                        "inch3" : change.doc.data().inch3,
                        "inch4" : change.doc.data().inch4,
                        "inch5" : change.doc.data().inch5,
                        "inch6" : change.doc.data().inch6,
                        "temp" : tempStatus,
                        "humid" : huStatus,
                        "gas" : gasStatus,
                        "outch" : change.doc.data().outch1OnOff
                    }

                    sessionStorage.setItem(change.doc.data().GatewayKey, JSON.stringify(inchStatus))

                }); // E : onSnapshot.foreach
            }); // E : onSnapshot
    })
}

let updateMornViewRealTime = function ( config, deviceSerialNoListJson ) {

    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }

    var db = firebase.firestore();

    $.each ( deviceSerialNoListJson, function (i, v){

        db.collection("tb_gateway").where("SerialNo", "==", i)
            .onSnapshot(function(snapshot) {
                snapshot.docChanges.forEach(function(change) {

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
}

let updateGWViewRealTime = function ( config, deviceSerialNoListJson ) {

    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }

    var db = firebase.firestore();

    $.each ( deviceSerialNoListJson, function (i, v){

        db.collection("tb_gateway").where("SerialNo", "==", i)
            .onSnapshot(function(snapshot) {
                snapshot.docChanges.forEach(function(change) {

                    if (change.type === "added") {
                        //console.log("GW: ", change.doc.data());
                    }

                    if (change.type === "modified") {

                        if($("#inputSerialNo").val() == change.doc.data().SerialNo) {

                            for (let i = 0; i < (document.getElementById("gwList").rows.length / 2); i++) {

                                if (document.getElementsByName("gw" + i)[0].value == change.doc.data().GatewayKey) {
                                    let parent_tr = document.getElementsByName("gw" + i)[0].parentElement
                                    let parent_tr_cmt = parent_tr.nextElementSibling

                                    parent_tr.getElementsByTagName("td")[0].children[0].children[0].value = change.doc.data().GatewayUseYN
                                    if (change.doc.data().GatewayUseYN == 1) parent_tr.getElementsByTagName("td")[0].children[0].children[0].checked = true
                                    else parent_tr.getElementsByTagName("td")[0].children[0].children[0].checked = false

                                    parent_tr.getElementsByTagName("td")[2].children[0].value = change.doc.data().inch1Select

                                    parent_tr.getElementsByTagName("td")[3].children[0].value = change.doc.data().inch2Select
                                    parent_tr.getElementsByTagName("td")[4].children[0].value = change.doc.data().inch3Select
                                    parent_tr.getElementsByTagName("td")[5].children[0].value = change.doc.data().inch4Select
                                    parent_tr.getElementsByTagName("td")[6].children[0].value = change.doc.data().inch5Select
                                    parent_tr.getElementsByTagName("td")[7].children[0].value = change.doc.data().inch6Select

                                    parent_tr.getElementsByTagName("td")[8].children[0].value = change.doc.data().outch1Select
                                    parent_tr.getElementsByTagName("td")[9].children[0].value = change.doc.data().outch2Select
                                    parent_tr.getElementsByTagName("td")[10].children[0].value = change.doc.data().outch3Select

                                    parent_tr.getElementsByTagName("td")[11].value = change.doc.data().tempYN
                                    if (change.doc.data().tempYN == 1) parent_tr.getElementsByTagName("td")[11].children[0].children[0].checked = true
                                    else parent_tr.getElementsByTagName("td")[11].children[0].children[0].checked = false

                                    parent_tr.getElementsByTagName("td")[12].value = change.doc.data().huYN
                                    if (change.doc.data().huYN == 1) parent_tr.getElementsByTagName("td")[12].children[0].children[0].checked = true
                                    else parent_tr.getElementsByTagName("td")[12].children[0].children[0].checked = false

                                    parent_tr.getElementsByTagName("td")[13].value = change.doc.data().gasYN
                                    if (change.doc.data().gasYN == 1) parent_tr.getElementsByTagName("td")[13].children[0].children[0].checked = true
                                    else parent_tr.getElementsByTagName("td")[13].children[0].children[0].checked = false

                                    /*cmt*/
                                    parent_tr_cmt.getElementsByTagName("td").item(0).children[0].value = change.doc.data().GatewayCmt
                                    parent_tr_cmt.getElementsByTagName("td").item(1).children[0].value = change.doc.data().inch1Cmt
                                    parent_tr_cmt.getElementsByTagName("td").item(2).children[0].value = change.doc.data().inch2Cmt
                                    parent_tr_cmt.getElementsByTagName("td").item(3).children[0].value = change.doc.data().inch3Cmt
                                    parent_tr_cmt.getElementsByTagName("td").item(4).children[0].value = change.doc.data().inch4Cmt
                                    parent_tr_cmt.getElementsByTagName("td").item(5).children[0].value = change.doc.data().inch5Cmt
                                    parent_tr_cmt.getElementsByTagName("td").item(6).children[0].value = change.doc.data().inch6Cmt

                                    parent_tr_cmt.getElementsByTagName("td").item(7).children[0].value = change.doc.data().outch1Cmt
                                    parent_tr_cmt.getElementsByTagName("td").item(8).children[0].value = change.doc.data().outch2Cmt
                                    parent_tr_cmt.getElementsByTagName("td").item(9).children[0].value = change.doc.data().outch3Cmt

                                    parent_tr_cmt.getElementsByTagName("td").item(10).children[0].value = change.doc.data().tempCmt
                                    parent_tr_cmt.getElementsByTagName("td").item(11).children[0].value = change.doc.data().huCmt
                                    parent_tr_cmt.getElementsByTagName("td").item(12).children[0].value = change.doc.data().gasCmt

                                }
                            }

                        }

                    } // E : modified

                    if (change.type === "removed") {
                        console.log("Removed GW: ", change.doc.data());
                    }

                });
            }); // E : onSnapShot
    })
}

let updateMainViewRealTime = function ( config, deviceSerialNoListJson ) {

    if (!firebase.apps.length) {
        firebase.initializeApp(config);
    }

    var db = firebase.firestore();

    $.each ( deviceSerialNoListJson, function (i, v){

        //main I/O board
        db.collection("tb_device").where("SerialNo", "==", i)
            .onSnapshot(function(querySnapshot) {
                querySnapshot.forEach(function(doc) {

                    if($("#inputSerialNo").val() == doc.data().SerialNo){

                        $("#inputBoardName").val(doc.data().BoardName);
                        $("#inputLocation").val(doc.data().Location);
                        $("#inputMACAddr").val(doc.data().MACAddr);
                        $("#inputIPAddr").val(doc.data().IPAddr);
                        $("#inputPort").val(doc.data().Port);

                    }

                });

            });
    })
}