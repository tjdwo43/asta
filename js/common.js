function allCheckFunc( obj ) {
	$("[name=checkOne]").prop("checked", $(obj).prop("checked") );
}

/* 체크박스 체크시 전체선택 체크 여부 */
function oneCheckFunc( obj )
{
	var allObj = $("[name=checkAll]");
	var objName = $(obj).attr("name");

	if( $(obj).prop("checked") )
	{
		checkBoxLength = $("[name="+ objName +"]").length;
		checkedLength = $("[name="+ objName +"]:checked").length;

		if( checkBoxLength == checkedLength ) {
			allObj.prop("checked", true);
		} else {
			allObj.prop("checked", false);
		}
	}
	else
	{
		allObj.prop("checked", false);
	}
}

function allCheckFunc2( obj ) {
	$("[name=checkOne2]").prop("checked", $(obj).prop("checked") );
}

/* 체크박스 체크시 전체선택 체크 여부 */
function oneCheckFunc2( obj )
{
	var allObj = $("[name=checkAll2]");
	var objName = $(obj).attr("name");

	if( $(obj).prop("checked") )
	{
		checkBoxLength = $("[name="+ objName +"]").length;
		checkedLength = $("[name="+ objName +"]:checked").length;

		if( checkBoxLength == checkedLength ) {
			allObj.prop("checked", true);
		} else {
			allObj.prop("checked", false);
		}
	}
	else
	{
		allObj.prop("checked", false);
	}
}

function allCheckUser( obj ) {
	$("[name=userCheck]").prop("checked", $(obj).prop("checked") );
}

/* 체크박스 체크시 전체선택 체크 여부 */
function oneCheckUser( obj )
{
	var allObj = $("[name=userCheckAll]");
	var objName = $(obj).attr("name");

	if( $(obj).prop("checked") )
	{
		checkBoxLength = $("[name="+ objName +"]").length;
		checkedLength = $("[name="+ objName +"]:checked").length;

		if( checkBoxLength == checkedLength ) {
			allObj.prop("checked", true);
		} else {
			allObj.prop("checked", false);
		}
	}
	else
	{
		allObj.prop("checked", false);
	}
}

function multiUserCheck( obj ) {
	$("[name=org_code]").prop("checked", $(obj).prop("checked") );
}

/* 체크박스 체크시 전체선택 체크 여부 */
function multiUserOne( obj )
{
	var allObj = $("[name=org_codeAll]");
	var objName = $(obj).attr("name");

	if( $(obj).prop("checked") )
	{
		checkBoxLength = $("[name="+ objName +"]").length;
		checkedLength = $("[name="+ objName +"]:checked").length;

		if( checkBoxLength == checkedLength ) {
			allObj.prop("checked", true);
		} else {
			allObj.prop("checked", false);
		}
	}
	else
	{
		allObj.prop("checked", false);
	}
}

function JS_logout(){
	sessionStorage.clear()

	let org_name = document.getElementById("myBuildingName")

	localStorage.removeItem("i!@#")
	localStorage.removeItem("p!@#")
	localStorage.removeItem("a!@#")

	$.ajax({
		'url' : '/login/loginProc.php',
		'type' : 'post',
		'data' : {
			'mode' : 'logout',
			'org_name':org_name.value
		},
		success : function(){
			if(window.location.pathname.split('/')[1] == 'm'){
				window.location.href="/m";
			}else {
				window.location.href="/loginView.php";
			}
		}
	});
}

function timeLogout(){
	alert("장시간 사용을 안하여 자동 로그아웃되었습니다.");
	$.ajax({
		'url' : '/login/loginProc.php',
		'type' : 'post',
		'data' : {
			'mode' : 'logout'
		},
		success : function(){
			window.location.href="/index.php";
		}
	});
}

function movetop(){
	$('html, body').animate({
		scrollTop : 0
	}, 400);

	return false;
}

var buildingList = function ( ) {
	var buildingJsonList

	$.ajax({
		'url': '/building/buildingProc.php',
		'type': 'post',
		'data': {
			'mode': 'getBuildingList'
		},
		success : function (data) {
			let buildData = JSON.parse(data)
			let buildListHtml = ''
			if(buildData.data == null) {
				buildListHtml += '<li>'
				buildListHtml += '	<div class="d-inline-block" >'
				buildListHtml += '		<div class="font-weight-bold">데이터가 없습니다.</div>'
				buildListHtml += '	</div>'
				buildListHtml += '</li>'
				$(".buildingList").html(buildListHtml)

				return
			}

			//lastSession
			if(sessionStorage.getItem('selectedLastBidg') == null) {
				sessionStorage.setItem("selectedLastBidg", JSON.stringify(buildData.lastBuildingInfo))

				//document.getElementById("curBuildingName").innerHTML = buildData.lastBuildingInfo.org_name
			}

			$.each(buildData.data, function(k, v){
				let org_name = (v.org_name == '')?'미입력':v.org_name
				let addr = replaceAll(v.address, "///", "<br>");

				buildListHtml += '<li  onclick="selectBuildItem(\''+v.org_code+'\',\''+v.org_name+'\');">'
				buildListHtml += '	<div class="d-inline-block" >'
				buildListHtml += '		<div class="font-weight-bold">'+org_name+'</div>'
				buildListHtml += '		<div>'+addr+'</div>'
				buildListHtml += '	</div>'
				buildListHtml += '<div id="'+v.org_code+'" class="status-nomal d-inline-block float-right">0/0</div>'
				buildListHtml += '</li>'
			})
			$(".buildingList").html(buildListHtml)

			statusCounting(config, buildData.data)
		},
		beforeSend : function(){
			$(".buildingList").addClass("whirl traditional");
		},
		complete : function(){
			$(".buildingList").removeClass("whirl traditional");
		}
	})
}

var setBuldingSession = function() {
	var buildingJsonList

	$.ajax({
		'url': '/building/buildingProc2.php',
		'type': 'post',
		'data': {
			'mode': 'getBuildingList'
		},
		success: function (data) {
			let buildData = JSON.parse(data)
			let buildListHtml = ''
			if (buildData.data == null) return

			console.log("building", buildData)

			// //lastSession
			 if (sessionStorage.getItem('selectedLastBidg') == null) {
			 	sessionStorage.setItem("selectedLastBidg", JSON.stringify(buildData.lastBuildingInfo))
			 	document.getElementById("curBuildingName").innerHTML = buildData.lastBuildingInfo.org_name
				document.getElementById("curBldgCount").dataset.orgcode = buildData.lastBuildingInfo.org_code

				headerCounting()
			 }
		}
	})
}

var userList = function() {
	$.ajax({
		'url': '/user/userAjaxProc.php',
		'type': 'post',
		'data': {
			'mode': 'getUserListM',
			'orgCode': JSON.parse(sessionStorage.getItem('selectedLastBidg')).org_code
		},
		success : function (data) {
			let userData = JSON.parse(data)
			let userListHtml = ''
			let topAuth = 0

			userData.data.sort(function(a,b){
				return a.auth > b.auth ? -1 : a.auth < b.auth ? 1 : 0;
			});

			$.each(userData.data, function(k, v) {
				if(topAuth < v.auth) topAuth = v.auth
			})

			console.log(userData)
			$.each(userData.data, function(k, v){
				let topAuthMark = ''
				let phoneVal = (v.phone == null|| v.phone == "")?"미입력":v.phone
				let gradeVal = (v.grade == null|| v.grade == "")?"미입력":v.grade
				let departVal = (v.depart == null || v.depart == "")?"미입력":v.depart
				//console.log(v)

				if(topAuth == v.auth ) topAuthMark = "fa fa-circle text-danger"

				userListHtml += '<tr>'
				userListHtml += '	<td><em class="'+topAuthMark+'"></em></td>'
				userListHtml += '	<td>'+v.name+'</td>'
				userListHtml += '	<td>'+departVal+'</td>'
				userListHtml += '	<td>'+gradeVal+'</td>'
				userListHtml += '	<td><a href="tel://'+v.phone+'">'+ phoneVal +'</a></td>'
				userListHtml += '</tr>'
			})

			$("tbody").html(userListHtml)
		},
		beforeSend : function(){
			$("tbody").addClass("whirl traditional");
		},
		complete : function(){
			$("tbody").removeClass("whirl traditional");
		}
	})
}

var moveTopMenu = function(path) {
	/*
	var form = document.createElement("form");
	var element1 = document.createElement("input");
	var element2 = document.createElement("input");

	form.method = "POST";
	form.action = path;
	form.classList.add('d-none')

	element1.value= serialNo;
	element1.name="paramSerialNo";
	form.appendChild(element1);

	document.body.appendChild(form);

	form.submit();
	 */
}

var selectBuildItem = function(orgCode, org_name) {
	let selectedDeivceData = {
		"org_code": orgCode,
		"org_name": org_name
	}

	sessionStorage.setItem("selectedLastBidg", JSON.stringify(selectedDeivceData))

	$.ajax({
		'url': '/building/buildingProc.php',
		'type': 'post',
		'data':{
			'mode': 'setLastBidg',
			'org_code': orgCode
		},
		success: function(data){
			if(JSON.parse(data).result == "0"){
				window.location.href= "/m/monitoringView.php"
			}
			else {
				alert("서버오류")
			}
		}
	})

	//sessionStorage.setItem("selectedDeivceData", JSON.stringify(selectedDeivceData))
}

var changePassword = function() {
	let currentPasswd = document.getElementById("currentPasswd")
	let newPasswd = document.getElementById('newPasswd')
	let confirmNewPasswd = document.getElementById("confirmNewPasswd")

	let validateYN = ($("#currentPasswd").parsley().isValid() && $("#newPasswd").parsley().isValid()
		&& $("#confirmNewPasswd").parsley().isValid())

	$("#notMatch").addClass("d-none")
	$("#currentPasswd").parsley().validate()
	$("#newPasswd").parsley().validate()
	$("#confirmNewPasswd").parsley().validate()

	if(!validateYN) {return}

	$.ajax({
		'url': '/login/loginProc.php',
		'type': 'post',
		'data': {
			'mode': 'mobileCheckPasswd',
			'currentPasswd': currentPasswd.value
		},
		success: function(data){
			$("#notMatch").addClass("d-none")
			if (data == 0){
				$.ajax({
					'url': '/user/userAjaxProc.php',
					'type': 'post',
					'data': {
						'mode': 'changePasswd',
						'newPasswd': newPasswd.value
					},
					success: function(data){
						//console.log(data)
						if(data == '0') {
							alert("비밀번호가 변경 되었습니다.")
							window.location.reload()
						}
						else alert("비밀번호 변경에 실패하였습니다.")
					}
				})
			}else{
				$("#notMatch").removeClass("d-none")
			}
		}
	})
}

