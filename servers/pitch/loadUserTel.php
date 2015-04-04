<?php
	/**
	*查询用户手机号码
	*by yangzhiqian
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$openId = isset($_POST['openId']) ? $_POST['openId'] : null;
	if(!empty($openId)){
		$connect = Db::getInstance()->connect();
		$querySql = "select phoneNumber from `zqq_activities` where id_activities = (select MAX(id_activities) from `zqq_activities` where activityCreatorOpenId='".$openId."')"; 
		$results = mysql_query($querySql,$connect);
		$result = array();
		if($results){
			$activeRow = mysql_fetch_assoc($results);
			$result['telPhone'] = $activeRow['phoneNumber'];
		}else{
			$queryUserSql = "select phoneNumber from `zqq_users_info` where userOpenId='".$openId."'"; 
			$userRst = mysql_query($queryUserSql,$connect);
			if($userRst){
				$userRow = mysql_fetch_assoc($userRst);
				$result['telPhone'] = $userRow['phoneNumber'];
			}
		}
		echo Response::show(200,"获取成功",$result,null);
	}else{
		echo Response::show(201,"获取失败，openId不能为空！",array(),null);
	}
?>