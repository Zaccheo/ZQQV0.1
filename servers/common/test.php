<?php

	$pitchinfo = '[{"startTime":"09:00","endTime":"22:30","oneTime":"90","charge":"360","credits":"360"}]';
	// echo $selectPit;

	$json = json_encode($pitchinfo);

//echo $json;
	rebuildPitchInfo(json_decode($json));

	//重组一次传入的球场信息，将数据处理拆开成按场次的数据包
	function rebuildPitchInfo($json){
    //$rePitchInfo = array();
    foreach ($json as $value) {
        $stime = $value["startTime"];
        $etime = $value["endTime"];
        $otime = $value["oneTime"];
        $stime = explode(":",$stime);//开始时间
        $etime = explode(":",$etime);//结束时间
        $shour = $stime[0];
        $smin = $stime[1];
        $ehour = $etime[0];
        $emin = $etime[1];

        $differHour = abs($shour-$ehour);
        $differMin = abs($smin-$emin);
        $differ = $differHour*60 + $differMin;
        echo $differ/90;
    }
}
?>