let writeLog = function(comment, serialNo, gwKey, chNo, type, gwCmt){
	var bldgName = document.getElementById("myBuildingName").value;

	console.log("cmt", comment)
	console.log("sn", serialNo)
	console.log("gw", gwKey)
	console.log("chNo", chNo)
	console.log("type", type)
	console.log("gwCmt", gwCmt)

	$.ajax({
		'url': '/log/logAjaxProc.php',
		'type': 'post',
		'data': {
			'mode': "writeAlarmLog",
			'comment': comment,
			'serialNo': serialNo,
			'gwKey': gwKey,
			'chNo': chNo,
			'type': type,
			'bldgName':bldgName,
			"gwCmt":gwCmt
		},
		success: function(data){
			if(data == '0'){
				console.log(chNo + " " + type + " " + "save log")
			}
			else{
				console.log(chNo + " " + type + " " + 'do not save log')
			}
		}
	})
}

let getMobileLog = function() {
	let sDate = document.getElementById('input-sDate').value
	let eDate = document.getElementById('input-eDate').value
	let key = getParameter('key')
	let gwKey = getParameter('gwKey')

	var start_dates = sDate.split("-");
	var end_dates = eDate.split("-");

	var date1 = new Date(start_dates[0],start_dates[1],start_dates[2]).valueOf();
	var date2 = new Date(end_dates[0],end_dates[1],end_dates[2]).valueOf();

	if((date2 - date1) < 0){
		alertMessage("시작 시간이 종료시간보다 큽니다.")
		return;
	}

	if(key == undefined) key = ''
	if(gwKey == undefined) gwKey = ''

	$.ajax({
		'url': '/log/logAjaxProc.php',
		'type': 'post',
		'data': {
			'mode': "getMobileHistory",
			'sDate': sDate,
			'eDate': eDate,
			'key': key,
			'gwKey': gwKey
		},
		success: function(data){
			let logData = JSON.parse(data)
			let logHtml = ''

			if(logData != null) {
				if(logData.data != null){
					console.log("1")
					$.each(logData.data, function(i, v){
						let typeMessage = '';
						let typeColor = '';

						switch (v.type) {
							case '1' : typeMessage = "경보"; break;
							case '2' : typeMessage = "상태"; break;
							case '3' : typeMessage = "제어"; break;
							case '4' : typeMessage = "온도"; break;
							case '5' : typeMessage = "습도"; break;
							case '6' : typeMessage = "가스"; break;
							case '7' : typeMessage = "기타"; break;
						}

						if(v.message.indexOf("경보 발생") != -1){
							typeColor = "text-danger"
						}else if(v.message.indexOf("경보 해제") != -1){
							typeColor = "text-info"
						}

						logHtml += "<tr>"
						logHtml += "<td>"
						logHtml += v.regdate.split(" ")[0].replace(/-/gi, ".")+"<br>"
						logHtml += v.regdate.split(" ")[1].substring( -2, 8)
						logHtml += "</td>"
						logHtml += "<td>"
						logHtml += typeMessage
						logHtml += "</td>"
						logHtml += "<td class='"+typeColor+"'>"
						logHtml += v.message
						logHtml += "</td>"
						logHtml += "</tr>"
					})
				}else{
					console.log("test")
					logHtml += "<tr><td colspan='3'>데이터가 없습니다.</td></tr>"
				}
			}else{
				logHtml += "<tr><td colspan='3'>데이터가 없습니다.</td></tr>"
			}

			$('tbody').html(logHtml)
		}
	})

}

let moveInchLog = function(key, gatewayKey){
	window.location=href="/m/logView.php?key="+key+"&gwKey="+gatewayKey
	//console.log(key, gatewayKey)
}

let outchControl = function(serialNo, gatewayKey, outch1, outch2, outch3, clickedOutch, org_code, type, chType, cmt){	//show out control modal
	document.getElementById("m_sn").value = serialNo
	document.getElementById("m_gw").value = gatewayKey
	document.getElementById("m_out1").value = outch1
	document.getElementById("m_out2").value = outch2
	document.getElementById("m_out3").value = outch3
	document.getElementById("m_selected").value = clickedOutch

	$.ajax({
		"url":"/log/logAjaxProc.php",
		"type":"post",
		"data":{
			"mode":"getOneLogView",
			"org_code": org_code,
			"SerialNo": serialNo,
			"GatewayKey": gatewayKey,
			"type": type,
			"chType": chType
		},
		success:function (data) {
			let message = JSON.parse(data).data

			document.getElementById("outControlregDate").innerHTML = message[0].regdate.substring(0,19)
			document.getElementById("outRecentHistory").innerHTML = message[0].message

		}
	})

	if(cmt != ""){
		document.getElementById("outch-title").innerHTML = cmt
	}else{
		document.getElementById("outch-title").innerHTML = "미입력"
	}

	$("#inlineradio2").prop("checked", true)


	$("#outControlModal").modal({backdrop: 'static', keyboard: false});
}

let saveOutChVal = function(){
	let serialNo = document.getElementById("m_sn").value
	let gatewayKey = document.getElementById("m_gw").value
	let outch1Val = document.getElementById("m_out1").value
	let outch2Val = document.getElementById("m_out2").value
	let outch3Val = document.getElementById("m_out3").value
	let selected = document.getElementById("m_selected").value

	let useYn = '0';
	if(document.getElementsByName("useYN")[0].checked == true) useYn = '1'
	else useYn = '2'

	if(selected == '1') outch1Val = useYn
	else if(selected == '2') outch2Val = useYn
	else if(selected == '3') outch3Val = useYn

	$.ajax({
		url : "/device/deviceAjaxProc.php",
		type : 'post',
		data : {
			'mode' : "updateOutch",
			'SerialNo' : serialNo,
			'GatewayKey' : gatewayKey,
			'outch1' : outch1Val,
			'outch2' : outch2Val,
			'outch3' : outch3Val,
			'outResult1' : '2',
			'outResult2' : '2',
			'outResult3' : '2'
		},
		success : function(data){
			if(data == 0){
				alertMessage("제어되었습니다.");

				$("#outControlModal").modal('hide');
			}
		},
		beforeSend : function(){
			$(".wrapper").addClass("whirl traditional");
		},
		complete : function(){
			$(".wrapper").removeClass("whirl traditional");
		}
	});
};

let autoLogin = function() {
	let currentPath = window.location.pathname.split('/')[2]
	let failedLogin = getParameter('f')

	if(failedLogin == '1'){
		localStorage.removeItem('i!@#')
		localStorage.removeItem('p!@#')
		localStorage.removeItem('a!@#')
	}

	setTimeout(function(){

		if(localStorage.getItem("a!@#") == 'true'){
			document.getElementById('id').value = localStorage.getItem('i!@#')
			document.getElementById('passwd').value = localStorage.getItem('p!@#')

			document.getElementById("loginFrm").submit()
		}

	}, 100);
};

let logIn = function() {
	let loginForm = document.getElementById("loginFrm")
	let id = document.getElementById("id")
	let passwd = document.getElementById("passwd")
	let autoCheckbox = document.getElementById('autoCheckbox')

	if(autoCheckbox.checked){
		localStorage.setItem("i!@#", id.value)
		localStorage.setItem("p!@#", passwd.value)
		localStorage.setItem("a!@#", true)
	}

	loginForm.submit()
};

let monitoringSectionBlock = function(){
	document.getElementsByTagName("section")[0].classList.remove("d-none")
	document.getElementsByTagName("section")[0].classList.add("d-block")

	document.getElementsByTagName("section")[1].classList.remove("d-none")
	document.getElementsByTagName("section")[1].classList.add("d-block")

	document.getElementsByTagName("section")[2].classList.remove("d-none")
	document.getElementsByTagName("section")[2].classList.add("d-block")

	document.getElementsByTagName("section")[3].classList.remove("d-none")
	document.getElementsByTagName("section")[3].classList.add("d-block")

	document.getElementsByTagName("body")[0].classList.remove('whirl', 'traditional')
};

let setMenuScroll = function(){
	let scrollLeftoffset = $('nav').scrollLeft()
	sessionStorage.setItem("scroll_w", scrollLeftoffset)
};

let mobileNavigationDiv = function(){
	let currentPath = window.location.pathname.split('/')[2]
	let mobileNav = document.createElement("div")
	mobileNav.classList.add("mobileNav")

	let widthScroll = sessionStorage.getItem("scroll_w")

	if(currentPath == 'buildingView.php' ){
		document.getElementById("nav-building").prepend(mobileNav)
		//widthScroll = document.getElementById("nav-building").offsetLeft
	}else if(currentPath == 'monitoringView.php' ) {
		document.getElementById("nav-monitoring").prepend(mobileNav)
		//widthScroll = document.getElementById("nav-monitoring").offsetLeft
	}else if(currentPath == 'logView.php' ) {
		document.getElementById("nav-log").prepend(mobileNav)
		//widthScroll = document.getElementById("nav-log").offsetLeft
	}else if(currentPath == 'userView.php' ) {
		document.getElementById("nav-user").prepend(mobileNav)
		//widthScroll = document.getElementById("nav-user").offsetLeft
	}else if(currentPath == 'changePasswd.php' ) {
		document.getElementById("nav-passwd").prepend(mobileNav)
		//widthScroll = document.getElementById("nav-passwd").offsetLeft
	}

	$('nav').scrollLeft( widthScroll )
};

let update_MainDevice = function(){	//디바이스 수정
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

	if(serialNo.textContent == "") {
		alertMessage("선택 된 장비가 없습니다.")
		return;
	}

    $.ajax("/device/deviceAjaxProc.php", {
        "type":"post",
        "data":{
            "mode": "updateDevice",
            "SerialNo":serialNo.textContent,
            "BoardName":buildingName.value,
            "location":location.value,
            "IPAddr":ip.textContent,
            "Port":port.textContent,
            "useYN":useYN.value,
            "DeviceId":deviceId.value,
            "MACAddr":mac.textContent,
            "cmt":cmt.value,
			"deviceOrgCode": deviceOrgCode.value
        },
        success: function (data) {
        	if(data == '0') alertMessage("수정하였습니다.");
        	else alertMessage("수정에 실패하였습니다.")
        }
    })
};

let deleteMainDevice = function(){	//디바이스 삭제
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

	if(serialNo.textContent == "") {
		alertMessage("선택 된 장비가 없습니다.")
		return;
	}

    $.ajax("/device/deviceAjaxProc.php", {
        "type":"post",
        "data":{
            "mode": "allDeleteGW",
            "serialNo":serialNo.textContent,
			"deviceOrgCode": deviceOrgCode.value
        },
        success: function (data) {
            if(data == "0"){
                $.ajax("/device/deviceAjaxProc.php", {
                    "type":"post",
                    "data":{
                        "mode": "deleteDevice",
                        "serialNo":serialNo.textContent,
                        "BoardName":buildingName.value,
                        "Location":location.value,
                        "IPAddr":ip.textContent,
                        "Port":port.textContent,
                        "useYN":useYN.value,
                        "DeviceId":deviceId.value,
                        "MACAddr":mac.textContent,
                        "cmt":cmt.value,
						"deviceOrgCode": deviceOrgCode.value
                    },
                    success: function (data) {
                        if(data == "0"){
							deleteMessage("장비를 삭제하였습니다.");
                        }else{
							deleteMessage("GW를 삭제하였습니다. 장비는 삭제 되지 않았습니다.");
                        }
                    }
                })
            }else {
                alertMessage("삭제에 실패하였습니다.")
            }
        }
    })
};

