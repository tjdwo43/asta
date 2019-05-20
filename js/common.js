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

function pad(n){return n<10 ? '0'+n : n}

function JS_logout(){
	sessionStorage.removeItem("selectedLastBidg");

	localStorage.removeItem('i!@#')
	localStorage.removeItem('p!@#')
	localStorage.removeItem('a!@#')

	if(confirm("로그아웃 하시겠습니까?")){
		$.ajax({
			'url' : '/login/loginProc.php',
			'type' : 'post',
			'data' : {
				'mode' : 'logout'
			},
			success : function(){
				if(window.location.pathname.split('/')[1] == 'm'){
					window.location.href="/m";
				}else {
					window.location.href="/index2.php";
				}
			}
		});
	}
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

				document.getElementById("curBuildingName").innerHTML = buildData.lastBuildingInfo.org_name
			}

			$.each(buildData.data, function(k, v){
				let org_name = (v.org_name == '')?'미입력':v.org_name
				buildListHtml += '<li  onclick="selectBuildItem(\''+v.org_code+'\',\''+v.org_name+'\');">'
				buildListHtml += '	<div class="d-inline-block" >'
				buildListHtml += '		<div class="font-weight-bold">'+org_name+'</div>'
				buildListHtml += '		<div>'+v.address+'</div>'
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
		'url': '/building/buildingProc.php',
		'type': 'post',
		'data': {
			'mode': 'getBuildingList'
		},
		success: function (data) {
			let buildData = JSON.parse(data)
			let buildListHtml = ''
			if (buildData.data == null) return

			//lastSession
			if (sessionStorage.getItem('selectedLastBidg') == null) {
				sessionStorage.setItem("selectedLastBidg", JSON.stringify(buildData.lastBuildingInfo))
			}
		}
	})
}

var userList = function() {
	$.ajax({
		'url': '/user/userAjaxProc.php',
		'type': 'post',
		'data': {
			'mode': 'getUserList',
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
				let phoneVal = (v.phone == null)?"미입력":v.phone
				let gradeVal = (v.grade == null)?"미입력":v.grade
				//console.log(v)

				if(topAuth == v.auth ) topAuthMark = "fa fa-circle text-danger"

				userListHtml += '<tr>'
				userListHtml += '	<td><em class="'+topAuthMark+'"></em></td>'
				userListHtml += '	<td>'+v.name+'</td>'
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
				if(confirm("이동하시겠습니까?")) window.location.href= "/m/monitoringView.php"
			}
			else {
				alert("서버오류")
			}
		}
	})

	//sessionStorage.setItem("selectedDeivceData", JSON.stringify(selectedDeivceData))

	//
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

	console.log(validateYN);
	if(!validateYN) {
		return
	}

	$.ajax({
		'url': '/login/loginProc.php',
		'type': 'post',
		'data': {
			'mode': 'checkPasswd',
			'currentPasswd': currentPasswd.value
		},
		success: function(data){
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
						if(data == 0) {
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

let mobileNavigationDiv = function(){
	let currentPath = window.location.pathname.split('/')[2]
	let mobileNav = document.createElement("div")
	mobileNav.classList.add("mobileNav")

	if(currentPath == 'buildingView.php' ){
		document.getElementById("nav-building").prepend(mobileNav)
	}else if(currentPath == 'monitoringView.php' ) {
		document.getElementById("nav-monitoring").prepend(mobileNav)
	}else if(currentPath == 'logView.php' ) {
		document.getElementById("nav-log").prepend(mobileNav)
	}else if(currentPath == 'userView.php' ) {
		document.getElementById("nav-user").prepend(mobileNav)
	}else if(currentPath == 'changePasswd.php' ) {
		document.getElementById("nav-passwd").prepend(mobileNav)
	}
}

let writeLog = function(comment, serialNo, gwKey, chNo, type){

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
			'bldgName':JSON.parse(sessionStorage.getItem('selectedLastBidg')).org_name
		},
		success: function(data){
			if(data == '0'){
				console.log(chNo + type+ "save log")
			}
			else{
				console.log(chNo + type +'do not save log')
			}
		}
	})
}

let getMobileLog = function() {

	let sDate = document.getElementById('sDate').value
	let eDate = document.getElementById('eDate').value
	let key = getParameter('key')
	let gwKey = getParameter('gwKey')

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
			console.log(logData)
			if(logData != null) {
				$.each(logData.data, function(i, v){
					let targetEvent = (v.etc1 == '')?v.etc2:v.etc1
					let typeName = ''

					if(v.type == '12'){
						typeName = "이상 발생"
					}else if(v.type == '13'){
						typeName = "이상 해제"
					}

					logHtml += "<tr>"
					logHtml += "<td>"
					logHtml += v.regDate.split(" ")[0].replace(/-/gi, ".")+"<br>"
					logHtml += v.regDate.split(" ")[1].substring( -2, 8)
					logHtml += "</td>"
					logHtml += "<td>"
					logHtml += v.etc6
					logHtml += "</td>"
					logHtml += "<td>"
					logHtml += targetEvent + " " +typeName
					logHtml += "</td>"
					logHtml += "</tr>"
				})
			}else{
				logHtml += "<tr>데이터가 없습니다.</tr>"
			}
			$('tbody').html(logHtml)
		}
	})

}

let moveInchLog = function(key, gatewayKey){
	window.location=href="/m/logView.php?key="+key+"&gwKey="+gatewayKey
	//console.log(key, gatewayKey)
}

let outchControl = function(serialNo, gatewayKey, outch1, outch2, outch3, clickedOutch){
	document.getElementById("m_sn").value = serialNo
	document.getElementById("m_gw").value = gatewayKey
	document.getElementById("m_out1").value = outch1
	document.getElementById("m_out2").value = outch2
	document.getElementById("m_out3").value = outch3
	document.getElementById("m_selected").value = clickedOutch

	$("#outControlModal").modal()
}

let saveOutChVal = function(){
	let serialNo = document.getElementById("m_sn").value
	let gatewayKey = document.getElementById("m_gw").value
	let outch1Val = document.getElementById("m_out1").value
	let outch2Val = document.getElementById("m_out2").value
	let outch3Val = document.getElementById("m_out3").value
	let selected = document.getElementById("m_selected").value

	let useYn = 0;
	if(document.getElementsByName("useYN")[0].checked == true) useYn = '3'
	else useYn = '4'

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
			'outch3' : outch3Val
		},
		success : function(data){
			if(data == 0){
				alert("수정되었습니다.");

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
}

let autoLogin = function() {
	let currentPath = window.location.pathname.split('/')[2]
	let failedLogin = getParameter('f')

	if(failedLogin == '1'){
		localStorage.removeItem('i!@#')
		localStorage.removeItem('p!@#')
		localStorage.removeItem('a!@#')
	}

	if(localStorage.getItem("a!@#") == 'true'){
		document.getElementById('id').value = localStorage.getItem('i!@#')
		document.getElementById('passwd').value = localStorage.getItem('p!@#')

		document.getElementById("loginFrm").submit()
	}
}

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
}