<?php

	/**
	 *describe 提交预约订单
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：用户openId，球场预约信息id
	 */

	require_once('./Response.php');
	require_once('./DB.php');
	require_once('./Util.php');

	$openId = isset($_GET['openId']) ? $_GET['openId'] : null;
	$poId = isset($_GET['poId']) ? $_GET['poId'] : null;//球场预约信息id

	//sleep(5);
	//echo Response::show(200,"预约订单创建成功！",array(),null);
	//*
	if(empty($openId)){
		echo Response::show(300,"请使用微信客户端打开该页面!",array(),null);
	}else if(empty($poId)){
		echo Response::show(301,"球场预约信息id为空!",array(),null);
	}else{
		//日期格式化
		date_default_timezone_set('PRC');
		$connect = Db::getInstance()->connect();

		//查询出当前球场预约信息
		$result = mysql_fetch_assoc(mysql_query("select * from `zqq_pitchs_order_info` where id=".$poId,$connect));
		if($result){
			if($result['orderStatus'] == 0){
				//根据openId查询用户信息的ID
				$userInfoSql = "select id,charge from `zqq_users_info` where weixinNum = '".$openId."'";
				$rst = mysql_fetch_assoc(mysql_query($userInfoSql,$connect));
				//用户余额减去预约金额
				$cut = $rst['charge'] - $result['charge'];
				if($cut < 0){
					echo Response::show(201,"用户余额不足！",array(),null);
				}else{
					//根据毫秒产生当前生成的预约订单编号
					$orderId = Util::getMillisecond();
					$uorderSql = "insert into `zqq_users_orders_info` (ordreID,userInfoID,orderCharge,orderCreatedTime) values ";
					$uorderSql .= "('".$orderId."',".$rst['id'].",".$result['charge'].",'".date('Y-m-d H:i:s')."')";
					//创建预约订单
					if(mysql_query($uorderSql,$connect)){
						$uorderId = mysql_insert_id();
						//更新球场预约信息表
						$updatePtcOrd = "update `zqq_pitchs_order_info` set orderID = '".$uorderId."',orderStatus = 1 where id=".$poId;
						mysql_query($updatePtcOrd,$connect);
						mysql_query("update `zqq_users_info` set charge = ".$cut." where weixinNum = '".$openId."'",$connect);

						echo Response::show(200,"预约订单创建成功！",$uorderId,null);
					}else{
						echo Response::show(202,"预约订单创建失败！",array(),null);
					}
				}
			}else{
				echo Response::show(203,"预约订单创建失败,该场地没有开放预约！",array(),null);
			}
		}else{
			echo Response::show(204,"没有查找到对应球场的预约信息！",array(),null);
		}
	}
	//*/