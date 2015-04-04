<?php
	/**
	*公开比赛活动信息列表
	*
	*/
	
	require_once('../Response.php');
	require_once('../DB.php');

	$id_activities = $_POST['id_activities'];//球赛活动信息ID

	$connect = Db::getInstance()->connect();
	
	//活动状态[0=计划，1=创建，2=进行中，3=完成，4=已取消]
	//$sql = "update zqq_activities set activityStatus=2 where id_activities=".$id_activities;
	//查询到活动信息主体
	$result = true;//mysql_query($sql, $connect);
	if(!$result){
	    echo Response::show(201,"失败！",array(),null);
	}else{
	    echo Response::show(200,"成功!",array(),null);
	}
?>