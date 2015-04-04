<?php
	/**
	*公开比赛活动信息列表
	*
	*/
	
	require_once('../Response.php');
	require_once('../DB.php');

	//活动状态[0=计划，1=创建，2=进行中，3=完成，4=已取消]

	$connect = Db::getInstance()->connect();
	$sql = "select * from matches2settleview where activityStatus>=1 and activityStatus<=3";
	//查询到活动信息主体
	$result = mysql_query($sql, $connect);
	$results = array();
	while ($row = mysql_fetch_assoc($result)) {
		$results[] = $row;
	}
	echo Response::show(200,"获取成功!",$results,null);
?>