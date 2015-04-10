<?php

	/**
	*可选场地数据接口
	*by yangzhiqian
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	date_default_timezone_set('PRC');
	$pdate = isset($_POST['pdate']) ? $_POST['pdate'] : null;//球场编号
    //echo $pdate;
	$connect = Db::getInstance()->connect();

	$querySql = "select a.*,b.capacity,b.pitchCode,b.pitchDesc,b.pitchAddr
				 from `zqq_pitchs_order_info` a,`zqq_pitchs_info` b where pitchInfoID = b.id"; 
	if(!empty($pdate)){
	 	$querySql.=" and zDate = '".$pdate."'";
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
		
		$results['pitch'][$row['pitchCode'].$row['capacity'].'人'][] = $row;//内容放到标题下面
   		//组装查询到的列
		//$results[] = $row;
		//$cont++;
  	}

  	foreach (array_unique($time) as $value) {
  		$results['time'][] = $value;
  	}
  	// //var_dump($results['pitch'][0]);
  	// foreach ($results['time'] as $tk => $tv) {
  	// 	$newPitchs = array();
  	// 	$pitchsCount = 0;//球赛的行索引
  	// 	foreach ($results['pitch'] as $key => $value) {
  	// 		foreach ($value as $k => $v) {
  	// 			if($tv != $v['startTime']){
  	// 				$newOnePitch = array(
			// 				'id'=>'tmp'.$v['id'],
			// 				'orderStatus'=>'1',
			// 				'pitchCode'=>$v['pitchCode'],
			// 				'pitchDesc'=>$v['pitchDesc'],
			// 				'pitchInfoID'=>$v['pitchInfoID'],
			// 				'startTime'=>$tv,
			// 				'zDate'=>$v['zDate'],
			// 			);
  	// 				array_push($newPitchs, $newOnePitch);
  	// 			}
  	// 				array_push($newPitchs, $value);
  	// 		}




  	// 		if(array_key_exists($pitchsCount,$value) && $tv != $value[$pitchsCount]['startTime']){
	  // 			$newOnePitch = array(
			// 				'id'=>'tmp'.$value[$pitchsCount]['id'],
			// 				'orderStatus'=>'1',
			// 				'pitchCode'=>$value[$pitchsCount]['pitchCode'],
			// 				'pitchDesc'=>$value[$pitchsCount]['pitchDesc'],
			// 				'pitchInfoID'=>$value[$pitchsCount]['pitchInfoID'],
			// 				'startTime'=>$tv,
			// 				'zDate'=>$value[$pitchsCount]['zDate'],
			// 				);
	  // 			//$value[] = $newOnePitch;
	  // 			array_push($value, $newOnePitch);
	  // 			//var_dump($value);
	  // 		}
	  // 		$pitchsCount++;
	  // 		continue;
  	// 	}
  	// 	//$newPitchs[] = $value;
  	// }
  	// foreach ($results['pitch'] as $key => $value) {
  	// 	$newPitchs = array();
  	// 	foreach ($value as $k => $v) {
	  		
  	// 	}
  	// 	$results['pitch'][$key] = $newPitchs;
  	// 		// if(in_array($v['startTime'], $results['time'])){
  	// 		// 	//var_dump($v);
  	// 		// 	//$results['pitch'][$key][] = $results['pitch'][$key][$k];
  	// 		// }
  	// }
 	echo Response::show(200,"获取成功",$results,null);

?>