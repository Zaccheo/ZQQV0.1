<?php

	/**
	*可选时间数据接口
	*by yangzhiqian
	*/

	require_once('../Response.php');
	require_once('../DB.php');
	date_default_timezone_set('PRC');
	$todaytime=date("Y-m-d");
	//echo $todaytime;
	$connect = Db::getInstance()->connect();
	$querySql = "select a.id,a.zDate from `zqq_pitchs_order_info` a,`zqq_pitchs_info` b  where a.zDate >= '".$todaytime."' and a.pitchInfoID = b.id group by a.zDate limit 7"; 
	$results = mysql_query($querySql);
	$result = array();
	while($row = mysql_fetch_assoc($results)){
		$result[] = $row;
	}
	echo Response::show(200,"获取成功",$result,null);
?>