<?php

	/**
	 *describe 获取订单信息详细
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：球场预约订单id
	 */
	require_once('./Response.php');
	require_once('./DB.php');

	$ptcId = isset($_GET['ptcId']) ? $_GET['ptcId'] : null;//订单信息ID

	if(empty($ptcId)){
		echo Response::show(300,"订单信息ID为空！",array(),null);
	}else{

		$connect = Db::getInstance()->connect();
		$sql = "select * from zqq_users_orders_info uo join zqq_pitchs_order_info poi join zqq_pitchs_info pi"
		    ." on poi.orderID=uo.id and poi.pitchInfoID=pi.id where uo.id =".$ptcId."";
		$results = mysql_fetch_assoc(mysql_query($sql, $connect));
		
		if(!$results){
			echo Response::show(201,"用户信息失败！",array(),null);
		}else{
			echo Response::show(200,"用户获取成功!",$results,null);
		}
	}