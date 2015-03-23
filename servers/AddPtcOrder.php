<?php

	/**
	 *describe 添加球场预约信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：日期，起始时间，结束时间，定价金额，默认积分，球场信息ID
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$orderDate = isset($_GET['od']) ? $_GET['od'] : null;//预约日期
	$startTime = isset($_GET['st']) ? $_GET['st'] : null;//开始时间
	$endTime = isset($_GET['et']) ? $_GET['et'] : null;//结束时间
	$charge = isset($_GET['charge']) ? $_GET['charge'] : null;//定价金额
	$credits = isset($_GET['credit']) ? $_GET['credit'] : null;//默认积分
	$pitchsId = isset($_GET['ptcId']) ? $_GET['ptcId'] : null;//球场信息ID


	if(empty($orderDate)){
		echo Response::show(300,"预约日期为空！",array(),null);
	}else if(empty($startTime)){
		echo Response::show(301,"预约开始时间为空！",array(),null);
	}else if(empty($endTime)){
		echo Response::show(302,"预约结束时间为空！",array(),null);
	}else if(empty($charge)){
		echo Response::show(303,"预约定价金额为空！",array(),null);
	}else if(empty($credits)){
		echo Response::show(304,"预约默认积分为空！",array(),null);
	}else if(empty($pitchsId)){
		echo Response::show(305,"预约球场信息id为空！",array(),null);
	}else{

		$connect = Db::getInstance()->connect();
		$addptch = "insert into `zqq_pitchs_order_info` (zDate,startTime,endTime,charge,credits,pitchInfoID) values ";
		$addptch .= "('".$orderDate."','".$startTime."','".$endTime."',".$charge.",".$credits.",".$pitchsId.")";
		if(mysql_query($addptch,$connect)){
			$getID = mysql_insert_id();
			echo Response::show(200,"SUCCESS",mysql_fetch_assoc(mysql_query("select * from `zqq_pitchs_order_info` where id=".$getID,$connect)),null);
		}else{
			echo Response::show(201,"FAILED",array(),null);
		}
	}