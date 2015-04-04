<?php

	/**
	*创建单飞席需求
	*@author yangzhiqian
	*@version 1.0
	*@copyright 四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$openId = $_POST['openId'];
	$soloDate = $_POST['soloDate'];//日期
	$soloStime = $_POST['soloStime'];//开始时间
	$soloEtime = $_POST['soloEtime'];//结束时间
	$numberWanted = $_POST['numberWanted'];//需求人数


	$connect = Db::getInstance()->connect();
	$creat = "insert into `zqq_solo_list` (soloDate,soloStartTime,soloEndTime,soloAdminOpenId,numberWanted) values ";
	$creat .= "('".$soloDate."','".$soloStime."','".$soloEtime."','".$openId."',".$numberWanted.")";
	//创建单飞席信息
	if(mysql_query($creat, $connect)){
		echo Response::show(200,"活动创建成功！",array(),null);
	}else{
		echo Response::show(203,"活动创建失败！",array(),null);
	}
?>