let registDevice = function () {
	let buildingName = document.getElementById("modalBuildingName").value;
	let location = document.getElementById("modalLocation").value;
	let cmt = document.getElementById("modalCmt").value;
	let serialNo = document.getElementById("modalSerialNo").value;
	let mac = document.getElementById("modalMAC").value;
	let ip = document.getElementById("modalIP").value;
	let port = document.getElementById("modalPort").value;
	let org_code = document.getElementById("select-buildingName").value;

	$.ajax("/device/deviceAjaxProc.php", {
		"type":"post",
		"data":{
			"mode": "registDevice",
			"SerialNo":serialNo,
			"BoardName":buildingName,
			"Location":location,
			"DeviceId":"1",
			"MACAddr":mac,
			"IPAddr":ip,
			"Port":port,
			"useYN":"1",
			"cmt":cmt,
			"org_code":org_code
		},
		success: function (data) {
			if(data == "0"){
				alertMessage("등록에 성공하였습니다.")
				window.location.reload();
			}else {
				alertMessage("등록에 실패하였습니다.")
			}
		}
	})

};

let modifyGateway = function (index) {
	let gwId = "gw"+index;
	let gwData = document.getElementsByClassName(gwId);

	let serialNo = document.getElementById("textBidgSN").textContent;
	let org_code = document.getElementById("textDeviceOrgCode").value;
	let org_name = document.getElementById("textbidgName").value;

	$.ajax("/device/deviceAjaxProc.php", {
		"type":"post",
		"data":{
			'mode' : "updateGW",
			'SerialNo' : serialNo,
			'GatewayKey' : gwData[41].value,
			'GatewayUseYN' : gwData[1].value,
			'GatewayName' : gwData[42].value,
			'inch1Select' : gwData[2].value,
			'inch2Select' : gwData[4].value,
			'inch3Select' : gwData[6].value,
			'inch4Select' : gwData[8].value,
			'inch5Select' : gwData[10].value,
			'inch6Select' : gwData[12].value,

			'outch1Select' : gwData[14].value,
			'outch2Select' : gwData[18].value,
			'outch3Select' : gwData[22].value,

			'tempYN' : gwData[26].value,
			'huYN' : gwData[31].value,
			'gasYN' : gwData[36].value,

			'GatewayCmt' : gwData[0].value,

			'inch1Cmt' : gwData[3].value,
			'inch2Cmt' : gwData[5].value,
			'inch3Cmt' : gwData[7].value,
			'inch4Cmt' : gwData[9].value,
			'inch5Cmt' : gwData[11].value,
			'inch6Cmt' : gwData[13].value,

			'outch1Cmt' : gwData[15].value,
			'outch2Cmt' : gwData[19].value,
			'outch3Cmt' : gwData[23].value,

			'tempCmt' : gwData[27].value,
			'huCmt' : gwData[32].value,
			'gasCmt' : gwData[37].value,

			//온도 값
			'tempMax' : gwData[29].value,
			'tempMin' : gwData[28].value,
			//습도 값
			'huMax' : gwData[34].value,
			'huMin' : gwData[33].value,
			//가스 값
			'gasMax' : gwData[39].value,
			'gasMin' : gwData[38].value,

			"outch1FeedYN":gwData[16].value,
			"outch2FeedYN":gwData[20].value,
			"outch3FeedYN":gwData[24].value,
			"tempAgreeRange":gwData[30].value,
			"huAgreeRange":gwData[35].value,
			"gasAgreeRange":gwData[40].value,
			"org_code":org_code,
			'org_name':org_name

		},
		success: function (data) {
			document.getElementById("tabCond").value = "1"
			if(data == "0"){
				alertMessage("저장 되었습니다.")
			}else {
				alertMessage("저장에 실패하였습니다.")
			}
		}
	})
};

let modifyGatewayTab = function () {
	document.getElementById("tabCond").value = "1"

	let index = document.getElementById("pastIndex").value;

	let gwId = "gw"+index;
	let gwData = document.getElementsByClassName(gwId);

	let serialNo = document.getElementById("textBidgSN").textContent;
	let org_code = document.getElementById("textDeviceOrgCode").value;
	let org_name = document.getElementById("textbidgName").value;

	$.ajax("/device/deviceAjaxProc.php", {
		"type":"post",
		"data":{
			'mode' : "updateGW",
			'SerialNo' : serialNo,
			'GatewayKey' : gwData[41].value,
			'GatewayUseYN' : gwData[1].value,
			'GatewayName' : gwData[42].value,
			'inch1Select' : gwData[2].value,
			'inch2Select' : gwData[4].value,
			'inch3Select' : gwData[6].value,
			'inch4Select' : gwData[8].value,
			'inch5Select' : gwData[10].value,
			'inch6Select' : gwData[12].value,

			'outch1Select' : gwData[14].value,
			'outch2Select' : gwData[18].value,
			'outch3Select' : gwData[22].value,

			'tempYN' : gwData[26].value,
			'huYN' : gwData[31].value,
			'gasYN' : gwData[36].value,

			'GatewayCmt' : gwData[0].value,

			'inch1Cmt' : gwData[3].value,
			'inch2Cmt' : gwData[5].value,
			'inch3Cmt' : gwData[7].value,
			'inch4Cmt' : gwData[9].value,
			'inch5Cmt' : gwData[11].value,
			'inch6Cmt' : gwData[13].value,

			'outch1Cmt' : gwData[15].value,
			'outch2Cmt' : gwData[19].value,
			'outch3Cmt' : gwData[23].value,

			'tempCmt' : gwData[27].value,
			'huCmt' : gwData[32].value,
			'gasCmt' : gwData[37].value,

			//온도 값
			'tempMax' : gwData[29].value,
			'tempMin' : gwData[28].value,
			//습도 값
			'huMax' : gwData[34].value,
			'huMin' : gwData[33].value,
			//가스 값
			'gasMax' : gwData[39].value,
			'gasMin' : gwData[38].value,

			"outch1FeedYN":gwData[16].value,
			"outch2FeedYN":gwData[20].value,
			"outch3FeedYN":gwData[24].value,
			"tempAgreeRange":gwData[30].value,
			"huAgreeRange":gwData[35].value,
			"gasAgreeRange":gwData[40].value,
			"org_code":org_code,
			'org_name':org_name

		},
		success: function (data) {
			if(data == "0"){
				alertMessage("저장되었습니다.")
				$("#changeModal").modal("hide");

			}else {
				alertMessage("수정에 실패하였습니다.")
				$("#changeModal").modal("hide");
			}
		}
	})
};

let org_deviceLocation = function(org ){
	console.log("deviceconf load")
	$.ajax({
		"url": "/device/deviceAjaxProc.php",
		"type": "post",
		"data":{
			"mode":"getMainDevice",
			"org_code":org,
			'dvcsBldn': true
		},
		success:function(data){
			let deviceList = JSON.parse(data).data

			let replaceMinArr = []

			for(k in deviceList){
				replaceMinArr.push({text:deviceList[k].Location, value:deviceList[k].SerialNo})
			}

			$("#deviceLocation").replaceOptions(replaceMinArr)

			web_device_conf_search();
		}
	})
}
/* ============================= S:건물 ========================== */
let duplicateBIdgCheck = function() {// 중복체크
	let name = document.getElementsByName("buildingName")[0].value
	let checkYN = document.getElementsByName("bIdgCheck")[0]

	if(name == '') {
		alertMessage("건물 명을 입력 해주세요.")
		return
	}

	$.ajax({
		'url':'/building/buildingProc.php',
		'type': 'post',
		'data': {
			"mode":"duplicateBIdgName",
			"org_name": name
		},
		success:function (data) {
			if(data == 0){
				checkYN.value = "0"
				alertMessage("사용 가능한 건물 명입니다.");
			}else{
				checkYN.value = "0"
				alertMessage("사용 불가능한 건물 명입니다.")
			}
		}
	})
}

let initDuplicateFeild = function(val){
	let duplicateName = document.getElementsByName("duplicateName")[0].value
	let duplicateBtn = document.getElementById("duplicateBtn");
	let duplicateBtnCheck = document.getElementsByName("bIdgCheck")[0]
	let mode = document.getElementById("modal-mode");

	duplicateBtnCheck.value = "1";

	if(mode.value == "updateBidg"){
		if(duplicateName == val){
			duplicateBtn.disabled = true
		}
		else {
			duplicateBtn.disabled = false
		}
	}

}

let checkNoExpire = function(){
	let checkNoExpire = document.getElementById("noneDate")

	if(checkNoExpire.checked == true){
		document.getElementById("input-eDate").value = "29991231"
	}else {
		document.getElementById("input-eDate").value = ""
	}

}

let bIdgChecked = function () {
	let modifyCheck = document.getElementsByName("modifyName");
	let org_code;

	//console.log(modifyCheck);
	for(k in modifyCheck) {
		if (modifyCheck[k].checked == true) {
			let trEle = modifyCheck[k].parentElement.parentElement.parentElement.parentElement;
			let tdEle = trEle.getElementsByTagName('td')
			org_code = tdEle[1].getElementsByTagName("input")[0].value;
		}
	}

	if(org_code == undefined || org_code == null) {
		return "1"
	}

	return "0"
}

let modifyBidg = function(){
	let bidgChecked = bIdgChecked();

	document.getElementById("duplicateBtn").disabled = true;

	if(bidgChecked == "1"){
		alertMessage("건물을 선택 해 주세요.")
		return
	}

	document.getElementsByClassName('modal-title')[0].innerHTML = "건물 수정";
	document.getElementById('saveBtn').innerHTML = "수정"

	let address1 = document.getElementsByName("addr1")[0];
	let address2 = document.getElementsByName("addr2")[0];
	let org_name = document.getElementsByName("buildingName")[0];
	let sDate = document.getElementById("input-sDate");
	let eDate = document.getElementById("input-eDate");
	let undergroundFloor = document.getElementsByName("floorNum")[0];
	let groundFloor = document.getElementsByName("floorNum")[1];
	let floorSpace = document.getElementsByName("floorSpace")[0];
	let noneDate = document.getElementById("noneDate");
	let org_code = document.getElementById("modal-orgCode");
	let mode = document.getElementById("modal-mode");
	let checkYN = document.getElementsByName("bIdgCheck")[0]  //중복체크 필드
	let duplicateName = document.getElementsByName("duplicateName")[0];

	mode.value = "updateBidg";

	address1.value = '';
	address2.value = '';
	org_name.value = '';
	sDate.value = '';
	eDate.value = '';
	undergroundFloor.value = '';
	groundFloor.value = '';
	floorSpace.value = "";
	noneDate.checked = false;

	checkYN.value = "0";

	let modifyCheck = document.getElementsByName("modifyName");
	//console.log(modifyCheck);
	for(k in modifyCheck) {
		if (modifyCheck[k].checked == true) {
			let trEle = modifyCheck[k].parentElement.parentElement.parentElement.parentElement;
			let inputEle = trEle.getElementsByTagName("input")
			let tdEle = trEle.getElementsByTagName('td')
			let tdBuildingName = tdEle[2].textContent;
			let tdAddress = tdEle[3].textContent;
			let tdSdate = tdEle[4].textContent;
			let tdEdate = tdEle[5].textContent;
			//let tdFloor = tdEle[6].textContent;
			let tdBsize = tdEle[7].textContent;

			address1.value = inputEle[3].value;
			address2.value = inputEle[4].value;
			org_name.value = tdBuildingName;
			sDate.value = tdSdate;
			eDate.value = tdEdate;
			undergroundFloor.value = inputEle[0].value;
			groundFloor.value = inputEle[1].value;
			duplicateName.value = tdBuildingName;

			if(inputEle[2].value == '1'){
				noneDate.checked = true;
				tdEdate = "29991231"
			}else if(inputEle[2].value == '2'){
				noneDate.checked = false;
			}
			floorSpace.value = tdBsize.substring(0, tdBsize.length-2);
			org_code.value = tdEle[1].getElementsByTagName("input")[0].value;

			meterToP(Number(floorSpace.value))
		}
	}

	$("#buildingRegist").modal({backdrop: 'static', keyboard: false});
}

