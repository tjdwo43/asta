		<?if($isMobileBar){?>
			<!-- 모바일 하단 탭바 -->
			<div class="mobile-navbar">
				<a data-toggle-state="aside-toggled" data-no-persist="true">
					<em class="fas fa-bars"></em>
				</a>
				<a onclick="movetop();">
					<em class="fas fa-chevron-up"></em>
				</a>
			</div>
		<?}?>

		<script type="text/javascript">
            
            //시리얼 리스트
            var deviceSerialNoList = '<?=json_encode($getSerialNo)?>';
            var deviceSerialNoListJson = $.parseJSON(deviceSerialNoList);

            $(document).ready(function(){
                let currentDateStr = getTimeStamp();
                let config = fireStoreConf();

                if('<?=$basename?>' == 'deviceMornView.php') {
                    updateMornViewRealTime(config, deviceSerialNoListJson)
                }

                if('<?=$basename?>' == 'deviceConfView.php') {
                    updateGWViewRealTime(config, deviceSerialNoListJson)
                    updateMainViewRealTime(config, deviceSerialNoListJson)
                }

                alertModifyRealTime(config, deviceSerialNoListJson, currentDateStr)

            }); // E : realTime document.ready

		</script>
	</body>
</html>
