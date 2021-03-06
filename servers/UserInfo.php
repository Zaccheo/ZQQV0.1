<?php
	
	/**
	*describe 获取用户信息
	*author 杨志乾
	*corporate 誉合誉科技有限公司
	*version 1.0
	*date 2014-12-28
	*此接口传入参数：用户openId
	*/

	require_once('./Response.php');
	require_once('./DB.php');

	$openId = isset($_GET['openId']) ? $_GET['openId'] : null;

	//日期格式化
	date_default_timezone_set('PRC');

	if(empty($openId)){
		echo Response::show(300,"请使用微信客户端打开该页面!",array(),null);
	}else{
		$connect = Db::getInstance()->connect();
		//检查openid是否存在
		if(!mysql_fetch_assoc(mysql_query("select * from `zqq_users_info` where weixinNum = '".$openId."'", $connect))){
			echo Response::show(201,"用户获取失败！",array(),null);
		}else{
			echo Response::show(200,"用户获取成功!",mysql_fetch_assoc(mysql_query("select * from `zqq_users_info` where weixinNum = '".$openId."'", $connect)),null);
		}
	}