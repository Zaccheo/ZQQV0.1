<?php
	/**
	 *describe 修改球场预约信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：球场预约信息ID，定价金额，默认积分
	 */
	require_once('./Response.php');
	require_once('./DB.php');

	$charge = isset($_GET['charge']) ? $_GET['charge'] : null;//定价金额
	$credits = isset($_GET['credit']) ? $_GET['credit'] : null;//默认积分
	$ptcOdrId = isset($_GET['poId']) ? $_GET['poId'] : null;//球场预约信息ID

	if(empty($charge)){
		echo Response::show(303,"预约定价金额为空！",array(),null);
	}else if(empty($credits)){
		echo Response::show(304,"预约默认积分为空！",array(),null);
	}else if(empty($ptcOdrId)){
		echo Response::show(305,"球场预约信息id为空！",array(),null);
	}else{
		$connect = Db::getInstance()->connect();
		//日期格式化
		date_default_timezone_set('PRC');
		//查询取出当前要修改的数据
		$result = mysql_fetch_assoc(mysql_query("select * from `zqq_pitchs_order_info` where id=".$ptcOdrId,$connect));

		if($result){
			//只能修改当前时间后，并且未被预约的
			if($result['zDate'] >= date('Y-m-d') && (empty($result['orderID']) || $result['orderID'] == "")){
				$editptch = "update `zqq_pitchs_order_info` set charge = ".$charge.",credits = ".$credits." where id = ".$ptcOdrId;
				if(mysql_query($editptch,$connect)){
					echo Response::show(200,"SUCCESS",mysql_fetch_assoc(mysql_query("select * from `zqq_pitchs_order_info` where id=".$ptcOdrId,$connect)),null);
				}else{
					echo Response::show(201,"FAILED",array(),null);
				}
			}else{
				echo Response::show(202,"只能修改当前时间后，并且未被预约的！",array(),null);
			}
		}else{
			echo Response::show(203,"修改失败，该条记录不存在！",array(),null);
		}
	}