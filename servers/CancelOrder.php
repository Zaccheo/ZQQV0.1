<?php
	/**
	 *describe 取消预约订单
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：用户openid，预约订单ID
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$openId = isset($_GET['openId']) ? $_GET['openId'] : null;//用户OPENID
	$userOrderId = isset($_GET['uoId']) ? $_GET['uoId'] : null;//预约订单Id

	if(empty($openId)){
		echo Response::show(300,"请使用微信客户端打开该页面!",array(),null);
	}else if(empty($userOrderId)){
		echo Response::show(301,"预约订单id为空!",array(),null);
	}else{

		$connect = Db::getInstance()->connect();
		//查询出当前球场预约信息
		$result = mysql_fetch_assoc(mysql_query("select * from `zqq_users_orders_info` where id = ".$userOrderId,$connect));
		if($result['ordreStatus'] != 0){
			echo Response::show(201,"预约订单球场已经失效（被使用或者已取消），无法取消！",array(),null);
		}else{
			$cancelUserOrder = "update `zqq_users_orders_info` set ordreStatus = 2 where id = ".$userOrderId;
			if(mysql_query($cancelUserOrder,$connect)){
				mysql_query("update `zqq_users_info` set charge = charge+".$result['orderCharge']." where weixinNum = '".$openId."'");
				mysql_query("update `zqq_pitchs_order_info` set orderStatus = 0,orderID = null where orderID = ".$userOrderId);
				echo Response::show(200,"预约订单取消成功！",array(),null);
			}else{
				echo Response::show(202,"取消失败！",array(),null);
			}
		}
	}