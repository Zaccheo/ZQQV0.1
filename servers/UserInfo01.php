<?php
	
	/**
	*describe 获取用户信息
	*author 杨志乾
	*corporate 誉合誉科技有限公司
	*version 1.0
	*date 2014-12-28
	*此接口传入参数：用户会员卡号或电话号码
	*/

	require_once('./Response.php');
	require_once('./DB.php');

	$key_search = isset($_GET['key_search']) ? $_GET['key_search'] : null;
	//日期格式化
	date_default_timezone_set('PRC');

	if(empty($key_search)){
		echo Response::show(300,"key_search参数错误!",array(),null);
	}else{
		$connect = Db::getInstance()->connect();
		
		if(!mysql_fetch_assoc(mysql_query("select * from `zqq_users_info` where cardID = '".$key_search."' or phoneNumber = '".$key_search."'", $connect))){
			echo Response::show(201,"用户获取失败！",array(),null);
		}else{
			echo Response::show(200,"用户获取成功!",mysql_fetch_assoc(mysql_query("select * from `zqq_users_info` where cardID = '".$key_search."' or phoneNumber = '".$key_search."'", $connect)),null);
		}
	}