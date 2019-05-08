<?	
	include $_SERVER['DOCUMENT_ROOT']."/inc/header.php";
?>

<style type="text/css">
	#content { 
		position: absolute; top: 40%;  left:calc(50% - 160px);
	}
</style>

<div id="content">
	<img  src="/img/ci_asta_arms_vert.png" alt="Image" style="width:90%">
	<input id="keyword" type="hidden">
</div>

<script type="text/javascript">
	$(function(){
		var pushId = $("#keyword").val();
		var loginPushId = '<?=$_SESSION[pushId]?>';
		
		if(pushId && (!loginPushId || pushId != loginPushId)){
			$.ajax({
				'url' : '/user/userAjaxProc.php',
				'type' : 'post',
				'data' : {
					'mode' : 'updateUser',
					'pushId' : pushId
				}
			});
		}
	});
</script>


<? include $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"?>