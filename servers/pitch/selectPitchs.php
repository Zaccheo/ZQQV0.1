<?php

	/**
	*可选场地数据接口
	*by yangzhiqian
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	date_default_timezone_set('PRC');
	$pid = isset($_POST['pid']) ? $_POST['pid'] : null;//球场编号
    //echo $pdate;
	$connect = Db::getInstance()->connect();

	$querySql = "select a.*,b.capacity,b.pitchCode,b.pitchDesc,b.pitchAddr
				 from `zqq_pitchs_order_info` a,`zqq_pitchs_info` b where pitchInfoID = b.id"; 
	if(!empty($pid)){
	 	$querySql.=" and zDate = (select zDate from `zqq_pitchs_order_info` where id = ".$pid.")";
	}
	// if(!empty($queryId)){
	// 	$querySql.=" and b.id = ".$queryId;
	// }
	// if(!empty($queryScale)){
	// 	$querySql.=" and b.capacity = ".$queryScale;
	// }
	$querySql.= " order by a.startTime,pitchCode";
	$result = mysql_query($querySql, $connect);
   	$results = array();

   	$title = array();
   	$time = array();
   	//$cont = 0;
   	while ($row = mysql_fetch_assoc($result)) {
   		// if(!in_array($row['startTime'], $time)){
			// $title['time']['startTime'][] = $row['startTime'];
			// $title['time']['endTime'][] = $row['endTime'];
		$time[] = $row['startTime'];
		$time[] = $row['endTime'];
   		// }
		
		$results['pitch'][$row['pitchCode']][] = $row;//内容放到标题下面
   		//组装查询到的列
		//$results[] = $row;
		//$cont++;
  	}
  	$results['time'] = array_unique($time);
 	echo Response::show(200,"获取成功",$results,null);

?>