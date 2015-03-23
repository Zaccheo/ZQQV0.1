<?php
	/**
	 *describe 球场预约信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：球场信息ID，日期，球场容量
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$queryDate = isset($_GET['qdate']) ? $_GET['qdate'] : null;//查询日期
	$queryId = isset($_GET['pcid']) ? $_GET['pcid'] : null;//球场查询id
	$queryScale = isset($_GET['scale']) ? $_GET['scale'] : null;//球场容量

	//日期格式化
	date_default_timezone_set('PRC');

	$connect = Db::getInstance()->connect();

	$querySql = "select a.*,b.id infoId,b.capacity,b.pitchCode,b.pitchDesc,b.pitchAddr
				 from `zqq_pitchs_order_info` a,`zqq_pitchs_info` b where pitchInfoID = b.id"; 
	if(!empty($queryDate)){
		$querySql.=" and zDate = '".$queryDate."'";
	}
	if(!empty($queryId)){
		$querySql.=" and b.id = ".$queryId;
	}
	if(!empty($queryScale)){
		$querySql.=" and b.capacity = ".$queryScale;
	}
	$result = mysql_query($querySql." order by a.startTime", $connect);
   	$results = array();
   	while ($row = mysql_fetch_assoc($result)) {
   		//组装查询到的列
		$results[] = $row;
  	}
 	echo Response::show(200,"获取成功",$results,null);
	