let registBuilding = function(){
	let address = document.getElementsByName("addr1")[0].value + "///" + document.getElementsByName("addr2")[0].value
	let org_name = document.getElementsByName("buildingName")[0]
	let sDate = document.getElementById("input-sDate");
	let eDate = document.getElementById("input-eDate");
	let groundFloor = document.getElementsByName("floorNum")[0];
	let undergroundFloor = document.getElementsByName("floorNum")[1];
	let floorSpace = document.getElementsByName("floorSpace")[0];
	let noneDate = document.getElementById("noneDate");
	let org_code = document.getElementById("modal-orgCode");
	let mode = document.getElementById('modal-mode');

	let expireField = "";

	let floor = groundFloor.value + "," + undergroundFloor.value;

	let checkYN = document.getElementsByName("bIdgCheck")[0]  //중복체크 필드

	/*
    $('[name=buildingName]').parsley().validate();
    $('#sDate').parsley().validate();
    $('#eDate').parsley().validate();


    if(
        !$('#sDate').parsley().isValid()&&
        !$('#eDate').parsley().isValid())
    {
        return;
    }
*/
	if(mode.value == "updateBidg"){
		let duplicateName = document.getElementsByName("duplicateName")[0]

		if(duplicateName.value == org_name){
			checkYN.value = "0"
		}
	}

	if(noneDate.checked == true){
		eDate.value = '29991231';
		expireField = "1"
	}else{
		expireField = "2"
	}
	//유효성

	let paramsDate = sDate.value.replace(/-/gi, "");
	let parameDate = eDate.value.replace(/-/gi, "");

	if(org_name.value == '') {
		alertMessage("건물 명을 입력 해주세요.")
		return
	}

	if(paramsDate == ''){
		alertMessage("계약 날짜를 입력 해주세요.")
		return
	}

	if(parameDate == ''){
		alertMessage("계약 날짜를 입력 해주세요.")
		return
	}

	if(checkYN.value != "0") {
		alertMessage("중복 검사를 해주세요");
		return;
	}

	let check_item = document.getElementsByName('checkOne');
	let orgCheckArray = [];
	for(let k in check_item){
		if(check_item[k].checked === true){
			const orgCheckJson = {};
			orgCheckJson.org_name = check_item[k].value.split("_")[1];
			orgCheckJson.org_code = check_item[k].value.split("_")[0];
			orgCheckArray.push(orgCheckJson);
		}
	}

	$.ajax({
		"url":"/building/buildingProc.php",
		"type":"post",
		"data":{
			"mode": mode.value,
			"address": address,
			"conStartDate": paramsDate,
			"conEndDate": parameDate,
			"floor": floor,
			"bSize": floorSpace.value,
			"org_name": org_name.value,
			"org_code":org_code.value,
			"noExpire":expireField
		},
		success: function (data) {
			let registInfo = JSON.parse(data);
			let orgCheckJson = {};
			orgCheckJson.org_name = org_name.value;
			if(org_code.value)
				orgCheckJson.org_code = org_code.value;
			else
				orgCheckJson.org_code = registInfo.data.org_code;
			orgCheckArray.push(orgCheckJson);
			let strJson = JSON.stringify(orgCheckArray);

			if(data){
				alertMessageR("처리되었습니다.");
				setHeaderName(JSON.parse(strJson));
				getHeaderName();
			}else{
				alertMessageR("건물 등록에 실패하였습니다.")
			}
		}
	});
}

let getBuidlingListView = function( config ){
	console.log("건물리스트 가져오기");
	let listData;

	//let check_item = document.querySelectorAll('[name=checkOne]')

	let check_item = document.getElementsByName("checkOne")

	let tbodyDom = document.getElementById("building_tbody");

	tbodyDom.innerHTML = ''

	$.ajax({
		"url":"/building/buildingProc.php",
		"type": "post",
		"data": {
			"mode":"getBuildingList"
		},
		success: function (data) {
			console.log("all checkbox", check_item)
			let bidgArr = [];
			let orgArr = [];

			listData = JSON.parse(data).data;

			for (let k = 0; k < check_item.length; k++) {
				if(check_item[k].checked == true){
					let org_name = check_item[k].value.split("_")[1];
					let org_code = check_item[k].value.split("_")[0];

					let org = {
						org_name:org_name,
						org_code:org_code
					}

					orgArr.push(org)

					for(i in listData){
						if(org_code == listData[i].org_code){
							bidgArr.push(listData[i]);
						}
					}
				}
			}

			setHeaderName(orgArr)
			getHeaderName();

			for(b in bidgArr){
				let tr_dom = document.createElement("tr");

				let uInput = document.createElement('input')
				let fInput = document.createElement('input')

				let firstAddressInput = document.createElement('input');
				let secondAddressInput = document.createElement('input');

				let noExpire = document.createElement("input")

				let td_check_div = document.createElement("div");
				let td_check_label = document.createElement("label");
				let td_check_label_input = document.createElement("input");
				let td_check_lable_span = document.createElement("span");

				let td_No = document.createElement("td");
				let td_check = document.createElement("td");
				let td_orgName = document.createElement("td");
				let td_addr = document.createElement("td");
				let td_sDate = document.createElement("td");
				let td_eDate = document.createElement("td");

				let td_floor = document.createElement("td");
				let td_bSize = document.createElement("td");

				let td_alarm = document.createElement("td");
				let td_status = document.createElement("td");
				let td_control = document.createElement("td");
				let td_temp = document.createElement("td");
				let td_hu = document.createElement("td");
				let td_gas = document.createElement("td");
				let td_sum = document.createElement("td");

				//================== 지상 지하 ====================//
				let unFloor = bidgArr[b].floor.split(",")[0];
				let groundFloor = bidgArr[b].floor.split(",")[1];

				uInput.value = unFloor;
				fInput.value = groundFloor;
				noExpire.value = bidgArr[b].noExpire;

				uInput.type = "hidden";
				fInput.type = "hidden";
				noExpire.type = "hidden";
				firstAddressInput.type = "hidden";
				secondAddressInput.type = "hidden";

				///////////////////////////////////////////////////////////

				//address//
				if(bidgArr[b].address.split("///")[0] == undefined || bidgArr[b].address.split("///")[0] == ''){
					firstAddr = '';
				}else{
					firstAddr = bidgArr[b].address.split("///")[0];
				}

				if(bidgArr[b].address.split("///")[1] == undefined || bidgArr[b].address.split("///")[1] == ''){
					secondAddr = '';
				}else{
					secondAddr = bidgArr[b].address.split("///")[1];
				}

				firstAddressInput.value = firstAddr;
				secondAddressInput.value = secondAddr;
				///////////

				td_check_label_input.setAttribute("name", 'modifyName');

				td_check_div.className = "bidg-radio";
				td_check_label.classList.add("c-radio");
				td_check_lable_span.classList.add("fa");
				td_check_lable_span.classList.add("fa-circle");

				td_check_label_input.type = "radio";
				td_check_label_input.id = "modifyRadio"+b;
				td_check_label_input.value = bidgArr[b].org_code;

				td_check_label.appendChild(td_check_label_input);
				td_check_label.appendChild(td_check_lable_span);

				td_check_div.appendChild(td_check_label);
				td_check.appendChild(td_check_div);

				td_No.innerHTML = Number(b)+1;
				td_orgName.innerHTML = bidgArr[b].org_name;
				td_addr.innerHTML = firstAddr + " " + secondAddr;
				td_sDate.innerHTML = bidgArr[b].conStartDate;
				td_eDate.innerHTML = bidgArr[b].conEndDate;
				//td_floor.innerHTML = bidgArr[b].floor;

				td_floor.innerHTML = "지하" + unFloor + "층" +'<br>' +"지상" + groundFloor + "층";

				td_bSize.innerHTML = bidgArr[b].bSize+'m<sup>2</sup>';

				tr_dom.appendChild(uInput);
				tr_dom.appendChild(fInput);
				tr_dom.appendChild(noExpire);
				tr_dom.appendChild(firstAddressInput)
				tr_dom.appendChild(secondAddressInput)
				tr_dom.appendChild(td_No);
				tr_dom.appendChild(td_check);
				tr_dom.appendChild(td_orgName);
				tr_dom.appendChild(td_addr);
				tr_dom.appendChild(td_sDate);
				tr_dom.appendChild(td_eDate);
				tr_dom.appendChild(td_floor);
				tr_dom.appendChild(td_bSize);
				tr_dom.appendChild(td_alarm);
				tr_dom.appendChild(td_status);
				tr_dom.appendChild(td_control);
				tr_dom.appendChild(td_temp);
				tr_dom.appendChild(td_hu);
				tr_dom.appendChild(td_gas);
				tr_dom.appendChild(td_sum);

				tbodyDom.appendChild(tr_dom);

				//web_building_counting(config ,bidgArr[b].org_code, td_alarm, td_status, td_control, td_temp, td_hu, td_gas, td_sum);
			}
		},
		beforeSend : function(){
			$(".wrapper").addClass("whirl traditional");
		},
		complete : function(){
			$(".wrapper").removeClass("whirl traditional");
		}
	});

}

let deleteBidg = function(org_code){
	$.ajax({
		"url":"/building/buildingProc.php",
		"type":"post",
		"data":{
			"mode":"deleteBidg",
			"org_code":org_code
		},
		success:function (data) {
			if(data=='0'){
				$("#deleteCompleteModal").modal("hide");
				deleteMessage("삭제 되었습니다.");
			}
			else {
				$("#deleteCompleteModal").modal("hide");
				deleteMessage("삭제에 실패하였습니다.");
			}
		}
	})
}
/* ============================= E:건물 ========================== */

