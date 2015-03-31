<?php

	/**
	*获取单飞席信息
	*@author yangzhiqian
	*@version 1.0
	*@copyright 四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$connect = Db::getInstance()->connect();
	$sql = "select * from `zqq_solo_list` a,`zqq_users_info` b,`zqq_pitchs_order_info` c where ";//查询活动
	//查询球赛活动信息
	$result = mysql_query($sql, $connect);
	if($result){
		while ($row = mysql_fetch_assoc($result)) {
			# code...
		}
	}

?>