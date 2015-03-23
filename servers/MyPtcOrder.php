<?php

	/**
	 *describe 获取订单信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：openId，ordreStatus
	 */
	require_once('./Response.php');
	require_once('./DB.php');

	$openId = isset($_GET['openId']) ? $_GET['openId'] : null;//用户OPENID
	if(empty($openId)){
		echo Response::show(300,"请使用微信客户端打开该页面！",array(),null);
	}else{

		$connect = Db::getInstance()->connect();
		$result = mysql_query("select * from `zqq_users_orders_info` where userInfoID = (select id from `zqq_users_info` where weixinNum = '".$openId."')",$connect);
   		$results = array();
   		while ($row = mysql_fetch_assoc($result)) {
   			//组装查询到的列
			$results[] = $row;
  		}
  		if(empty($results)){
			echo Response::show(201,"该用户没有订单信息！",$results,null);
  		}else{
  			echo Response::show(200,"获取成功！",$results,null);
  		}
	}