/* ============================= S:유저 ========================== */
let regUser = function () {	//save
	let sessionAuth = document.getElementById("sessionAuth").value;

	let mode_dom = document.getElementById("modal-mode");
	let duPass = document.getElementById("modal-duplicatePass");

	let userId = document.getElementsByName("userId")[0];
	let currentPasswd = document.getElementsByName("currentPW")[0];

	let newPW = document.getElementsByName("newPW")[0];
	let userName = document.getElementsByName("userName")[0];
	let depart = document.getElementsByName("department")[0];
	let position = document.getElementsByName("position")[0];
	let firstPhone = document.getElementsByName("firstNumber")[0];
	let middlePhone = document.getElementsByName("middleNumber")[0];
	let lastPhone = document.getElementsByName("lastNumber")[0];
	let org_code = document.getElementsByName("org_code");
	let auth = document.getElementsByName("auth")[0];
	let comment = document.getElementsByName("comment")[0];
	let seq = document.getElementsByName("modal-seq")[0];
	let pushId = document.getElementById("modal-pushId");

	let phoneNumber = firstPhone.value + "-" + middlePhone.value + "-" + lastPhone.value;

	let orgArr = [];
	let orgVal = '';

	//유효성
	//userValidate(mode_dom.value, userId.value, currentPasswd.value, newPW.value, );
	let isValidate;

	if(mode_dom.value === "registerUser")
		isValidate = userValidate();
	else
		isValidate = userModifyValidate();

	if(isValidate === false) return;

	//다중 부서
	if(org_code.length > 1)
	{
		for(let o = 0; o < org_code.length; o++)
		{
			if(org_code[o].checked === true)
				orgArr.push(org_code[o].value);
		}
		orgVal = orgArr.join(",");
	}
	else
		orgVal = org_code[0].value;

	if(duPass.value === 1)
	{
		alertMessage("아이디 중복 체크를 해주세요");
		return;
	}

	if(mode_dom.value === "updateUser")
	{
		if(sessionAuth === "4")
		{
			$.ajax("/user/userAjaxProc.php",{
				"type":"post",
				"data": {
					"mode":mode_dom.value,
					"id": userId.value,
					"currentPW": currentPasswd.value,
					"newPW": newPW.value,
					"userName": userName.value,
					"depart": depart.value,
					"position": position.value,
					"phone": phoneNumber,
					"org_code": orgVal,
					"auth": auth.value,
					"comment": comment.value,
					"seq": seq.value
				},
				success:function (data)
				{
					if(data === "0") alertMessageR("수정되었습니다.")
				}
			})
		}
		else {
			$.ajax({
				'url': '/login/loginProc.php',
				'type': 'post',
				'data': {
					'mode': 'checkPasswd',
					'currentPasswd': currentPasswd.value,
					'id':userId.value
				},
				success: function(data)
				{
					if (data === "0")
					{
						let emptyNewPw;

						if(newPW.value === '') emptyNewPw = currentPasswd.value;
						else emptyNewPw = newPW.value;
						$.ajax("/user/userAjaxProc.php",
						{
							"type":"post",
							"data": {
								"mode":mode_dom.value,
								"id": userId.value,
								"currentPW": currentPasswd.value,
								"newPW": emptyNewPw,
								"userName": userName.value,
								"depart": depart.value,
								"position": position.value,
								"phone": phoneNumber,
								"org_code": orgVal,
								"auth": auth.value,
								"comment": comment.value,
								"seq": seq.value
							},
							success:function (data)
							{
								if(data === "0") alertMessageR("수정되었습니다.")
							}
						})
					}
					else
						alertMessage("현재 비밀번호가 틀렸습니다.");
				}
			})
		}
	}
	else
	{
		$.ajax("/user/userAjaxProc.php",{
			"type":"post",
			"data": {
				"mode":mode_dom.value,
				"id": userId.value,
				"currentPW": currentPasswd.value,
				"newPW": newPW.value,
				"userName": userName.value,
				"depart": depart.value,
				"position": position.value,
				"phone": phoneNumber,
				"org_code": orgVal,
				"auth": auth.value,
				"comment": comment.value,
				"seq": seq.value
			},
			success:function (data)
			{
				let responseResult = JSON.parse(data);
				if(responseResult.resultVal === '0') alertMessageR("등록되었습니다.")
			}
		})
	}
};

let userListperOrg = function(){
	let check_item = document.getElementsByName('checkOne');
	let tbodyDom = document.getElementById("user_tbody");

	let orgCheckArray = [];
	tbodyDom.innerHTML = '';
	for (let k = 0; k < check_item.length; k++)
	{
		if(check_item[k].checked === true)
		{
			const orgCheckJson = {};
			orgCheckJson.org_name = check_item[k].value.split("_")[1];
			orgCheckJson.org_code = check_item[k].value.split("_")[0];
			orgCheckArray.push(orgCheckJson);
		}
	}

	let strJson = JSON.stringify(orgCheckArray);

	setHeaderName(JSON.parse(strJson));
	getHeaderName();

	$.ajax("/user/userAjaxProc.php",
		{
			type:"post",
			data:{
				'mode': "getUserListperOrg",
				'orgJson':strJson
			},
			success:function (data)
			{
				let jsonList = JSON.parse(data);

				jsonList.sort(function (a, b)
				{
					return a.seq < b.seq ? -1 : a.seq > b.seq ? 1 : 0;
				});

				addUserList(jsonList, tbodyDom)
			},
			beforeSend : function(){
				$(".wrapper").addClass("whirl traditional");
			},
			complete : function(){
				$(".wrapper").removeClass("whirl traditional");
			}
		}
	)//E:ajax

};	//page loading
//유저 UI 생성.//,,,.....

let addUserList = function(data2, tbodyDom){

	let data = remove_duplicates(data2);

	for(let k in data){
		let tr_dom = document.createElement('tr');

		let No_td = document.createElement('td');
		let checkbox_td = document.createElement('td');
		let checkbox_div = document.createElement('div');
		let checkbox_label = document.createElement('label');
		let checkbox_input = document.createElement('input');
		let checkbox_span = document.createElement('span');

		let buildingName = document.createElement('td');
		let name = document.createElement('td');
		let depart = document.createElement('td');
		let grade = document.createElement('td');
		let phone = document.createElement('td');
		let auth = document.createElement('td');
		let cmt = document.createElement('td');

		let input_id = document.createElement('input');
		input_id.type = "hidden";
		input_id.value = data[k].id;

		let input_seq = document.createElement("input");
		input_seq.type = 'hidden';
		input_seq.value = data[k].seq;

		let input_pushId = document.createElement("input");
		input_pushId.type = "hidden";
		input_pushId.value = data[k].pushId;

		//console.log(data[k])
		//console.log(data[k].org_code.split(",").length - 1)

		let multiBIdgName = '';

		if( (data[k].org_code.split(",").length - 1) <= 0 )
			multiBIdgName = '';
		else
			multiBIdgName = ' 외 '+ (data[k].org_code.split(",").length - 1) + "건";

		//No_td.className = 'text-left';

		checkbox_div.classList.add("checkbox");
		checkbox_div.classList.add("c-checkbox");
		checkbox_div.classList.add("d-inline-block");

		checkbox_label.classList.add("mb-0");
		checkbox_input.type = 'checkbox';
		checkbox_input.setAttribute("name", "userCheck");
		checkbox_span.classList.add("fa", "fa-check");

		buildingName.classList.add("text-left");

		checkbox_label.appendChild(checkbox_input);
		checkbox_label.appendChild(checkbox_span);

		checkbox_div.appendChild(checkbox_label);
		checkbox_td.appendChild(checkbox_div);

		let authName = "";

		if(data[k].auth === 4) authName = "수퍼관리자";
		else if(data[k].auth === 3) authName ="관리자";
		else if(data[k].auth === 2) authName ="일반";
		else if(data[k].auth === 1) authName ="디바이스";

		No_td.innerHTML = Number(k)+1;
		buildingName.innerHTML = data[k].org_name + multiBIdgName;
		name.innerHTML = data[k].name;
		depart.innerHTML = (data[k].depart == null)?'미입력':data[k].depart;
		grade.innerHTML = data[k].grade;
		phone.innerHTML = data[k].phone;
		auth.innerHTML = authName;
		cmt.innerHTML = data[k].comment;

		checkbox_input.value = data[k].org_code;

		tr_dom.appendChild(input_id);
		tr_dom.appendChild(input_seq);
		tr_dom.appendChild(input_pushId);
		tr_dom.appendChild(No_td);
		tr_dom.appendChild(checkbox_td);
		tr_dom.appendChild(buildingName);
		tr_dom.appendChild(name);
		tr_dom.appendChild(depart);
		tr_dom.appendChild(grade);
		tr_dom.appendChild(phone);
		tr_dom.appendChild(auth);
		tr_dom.appendChild(cmt);

		tbodyDom.appendChild(tr_dom);
	}
};

let delUser = function (seqs , i) {

	$.ajax("/user/userAjaxProc.php",{
		"type":"post",
		"data":{
			"mode":"delUser",
			"seqs":seqs.join(",")
		},
		success:function (data) {
			deleteMessage("삭제되었습니다.");
		}
	})

};

let duplicateIdCheck = function () {
	let userId = document.getElementsByName("userId")[0];
	let duPass = document.getElementById("modal-duplicatePass");

	if(userId.value == '') {	//공백체크
		$('[name=userId]').parsley().validate();
		return;
	}

	$.ajax("/user/userAjaxProc.php",
		{
			"type":"post",
			"data":{
				"mode": "dupCheck",
				'id': userId.value
			},
			success:function (data) {
				if(data == '0') {
					alertMessage("사용가능한 아이디 입니다.")
					duPass.value = 2;
				}else {
					alertMessage("중복된 아이디 입니다.");
					duPass.value = 1;
				}
			}
		})
};

let duCheckInit = function(){
	let duPass = document.getElementById("modal-duplicatePass");
	duPass.value = 1;
};

