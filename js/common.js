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
	if(confirm("로그아웃 하시겠습니까?")){
		$.ajax({
			'url' : '/login/loginProc.php',
			'type' : 'post',
			'data' : {
				'mode' : 'logout'
			},
			success : function(){
				window.location.href="/index2.php";
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