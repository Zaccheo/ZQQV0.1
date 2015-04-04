<?php
	/**
	*公开比赛活动信息列表
	*
	*/
	
	require_once('../Response.php');
	require_once('../DB.php');

	$id_activities = $_POST['id_activities'];//球赛活动信息ID

	$connect = Db::getInstance()->connect();
	$sql = "select * from matches2settleview where id_activities=".$id_activities;
	//查询到活动信息主体
	$result = mysql_fetch_assoc(mysql_query($sql, $connect));
	if(!$result){
	    echo Response::show(201,"获取失败！",array(),null);
	}else{
	    echo Response::show(200,"获取成功!",$result,null);
	}
?>