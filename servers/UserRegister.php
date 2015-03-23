<?php
	/**
	*describe 用户注册
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
	$sex = isset($_GET['sex']) ? $_GET['sex'] : 0;

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
		//检查openid是否存在，不存在注册
		$result = mysql_fetch_assoc(mysql_query("select * from `zqq_users_info` where weixinNum = '".$openId."'", $connect));
		if(!$result){
			//校验电话号码是否重复
			if(!mysql_fetch_assoc(mysql_query("select * from `zqq_users_info` where phoneNumber = ".$telPhone, $connect))){
				$newUserSql = "insert into zqq_users_info(sex,cardID,username,phoneNumber,weixinNum,regTime) values ";
				$newUserSql .= " (".$sex.",".$telPhone.",'".$userName."',".$telPhone.",'".$openId."','".date('Y-m-d H:i:s')."')";
				if(mysql_query($newUserSql,$connect)){
					echo Response::show(200,"注册成功!",mysql_fetch_assoc(mysql_query("select * from `zqq_users_info` where weixinNum = '".$openId."'", $connect)),null);
				}
			}else{
				echo Response::show(303,"注册失败!重复的电话号码！",array(),null);
			}
		}else{
			echo Response::show(201,"用户已注册!",$result,null);
		}
	}