let modifyUser = function(){	//modal
	userValidateReset();

	let currentPasswd = document.getElementsByName("currentPW")[0];
	let newPW = document.getElementsByName("newPW")[0];
	let newCheckPW = document.getElementsByName("reEnterNewPW")[0];

	currentPasswd.value = '';
	newPW.value = '';
	newCheckPW.value = '';

	let userCheck = document.getElementsByName("userCheck");
	let i = 0;
	let checked_org = '';

	for (let k = 0; k < userCheck.length; k++)
	{
		if (userCheck[k].checked === true)
		{
			i++;
			checked_org = k;
		}
	}

	if(i===0)
		alertMessage("사용자를 선택해주세요.");
	else if(i===1)
	{
		let modalTitle = document.getElementsByName("user-modal-title")[0]

		let trEle = userCheck[checked_org].parentElement.parentElement.parentElement.parentElement;
		let tdEle = trEle.getElementsByTagName('td');

		let userId = document.getElementsByName("userId")[0];
		let userName = document.getElementsByName("userName")[0];
		let depart = document.getElementsByName("department")[0];
		let position = document.getElementsByName("position")[0];
		let firstPhone = document.getElementsByName("firstNumber")[0];
		let middlePhone = document.getElementsByName("middleNumber")[0];
		let lastPhone = document.getElementsByName("lastNumber")[0];
		let org_code = document.getElementsByName("org_code")[0];
		let auth = document.getElementsByName("auth")[0];
		let comment = document.getElementsByName("comment")[0];
		let seq = document.getElementsByName("modal-seq")[0];
		let pushId = document.getElementById("modal-pushId");

		if(tdEle[7].textContent === "일반"){
			auth.value = 2
		}
		else if(tdEle[7].textContent === "관리자"){
			auth.value = 3
		}
		else if(tdEle[7].textContent === "수퍼관리자"){
			auth.value = 4
		}
		else if(tdEle[7].textContent === "디바이스"){
			auth.value = 1
		}

		let phoneText = tdEle[6].textContent.split("-");

		modalTitle.innerHTML = "사용자 수정" + " - " + trEle.getElementsByTagName("input")[0].value

		firstPhone.value = (phoneText[0] === undefined)?'':phoneText[0];
		middlePhone.value = (phoneText[1] === undefined)?'':phoneText[1];
		lastPhone.value = (phoneText[2] === undefined)?'':phoneText[2];

		userName.value = tdEle[3].textContent;
		depart.value = tdEle[4].textContent;
		position.value = tdEle[5].textContent;

		let arrayCheck = tdEle[1].getElementsByTagName("input")[0].value.split(',');

		let allCheck = "";
		if(arrayCheck.length > 1) {
			if(arrayCheck.length == bIdgListJson.length){
				allCheck = "checked"
			}

			document.getElementById("multiChk").checked = true;
			var multiSlt = '<div class="dropDown multiSlt">';
			multiSlt += '<input type="text" class="form-control input-sm pl-2 btn_drop" readonly value="" />';
			multiSlt += '<div class="dropBox">';
			multiSlt += '<ul class="list-unstyled mb-0">';
			multiSlt += '<li>';
			multiSlt += '    <div class="checkbox c-checkbox d-inline-block mt-1">';
			multiSlt += '        <label class="mb-0">';
			multiSlt += '        <input name="org_codeAll" type="checkbox" '+allCheck+'>';
			multiSlt += '        <span class="fa fa-check"></span>';
			multiSlt += '        <em class="text-mediumGray">전체</em>';
			multiSlt += '    </label>';
			multiSlt += '    </div>';
			multiSlt += '</li>';

			for (var checki = 0; checki < bIdgListJson.length; checki++) {
				var checked = "";
				if(arrayCheck.indexOf(bIdgListJson[checki].org_code) !== -1){
					checked = "checked";
				}
				multiSlt += '<li>';
				multiSlt += '    <div class="checkbox c-checkbox d-inline-block mt-1">';
				multiSlt += '        <label class="mb-0">';
				multiSlt += '        <input name="org_code" type="checkbox" value="'+bIdgListJson[checki].org_code+'" '+checked+'>';
				multiSlt += '        <span class="fa fa-check"></span>';
				multiSlt += '        <em class="text-mediumGray">' + bIdgListJson[checki].org_name + '</em>';
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
			document.getElementById("multiChk").checked = false;

			var singleSlt = '<select class="form-control input-sm" name="org_code">';
			for (var checki = 0; checki < bIdgListJson.length; checki++) {
				var selected = "";
				if(arrayCheck == bIdgListJson[checki].org_code)
					selected = "selected";
				singleSlt += '<option value="' + bIdgListJson[checki].org_code + '"'+selected+'>' + bIdgListJson[checki].org_name + '</option>';
			}
			singleSlt += '</select>';
			//console.log(singleSlt)
			$(".nameOfBelonging > div").html(singleSlt);
		}

		comment.value = tdEle[8].textContent;

		seq.value = trEle.getElementsByTagName("input")[1].value

		userId.value = trEle.getElementsByTagName("input")[0].value

		pushId.value = trEle.getElementsByTagName("input")[2].value;

		$("#userRegist").modal({backdrop: 'static', keyboard: false});
	}
	else
		alertMessage("수정은 체크박스를 1개 선택해주세요.")



};

let userValidate = function(){

	$("[name=userId]").parsley().validate();
	$("#newPW").parsley().validate();
	$("[name=reEnterNewPW]").parsley().validate();
	$("[name=userName]").parsley().validate();
	$("[name=department]").parsley().validate();
	$("[name=position]").parsley().validate();
	//$("[name=firstNumber]").parsley().validate();
	//$("[name=middleNumber]").parsley().validate();
	//$("[name=lastNumber]").parsley().validate();

	if($("[name=middleNumber]").parsley().isValid() && $("[name=lastNumber]").parsley().isValid() ){
		$("#phoneValidate").addClass("d-none");
	}else{
		// if(!$("[name=middleNumber]").parsley().isValid()){
		// 	$("[name=middleNumber]").addClass("parsley-error")
		// }else{
		// 	$("[name=middleNumber]").removeClass("parsley-error")
		// }
		//
		// if(!$("[name=lastNumber]").parsley().isValid()){
		// 	$("[name=lastNumber]").addClass("parsley-error")
		// }else{
		// 	$("[name=lastNumber]").removeClass("parsley-error")
		// }

		$("#phoneValidate").removeClass("d-none");
	}

	$("[name=auth]").parsley().validate();

	return $("[name=userId]").parsley().isValid() &&
		$("#newPW").parsley().isValid() &&
		$("[name=reEnterNewPW]").parsley().isValid() &&
		$("[name=userName]").parsley().isValid() &&
		$("[name=department]").parsley().isValid() &&
		$("[name=position]").parsley().isValid() &&
		$("[name=firstNumber]").parsley().isValid() &&
		$("[name=middleNumber]").parsley().isValid() &&
		$("[name=lastNumber]").parsley().isValid() &&
		$("[name=auth]").parsley().isValid()
};

let userModifyValidate = function(){
	let auth = $("#sessionAuth").val();

	if(auth != "4"){
		$("[name=currentPW]").parsley().validate();
	}

	if($("#newPW").val() != ''){
		$("#newPW").parsley().validate();
		$("[name=reEnterNewPW]").parsley().validate();
	}

	$("[name=userName]").parsley().validate();
	$("[name=department]").parsley().validate();
	$("[name=position]").parsley().validate();
	//$("[name=firstNumber]").parsley().validate();
	//$("[name=middleNumber]").parsley().validate();
	//$("[name=lastNumber]").parsley().validate();

	console.log($("[name=middleNumber]").parsley().isValid())
	console.log($("[name=lastNumber]").parsley().isValid())

	if($("[name=middleNumber]").parsley().isValid() && $("[name=lastNumber]").parsley().isValid() ){
		$("#phoneValidate").addClass("d-none");
	}else{
		// if(!$("[name=middleNumber]").parsley().isValid()){
		// 	$("[name=middleNumber]").addClass("parsley-error")
		// }else{
		// 	$("[name=middleNumber]").removeClass("parsley-error")
		// }
		//
		// if(!$("[name=lastNumber]").parsley().isValid()){
		// 	$("[name=lastNumber]").addClass("parsley-error")
		// }else{
		// 	$("[name=middleNumber]").removeClass("parsley-error")
		// }
		$("#phoneValidate").removeClass("d-none");
	}

	$("[name=auth]").parsley().validate();

	let resultVal = false;

	if(!$("[name=userName]").parsley().isValid()) return resultVal;
	if(!$("[name=department]").parsley().isValid()) return resultVal;

	if($("#newPW").val() != ''){
		if(!$("#newPW").parsley().isValid()) return resultVal;
		if(!$("[name=reEnterNewPW]").parsley().isValid()) return resultVal;
	}

	if(auth != "4"){
		if(!$("[name=currentPW]").parsley().isValid()) return resultVal;
	}

	if(!$("[name=position]").parsley().isValid()) return resultVal;
	if(!$("[name=firstNumber]").parsley().isValid()) return resultVal;
	if(!$("[name=middleNumber]").parsley().isValid()) return resultVal;
	if(!$("[name=lastNumber]").parsley().isValid()) return resultVal;
	if(!$("[name=auth]").parsley().isValid()) return resultVal;

	return true
};

let userValidateReset = function(){
	$("[name=userId]").parsley().reset();
	$("#newPW").parsley().reset();
	$("[name=currentPW]").parsley().reset();
	$("[name=reEnterNewPW]").parsley().reset();
	$("[name=userName]").parsley().reset();
	$("[name=department]").parsley().reset();
	$("[name=position]").parsley().reset();
	$("[name=firstNumber]").parsley().reset();
	$("[name=middleNumber]").parsley().reset();
	$("[name=lastNumber]").parsley().reset();
	$("[name=auth]").parsley().reset();

	$("#phoneValidate").addClass("d-none");

	$("[name=middleNumber]").removeClass("parsley-error")
	$("[name=lastNumber]").removeClass("parsley-error")

	document.getElementById("multiChk").checked = false;
};

let userModalInit = function () {
	let userId = document.getElementsByName("userId")[0];
	let currentPasswd = document.getElementsByName("currentPW")[0];
	let newPW = document.getElementsByName("newPW")[0];
	let newCheckPW = document.getElementsByName("reEnterNewPW")[0];
	let userName = document.getElementsByName("userName")[0];
	let depart = document.getElementsByName("department")[0];
	let position = document.getElementsByName("position")[0];
	let firstPhone = document.getElementsByName("firstNumber")[0];
	let middlePhone = document.getElementsByName("middleNumber")[0];
	let lastPhone = document.getElementsByName("lastNumber")[0];
	let org_code = document.getElementsByName("org_code")[0];
	let auth = document.getElementsByName("auth")[0];
	let comment = document.getElementsByName("comment")[0];
	let pushId = document.getElementById("modal-pushId");

	userId.value = '';
	currentPasswd.value = '';
	newPW.value = '';
	newCheckPW.value = '';
	userName.value = '';
	depart.value = '';
	position.value = '';
	firstPhone.value = '010';
	middlePhone.value = '';
	lastPhone.value = '';
	//org_code.value = '';
	comment.value = '';
	pushId = '';
};

let excelModal = function () {
	$("#excelUpload").modal("show");
};

function multiChkStatus() {
	const selector = $(".dropBox input[type='checkbox']:checked");
	const selectorAll = $(".dropBox [name=org_codeAll]:checked");

	const chkCount = selector.length - 1;
	let chkText;
	if (selector.length > 1) {
		let arr = [];
		selector.each(function(i, el) {
			arr.push($(el).siblings("em").text());
		});
		if(selectorAll.length === 1){
			$('.btn_drop').val(arr[1] + " 외 " + (chkCount-1) + "건");
		}else if(selectorAll.length === 0){
			$('.btn_drop').val(arr[0] + " 외 " + chkCount + "건");
		}

	} else if (selector.length === 1) {
		chkText = selector.siblings('em').text();
		$('.btn_drop').val(chkText);
	} else {
		$('.btn_drop').val('소속을 선택해주세요.');
	}
};
/* ============================ E: 유저 ============================= */

/* ============================ S: 로그 ============================= */
let getLogView = function(){
	let typeArr = [];
	let type = document.getElementsByName("checkOne");
	let sDate = document.getElementById("input-sDate");
	let eDate = document.getElementById("input-eDate");
	let message = document.getElementById("message");
	let org_code = document.getElementById("param-orgCode");
	let checkAll = document.getElementsByName("checkAll")[0];
	let orgLength = '';

	let start_dates = sDate.value.split("-");
	let end_dates = eDate.value.split("-");

	let date1 = new Date(start_dates[0],start_dates[1],start_dates[2]).valueOf();
	let date2 = new Date(end_dates[0],end_dates[1],end_dates[2]).valueOf();

	if((date2 - date1) < 0){
		alertMessage("시작 시간이 종료시간보다 큽니다.");
		return;
	}

	if(org_code.value.split(",").length > 1) orgLength = 2;
	else if(org_code.value.split(",").length == 1)
	{
		if(org_code.value.split(",")[0] == '')
			orgLength = 0;
		else
			orgLength = 1;
	}

	// if(checkAll.checked == true){
	// 	typeArr.push("7");
	// }

	for(let t=0; t < type.length; t++)
	{
		if(type[t].checked == true)
			typeArr.push(type[t].value)
	}

	let types = typeArr.join(",");

	$.ajax("/log/logAjaxProc.php",{
		"type":"post",
		"data": {
			"mode": "getLogView",
			"org_code":org_code.value,
			"type": types,
			"message":message.value,
			"startDate":sDate.value,
			"endDate":eDate.value
		},
		success:function (data) {
			let list = JSON.parse(data).data;

			if(list == null){

				let tbody = document.getElementById("log-tbody");

				tbody.innerHTML = '';
				let tr_dom = document.createElement("tr");
				let td_noneData = document.createElement("td");

				if(orgLength<2)
					td_noneData.colSpan = 3;
				else
					td_noneData.colSpan = 4;

				td_noneData.innerHTML = "데이터가 없습니다.";

				tr_dom.appendChild(td_noneData);
				tbody.appendChild(tr_dom)

			}
			else createLogList(list, orgLength)
		},
		beforeSend : function(){
			$(".wrapper").addClass("whirl traditional");
		},
		complete : function(){
			$(".wrapper").removeClass("whirl traditional");
		}
	})
};

let createLogList = function(data, orgLength){
	//console.log(data)
	let tbody = document.getElementById("log-tbody");
	tbody.innerHTML = '';
	if(orgLength<2){
		document.getElementById("bldgCol").classList.add("d-none")
		document.getElementById("bldgTH").classList.add("d-none")
	}else{
		document.getElementById("bldgCol").classList.remove("d-none")
		document.getElementById("bldgTH").classList.remove("d-none")
	}
	for(c in data){
		let tr_dom = document.createElement("tr");
		let td_BldgName = document.createElement("td");
		let td_date_dom = document.createElement("td");
		let td_type_dom = document.createElement('td');
		let td_contents_dom = document.createElement("td");
		let typeMessage = '';

		//console.log(data[c])

		td_date_dom.classList.add("text-left");
		td_contents_dom.classList.add("text-left");
		td_BldgName.classList.add("text-left");

		switch (data[c].type) {
			case '1' : typeMessage = "경보"; break;
			case '2' : typeMessage = "상태"; break;
			case '3' : typeMessage = "제어"; break;
			case '4' : typeMessage = "온도"; break;
			case '5' : typeMessage = "습도"; break;
			case '6' : typeMessage = "가스"; break;
			case '7' : typeMessage = "기타"; break;
		}

		td_BldgName.innerHTML = data[c].org_name
		if(orgLength < 2) {
			td_BldgName.classList.add("d-none")
		}else{
			td_BldgName.classList.remove("d-none")
		}

		td_date_dom.innerHTML = data[c].regdate.substring(0,19);
		td_type_dom.innerHTML = typeMessage;
		td_contents_dom.innerHTML = data[c].message;

		if(data[c].message.indexOf("경보 발생") != -1){
			td_contents_dom.classList.add("text-danger")
		}else if(data[c].message.indexOf("경보 해제") != -1){
			td_contents_dom.classList.add("text-info")
		}

		tr_dom.appendChild(td_BldgName)
		tr_dom.appendChild(td_date_dom);
		tr_dom.appendChild(td_type_dom);
		tr_dom.appendChild(td_contents_dom);

		tbody.appendChild(tr_dom);
	}
};

let selectBIdg = function(){
	$("#selectBldg").modal({backdrop: 'static', keyboard: false});
};

let saveModalOrgcode = function () {
	let bldgCheck = document.getElementsByName("checkOne2");
	let bldgOrgArr =[];

	let bldgOrgList;

	let orgArr = [];

	for(let b = 0; b < bldgCheck.length; b++)
	{
		if(bldgCheck[b].checked === true)
		{
			bldgOrgArr.push(bldgCheck[b].value.split("_")[0]);

			let org = {
				org_name:bldgCheck[b].value.split("_")[1],
				org_code:bldgCheck[b].value.split("_")[0]
			};

			orgArr.push(org)
		}
	}

	setHeaderName(orgArr);
	getHeaderName();

	bldgOrgList = bldgOrgArr.join(",");

	document.getElementById("param-orgCode").value = bldgOrgList;

	$("#selectBldg").modal("hide");
};

let logBIdgCheck = function(){
	let list = JSON.parse(localStorage.getItem(seq) );

	let checkbox = document.getElementsByName("checkOne2");

	let param_orgCode = document.getElementById("param-orgCode");

	for (let i in list)
	{
		for( let d=0; d<checkbox.length; d++)
		{
			if(checkbox[d].value === (list[i].org_code+"_"+list[i].org_name) )
			{
				checkbox[d].checked = true;

				if(param_orgCode.value === "")
					param_orgCode.value += list[i].org_code;
				else
					param_orgCode.value += ","+list[i].org_code;
			}
		}
	}

	if(list.length !== 0)
	{
		let name;

		if(list.length - 1 === 0)
			name = list[0].org_name;
		else
			name = list[0].org_name + " 외 " + (list.length - 1) + "개";

		document.getElementById("headerBIdgName").innerHTML = name;

		if(list.length === checkbox.length) document.getElementsByName("checkAll2")[0].checked = "true"
	}

};
/* ============================ E: 로그 ============================= */

/*================================S:알람 모달==========================*/
const sessionMessage = function () {
	$("#sessionModal").modal({backdrop: 'static', keyboard: false});
};

let recentHistoryModal = function (org_code, SerialNo, GatewayKey, type, chType, cmt) {

	$.ajax({
		"url":"/log/logAjaxProc.php",
		"type":"post",
		"data":{
			"mode":"getOneLogView",
			"org_code": org_code,
			"SerialNo": SerialNo,
			"GatewayKey": GatewayKey,
			"type": type,
			"chType": chType
		},
		success:function (data) {
			let message = JSON.parse(data)

			if(message.data == null){
				document.getElementById("recentHistory-body").innerHTML = "최근 이력 정보가 없습니다."
				document.getElementById("historyRegDate").innerHTML = ""
			}
			else{
				document.getElementById("historyRegDate").innerHTML = message.data[0].regdate.substring(0,19);
				document.getElementById("recentHistory-body").innerHTML = message.data[0].message
			}
		}
	})
	if(cmt != ""){
		document.getElementById("recentModal-title").innerHTML = cmt
	}else{
		document.getElementById("recentModal-title").innerHTML = "미입력"
	}

	$("#recentHistory").modal({backdrop: 'static', keyboard: false});
}

let recentHistoryModal2 = function (org_code, SerialNo, GatewayKey, type, chType, orgName, gwCmt, cmt, status) {
	document.getElementById("recentSerialNo").value = SerialNo
	document.getElementById("recentGatewayKey").value = GatewayKey
	document.getElementById("recentChType").value = chType
	document.getElementById("recentOrgCode").value = org_code
	document.getElementById("recentBidgName").value = orgName
	document.getElementById("recentGwCmt").value = gwCmt
	document.getElementById("recentCmt").value = cmt
	document.getElementById("recentStatus").value = status

	let userAuth = document.getElementById("auth").value;

	/*
        document.getElementById("inchConfirmBtn").innerHTML = "확인"

        if(status == "3"){
            if(userAuth > 2){
                document.getElementById("inchConfirmBtn").innerHTML = "해제"
            }else{
                document.getElementById("inchConfirmBtn").innerHTML = "복귀"
            }
            document.getElementById("inchConfirmBtn").classList.add("btn-danger")
            document.getElementById("inchConfirmBtn").classList.add("btn-xs")
            document.getElementById("inchConfirmBtn").classList.remove("btn-info")
        }else{
            document.getElementById("inchConfirmBtn").innerHTML = "확인"
            document.getElementById("inchConfirmBtn").classList.add("btn-info")
            document.getElementById("inchConfirmBtn").classList.remove("btn-danger")
        }
    */
	$.ajax({
		"url":"/log/logAjaxProc.php",
		"type":"post",
		"data":{
			"mode":"getOneLogView",
			"org_code": org_code,
			"SerialNo": SerialNo,
			"GatewayKey": GatewayKey,
			"type": type,
			"chType": chType
		},
		success:function (data) {
			let message = JSON.parse(data)

			console.log(message.data[0].regdate)
			console.log(message.data[0])

			if(message.data == null){
				document.getElementById("recentHistory-body2").innerHTML = "최근 이력 정보가 없습니다."
				document.getElementById("historyRegDate2").innerHTML = ""
			}
			else{
				document.getElementById("historyRegDate2").innerHTML = message.data[0].regdate.substring(0, 19);
				document.getElementById("recentHistory-body2").innerHTML = message.data[0].message
			}
		}
	})

	if(cmt != ""){
		document.getElementById("recentModal-title2").innerHTML = cmt
	}else{
		document.getElementById("recentModal-title2").innerHTML = "미입력"
	}

	$("#recentHistory2").modal({backdrop: 'static', keyboard: false});

}

let alertModal = function(message, cmt, gwKey, chNo, gwCmt, serialNo){
	document.getElementById("alertConfirmGwKey").value = gwKey
	document.getElementById("alertConfirmChNo").value = chNo
	document.getElementById("alertConfirmGwCmt").value = gwCmt
	document.getElementById("alertConfirmCmt").value = cmt
	document.getElementById("alertConfirmSerialNo").value = serialNo

	let alarmMessage = document.getElementById("alarm-message");

	let p = document.createElement("p");
	let span = document.createElement("span");
	//let br = document.createElement("br");
	let cBtn = document.createElement("button");

	p.style.borderBottom = "1px solid #f2f2f2";

	span.classList.add("mr-1");
	span.classList.add("d-inline-block")
	span.style.width = "83%";

	cBtn.innerHTML = "확인"
	cBtn.classList.add("btn");
	cBtn.classList.add("btn-info");
	cBtn.classList.add("btn-xs");
	cBtn.classList.add("float-right")
	cBtn.name = "confirmBtn"

	span.innerHTML = message;

	p.dataset.gwkey = gwKey;
	p.dataset.chno = chNo;
	p.dataset.gwcmt = gwCmt;
	p.dataset.cmt = cmt;
	p.dataset.serialno = serialNo;

	p.appendChild(span);
	p.appendChild(cBtn);
	alarmMessage.appendChild(p);
	//alarmMessage.appendChild(br)

	const x = document.getElementById("myAudio");

	x.play()

	$("#alarmConfirm").click(function () {
		let alarmMessage = document.getElementById("alarm-message");

		alarmMessage.innerHTML = "";

		x.pause();

		let bIdgName = document.getElementById("myBuildingName").value;
		let comment = document.getElementById("alertConfirmCmt");
		let gwKey = document.getElementById("alertConfirmGwKey");
		let chNo = document.getElementById("alertConfirmChNo");
		let type = "12";
		let gwCmt = document.getElementById("alertConfirmGwCmt");
		let serialNo = document.getElementById("alertConfirmSerialNo");

		$.ajax({
			"url":"/log/logAjaxProc.php",
			"type":"post",
			"data":{
				"mode":"confirmHistory",
				"comment":comment.value,
				"gwKey":gwKey.value,
				"chNo":chNo.value,
				"type":type,
				"bIdgName":bIdgName,
				"gwCmt":gwCmt.value,
				"serialNo":serialNo.value
			},
			success:function (data) {
				console.log(data)
			}
		})

		$("#alarmModal").modal("hide");
	})

	$("#alarmModal").modal({backdrop: 'static', keyboard: false});

}

let alertMessage = function(message){
	$("#modal-message").html(message);
	$("#alertModal").modal({backdrop: 'static', keyboard: false});
}

let alertMessageR = function(message){
	$("#modal-messageR").html(message);
	$("#alertModalR").modal({backdrop: 'static', keyboard: false});
}

let deleteMessage = function(message){
	document.getElementById("delete-body-Modal").innerHTML = message
	$("#deleteCompleteModal").modal({backdrop: 'static', keyboard: false});
}

let showDeleteModal = function(){
	let currentPath = window.location.pathname.split('/')[2]

	if(currentPath == 'buildingManage.php') {
		let modifyCheck = document.getElementsByName("modifyName");
		let org_code;

		//console.log(modifyCheck);
		for(k in modifyCheck) {
			if (modifyCheck[k].checked == true) {
				let trEle = modifyCheck[k].parentElement.parentElement.parentElement.parentElement;
				let tdEle = trEle.getElementsByTagName('td')
				org_code = tdEle[1].getElementsByTagName("input")[0].value;
			}
		}

		if(org_code == undefined || org_code == null) {
			alertMessage("건물을 선택 해주세요")
			return;
		}

		$("#deleteBIdgModal").modal({backdrop: 'static', keyboard: false});

	}
	else if(currentPath == 'userManage.php'){
		let userCheck = document.getElementsByName("userCheck");
		let i = 0;
		let checked_org = '';

		for(k in userCheck) {
			if (userCheck[k].checked == true) {
				i++;
				checked_org = k;
			}
		}

		if(i==0){
			alertMessage("사용자를 선택해주세요.")
			return;
		}

		$("#deleteConfModal").modal({backdrop: 'static', keyboard: false});

	}
	else{
		$("#deleteConfModal").modal({backdrop: 'static', keyboard: false});
	}

}; //삭제 모달 쇼

let deleteModal = function(){
	let currentPath = window.location.pathname.split('/')[2]

	if(currentPath == 'userManage.php') {
		let userCheck = document.getElementsByName("userCheck");
		let seqs = [];
		let i=0;
		for(k in userCheck) {
			if (userCheck[k].checked == true) {
				let trEle = userCheck[k].parentElement.parentElement.parentElement.parentElement;
				let tdEle = trEle.getElementsByTagName('td')
				let inputEle = trEle.getElementsByTagName('input')

				seqs.push(inputEle[1].value);

				i++;
			}
		}
		$("#deleteConfModal").modal("hide");

		delUser(seqs, i);
	}
	else if(currentPath == 'buildingManage.php') {
		let modifyCheck = document.getElementsByName("modifyName");
		let org_code;

		//console.log(modifyCheck);
		for(k in modifyCheck) {
			if (modifyCheck[k].checked == true) {
				let trEle = modifyCheck[k].parentElement.parentElement.parentElement.parentElement;
				let tdEle = trEle.getElementsByTagName('td')
				org_code = tdEle[1].getElementsByTagName("input")[0].value;
			}
		}

		if(org_code == undefined || org_code == null) {
			alertMessage("체크 해주세요")
			return;
		}

		$("#deleteBIdgModal").modal("hide");

		deleteBidg(org_code);
	}
	else if(currentPath == 'deviceConf.php') {
		$("#deleteConfModal").modal("hide");

		deleteMainDevice();
	}
}; //모달에서 삭제 버튼

let deviceShowTabModal = function(){
	$("#changeModal").modal({backdrop: 'static', keyboard: false})
};

let closeTabModal = function(){
	document.getElementById("tabCond").value = "1"

	$("#changeModal").modal("hide");
};

function showLogoutModal(){
	$("#logoutModal").modal("show");
}
/*================================E:알람 모달===============================*/

let testConsole = function () {
	console.log('test')
}

$.fn.replaceOptions = function(options) {
	var self, $option;

	this.empty();
	self = this;

	$.each(options, function(index, option) {
		$option = $("<option></option>")
			.attr("value", option.value)
			.text(option.text);

		self.append($option);
	});
};

function sortTable(n , tableName) {
	var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	table = document.getElementById(tableName);
	switching = true;
	//Set the sorting direction to ascending:
	dir = "asc";
	/*Make a loop that will continue until
    no switching has been done:*/
	while (switching) {
		//start by saying: no switching is done:
		switching = false;
		rows = table.rows;
		/*Loop through all table rows (except the
        first, which contains table headers):*/
		for (i = 1; i < (rows.length - 1); i++) {
			//start by saying there should be no switching:
			shouldSwitch = false;
			/*Get the two elements you want to compare,
            one from current row and one from the next:*/
			x = rows[i].getElementsByTagName("TD")[n];
			y = rows[i + 1].getElementsByTagName("TD")[n];
			/*check if the two rows should switch place,
            based on the direction, asc or desc:*/
			if (dir == "asc") {
				if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
					//if so, mark as a switch and break the loop:
					shouldSwitch= true;
					break;
				}
			} else if (dir == "desc") {
				if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
					//if so, mark as a switch and break the loop:
					shouldSwitch = true;
					break;
				}
			}
		}
		if (shouldSwitch) {
			/*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
			//Each time a switch is done, increase this count by 1:
			switchcount ++;
		} else {
			/*If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again.*/
			if (switchcount == 0 && dir == "asc") {
				dir = "desc";
				switching = true;
			}
		}
	}
}

