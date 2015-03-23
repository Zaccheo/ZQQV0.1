<?php
	/**
	*describe 球场信息
	*author 杨志乾
	*corporate 誉合誉科技有限公司
	*version 1.0
	*date 2014-12-28
	*
	*/

	require_once('./Response.php');
	require_once('./DB.php');

	$connect = Db::getInstance()->connect();
	$result = mysql_query("select * from `zqq_pitchs_info`",$connect);
   	$results = array();
   	while ($row = mysql_fetch_assoc($result)) {
   		//组装查询到的列
		$results[] = $row;
  	}
 	echo Response::show(200,"获取成功",$results,null);
	
	