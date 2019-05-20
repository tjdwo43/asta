<script>
    //시리얼 리스트
    let sessionList = '<?=json_encode($_SESSION)?>';
    let sessionListJson = $.parseJSON(sessionList);

    sessionConsole(sessionListJson)

    //realTime
    let config = fireStoreConf();
    let deviceSerialNoList = '<?=json_encode($getSerialNo)?>';
    let deviceSerialNoListJson = $.parseJSON(deviceSerialNoList);
    let currentDateStr = getTimeStamp();
    let currentPath = window.location.pathname.split('/')[2]

    console.log(deviceSerialNoListJson)

    if(currentPath == 'monitoringView.php') {
        mobileMornitoringView( config, deviceSerialNoListJson)

        setInterval(function() {
            $(".alarm-inch").toggleClass("status-danger")
        }, 1000);
    }
    else if(currentPath == 'buildingView.php') {
        buildingList(config)
    }
    else if(currentPath == 'logView.php') {
        getMobileLog()
    }


    if(typeof JSON.parse(sessionStorage.getItem('selectedLastBidg')) === 'object'){
        document.getElementById("curBuildingName").innerHTML = JSON.parse(sessionStorage.getItem('selectedLastBidg')).org_name
    }

    alertModifyRealTime(config, deviceSerialNoListJson, currentDateStr)

    mobileNavigationDiv()

</script>

</body>
</html>