function remove_duplicates(objectsArray) {
	var usedObjects = {};

	for (var i=objectsArray.length - 1;i>=0;i--) {
		var so = JSON.stringify(objectsArray[i]);

		if (usedObjects[so]) {
			objectsArray.splice(i, 1);

		} else {
			usedObjects[so] = true;
		}
	}

	return objectsArray;

}

function replaceAll(str, searchStr, replaceStr) {
	let relaceStr = str.split(searchStr);

	return relaceStr.join(replaceStr);
}

var getParameter = function (param) {
	var returnValue;
	var url = location.href;
	var parameters = (url.slice(url.indexOf('?') + 1, url.length)).split('&');
	for (var i = 0; i < parameters.length; i++) {
		var varName = parameters[i].split('=')[0];
		if (varName.toUpperCase() == param.toUpperCase()) {
			returnValue = parameters[i].split('=')[1];
			return decodeURIComponent(returnValue);
		}
	}
};

var setCookie = function(name, value, exp) {
	var date = new Date();
	date.setTime(date.getTime() + exp*24*60*60*1000);
	document.cookie = name
		+ '=' + value + ';expires=' + date.toUTCString() + ';path=/';
};

var getCookie = function(name) {
	var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
	return value? value[2] : null;
};

var deleteCookie = function(name) {
	document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function getTimeStamp() {
	var d = new Date();
	var s =
		leadingZeros(d.getFullYear(), 4) + '-' +
		leadingZeros(d.getMonth() + 1, 2) + '-' +
		leadingZeros(d.getDate(), 2) + ' ' +

		leadingZeros(d.getHours(), 2) + ':' +
		leadingZeros(d.getMinutes(), 2);
	//leadingZeros(d.getSeconds(), 2);

	return s;
}

function leadingZeros(n, digits) {
	var zero = '';
	n = n.toString();

	if (n.length < digits) {
		for (i = 0; i < digits - n.length; i++)
			zero += '0';
	}
	return zero + n;
}

function sessionConsole(session){
	console.log(session)
}

function pad(n){return n<10 ? '0'+n : n}

function pad2(n, width) {
	n = n + '';
	return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
}

let setHeaderName = function(data){
	let seq = document.getElementById("seq").value;

	localStorage.setItem(seq, JSON.stringify(data))

	console.log("save seq", localStorage.getItem(seq));
}

let getHeaderName = function(){
	console.log("getHeaderName");
	let seq = document.getElementById("seq").value;
	let bIdgInfo = JSON.parse(localStorage.getItem(seq))

	let name;
	if(bIdgInfo.length == 0){
		name = "건물 미선택"
	}
	else if(bIdgInfo.length - 1 == 0){
		name = bIdgInfo[0].org_name
	}else{
		name = bIdgInfo[0].org_name + " 외 " + (bIdgInfo.length - 1) + "개"
	}

	document.getElementById("headerBIdgName").innerHTML = name;
}

let meterToP = function(meter) {
	let p = meter * 0.3025;

	document.getElementsByClassName("spaceNumber")[0].innerHTML = Math.round(p);
};

let monrSort = function(ul){
	var list = ul

	var items = list.childNodes;
	var itemsArr = [];
	for (var i in items) {
		if (items[i].nodeType == 1) { // get rid of the whitespace text nodes
			itemsArr.push(items[i]);
		}
	}

	itemsArr.sort(function(a, b) {
		return a.id == b.id
			? 0
			: (a.id > b.id ? 1 : -1);
	});

	for (i = 0; i < itemsArr.length; ++i) {
		list.appendChild(itemsArr[i]);
	}

};

function monrAdmSort(tableDom) {
	var table, rows, switching, i, x, y, shouldSwitch;
	table = tableDom;
	switching = true;
	/*Make a loop that will continue until
    no switching has been done:*/
	while (switching) {
		//start by saying: no switching is done:
		switching = false;
		rows = table.rows;
		/*Loop through all table rows (except the
        first, which contains table headers):*/
		for (i = 1; i < (rows.length - 1); i++) {
			//start by saying there should be no switching:
			shouldSwitch = false;
			/*Get the two elements you want to compare,
            one from current row and one from the next:*/
			x = rows[i].id
			y = rows[i + 1].id
			//check if the two rows should switch place:

			if (x.toLowerCase() > y.toLowerCase()) {
				//if so, mark as a switch and break the loop:
				shouldSwitch = true;
				break;
			}

		}
		if (shouldSwitch) {
			/*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
		}
	}
};

let deviceInputInit = function(){
	document.getElementById("textbidgName").value = '';
	document.getElementById("textbidgLocation").value = '';
	document.getElementById("textbidgCmt").value = '';
	document.getElementById("textBidgSN").innerHTML = '';
	document.getElementById("textMac").innerHTML = '';
	document.getElementById("textIP").innerHTML = '';
	document.getElementById("textPort").innerHTML = '';
	document.getElementById("textUseYN").value = '';
	document.getElementById("textDeviceId").value = '';
	document.getElementById("textDeviceOrgCode").value = '';

	let i = 1;

	for(i=1; i<17; i++){
		let gwClassName = "gw"+i
		let gw = document.getElementsByClassName(gwClassName)

		for (c in gw){
			gw[c].value = "";
			gw[c].name = "";
		}
	}

};
