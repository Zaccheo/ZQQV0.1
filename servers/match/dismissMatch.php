<?php
	/**
	*解散球赛
	*
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$actId = $_POST["actId"];
	$openId = $_POST["openId"];

	if(empty($openId)){
		echo Response::show(203,"操作失败，openI获取失败!",array(),null);
		exit();
	}
	$connect = Db::getInstance()->connect();
	$deleActSql = "delete from `zqq_activities` where id_activities = ".$actId." and activityCreatorOpenId = '".$openId."'";
	//参加活动创建
	if(mysql_query($deleActSql, $connect)){
		echo Response::show(200,"删除成功！",array(),null);
	}else{
		echo Response::show(203,"删除失败，系统忙，请稍后再试！",array(),null);
	}
?>