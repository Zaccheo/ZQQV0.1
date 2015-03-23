<?php
	
	/**
	*describe 编辑用户信息
	*author 杨志乾
	*corporate 誉合誉科技有限公司
	*version 1.0
	*date 2014-12-28
	*此接口传入参数：用户openId
	*/

	require_once('./Response.php');
	require_once('./DB.php');

	$openId = isset($_GET['openId']) ? $_GET['openId'] : null;
	$userName = isset($_GET['userName']) ? $_GET['userName'] : "";
	$telPhone = isset($_GET['telPhone']) ? $_GET['telPhone'] : 0;

	//日期格式化
	date_default_timezone_set('PRC');

	if(empty($openId)){
		echo Response::show(300,"请使用微信客户端打开该页面!",array(),null);
	}else if(empty($userName)){
		echo Response::show(301,"用户名为空!",array(),null);
	}else if(empty($telPhone)){
		echo Response::show(302,"电话号码为空!",array(),null);
	}else{
		$connect = Db::getInstance()->connect();
		if(mysql_query("update `zqq_users_info` set username='".$userName."',phoneNumber='".$telPhone."' where weixinNum = '".$openId."'", $connect)){
			echo Response::show(200,"用户信息修改成功！",null,null);
		}else{
			echo Response::show(202,"用户编辑失败!",null,null);
		}
	}