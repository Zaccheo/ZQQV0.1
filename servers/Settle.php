<?php

	/**
	 *describe 执行结算
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：预约订单ID，用户信息ID，结算金额，积分数目
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$userOrderId = isset($_GET['uoId']) ? $_GET['uoId'] : null;//预约订单Id
	$uid = isset($_GET['uid']) ? $_GET['uid'] : null;//用户信息id
	$amnt = isset($_GET['amnt']) ? $_GET['amnt'] : null;//结算金额
	$credits = isset($_GET['credits']) ? $_GET['credits'] : null;//积分数目

	if(empty($userOrderId)){
		echo Response::show(300,"请选择订单!",array(),null);
	}else if(empty($uid)){
		echo Response::show(301,"请使用微信客户端打开该页面!",array(),null);
	}else if(empty($amnt)){
		echo Response::show(302,"结算金额为空!",array(),null);
	}else if(empty($credits)){
		echo Response::show(303,"积分数目为空!",array(),null);
	}else{

		$connect = Db::getInstance()->connect();
		//日期格式化
		date_default_timezone_set('PRC');
		//查询用户预约信息
		$uorst = mysql_fetch_assoc(mysql_query("select * from `zqq_users_orders_info` where ordreStatus = 0 and id = ".$userOrderId,$connect));
		//结算减去预定金额等于还需交纳金额
		if($uorst){
			$tempCharge = $amnt - $uorst['orderCharge'];
    			//根据openId查询用户信息的余额
    			$rst = mysql_fetch_assoc(mysql_query("select charge from `zqq_users_info` where id = ".$uid,$connect));
    			//用户余额满足还需交纳金额则可以结算
    			if($rst['charge'] >= $tempCharge){
    				//余额减去还需交纳等于最终剩余,更新用户余额
    				mysql_query("update `zqq_users_info` set credits = credits + ".$credits.",charge = charge - ".$tempCharge." where id = ".$uid,$connect);
    				//更新预约订单信息
    				mysql_query("update `zqq_users_orders_info` set settleCharge=".$amnt.",ordreStatus = 1,orderCompTime= '".date('Y-m-d H:i:s')."' where id = ".$userOrderId,$connect);
    				//更新球场预约信息
    				mysql_query("update `zqq_pitchs_order_info` set orderStatus = 2 where orderID = ".$userOrderId,$connect);
    				//更新用户消费记录
    				$ReChargeSql = " insert into `zqq_charge_history` (userInfoID,charge,otime,flag) values ";
    				$ReChargeSql .= "(".$uid.",".$amnt.",'".date('Y-m-d H:i:s')."',2)";
    				mysql_query($ReChargeSql,$connect);//添加消费记录
    				echo Response::show(200,"结算成功！",array(),null);
    			}else{
    				//用户余额不足还需缴纳金额则返回余额不足
    				echo Response::show(201,"用户余额不足！",array(),null);
    			}
           
		}else{
			echo Response::show(202,"没有对应用户的预约信息！",array(),null);
		}
		
	}

