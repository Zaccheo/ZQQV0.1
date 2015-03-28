<?php
	/*
	*获取注册的用户列表
	*@author yangzhiqian
	*@date 2015-03-24
	*@version v0.1 
	*@copy  四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$page = isset($_POST["page"]) ? $_POST["page"] : 0;//分页

	$connect = Db::getInstance()->connect();
	$commentsql = "select * from `zqq_users_info` order by regTime desc limit ".$page.",10";//分页显示



?>