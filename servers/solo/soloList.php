<?php

	/**
	*获取单飞席信息
	*@author yangzhiqian
	*@version 1.0
	*@copyright 四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$filter = isset($_POST['filter'])?$_POST['filter']:null;
	date_default_timezone_set('PRC');
	$connect = Db::getInstance()->connect();
	$sql = "select a.*,b.nickName,b.headerImgUrl from `zqq_solo_list` a,`zqq_users_info` b where a.soloAdminOpenId = b.userOpenId ";
	if(!empty($filter)){
		$sql .= " and a.soloDate = '".$filter."'";
	}
	//查询球赛活动信息
	$result = mysql_query($sql, $connect);
	$results = array();
	if($result){
		while ($row = mysql_fetch_assoc($result)) {
			$results[] =$row;
		}
	}
	echo Response::show(200,"获取成功!",$results,null);
?>