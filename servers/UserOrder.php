<?php

	/**
	 *describe 用户订单信息和球场预约信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *接口输入参数：电话号码或订单编号或会员卡号
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$inputId = isset($_GET['inputId']) ? $_GET['inputId'] : null;

	if(empty($inputId)){
		echo Response::show(300,"填写订单编号或电话号码或会员卡号!",array(),null);
	}else{
		$orderSql = " select b.id as oid,b.orderCharge ,poi.zDate,poi.startTime,poi.endTime from `zqq_pitchs_order_info` poi join `zqq_users_orders_info` b left join `zqq_users_info` a 
					  on b.userInfoID = a.id  and poi.orderID=b.id where b.ordreStatus=  0 and (b.ordreID=".$inputId." or a.phoneNumber=".$inputId." or a.cardID=".$inputId.")";
		$connect = Db::getInstance()->connect();
		$result = mysql_query($orderSql,$connect);
   		$results = array();
   		while ($row = mysql_fetch_assoc($result)) {
   			//组装查询到的列
			$results[] = $row;
  		}
  		$uif = "select a.* from `zqq_users_info` a left join `zqq_users_orders_info` b on a.id = b.userInfoID where b.ordreID=".$inputId." or a.phoneNumber=".$inputId." or a.cardID=".$inputId;
  		$user = mysql_fetch_assoc(mysql_query($uif, $connect));
  		$json = array(
			'user' => $user,
			'orders' => $results
		);
  		if($user==false){
  		    echo Response::show(201,"没有符合条件的用户！",array(),null);;
  		}else{
		  echo Response::show(200,"获取成功！",$json,null);;
  		}
	}

