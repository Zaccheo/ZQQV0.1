<?php

	/**
	*球赛活动信息
	*/
	
	require_once('../Response.php');
	require_once('../DB.php');

	$connect = Db::getInstance()->connect();
	$sql = "select a.*,b.nickName,b.headerImgUrl from `zqq_solo_list` a,`zqq_users_info` b where a.soloAdminOpenId = b.userOpenId and to_days(a.soloDate) = to_days(now())";//查询活动
	//查询球赛活动信息
	$results = mysql_query($sql, $connect);
	$result = array();
	if($results){
		while ($row = mysql_fetch_assoc($results)) {
			$result[] = $row;
		}
	}
	echo Response::show(200,"获取成功!",$result,null);

?>