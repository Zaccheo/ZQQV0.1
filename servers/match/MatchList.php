<?php
	/**
	*公开比赛活动信息列表
	*
	*/
	
	require_once('../Response.php');
	require_once('../DB.php');

	$token = $_POST['zqq_token'];

	$connect = Db::getInstance()->connect();
	$sql = "select * from `zqq_activities` where activityStatus = 1 order by activityCreateTime desc limit 10";//查询活动已创建完成
	//查询到活动信息主体
	$result = mysql_query($sql, $connect);
	$results = array();
	// $activeArr = array();//封装活动和对应成员数据的对象
	while ($row = mysql_fetch_assoc($result)) {
		// $rowObj = array();
		// $memberSql = "select * from `zqq_activity_members` where id_activities = ".$row['id_activities'];
		// $memberRst = mysql_query($memberSql,$connect);
		// while ($memberRow = mysql_fetch_assoc($memberRst)) {
		// 	$rowObj[] = $memberRow;
		// }
		//组装查询到的列
		// $activeArr['active'] = $row;//活动数据
		// $activeArr['active']['member'] = $rowObj;//成员数据
		$results[] = $row;
	}
	echo Response::show(200,"获取成功!",$results,null);
?>