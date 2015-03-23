<?php
	/**
	 *describe 会员充值
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：会员信息ID，充值金额，充值标示(充值或提现) 0 或 1
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$uid = isset($_GET['uid']) ? $_GET['uid'] : null;//用户信息id
	$amnt = isset($_GET['amnt']) ? $_GET['amnt'] : null;//充值金额
	$flag = isset($_GET['flag']) ? $_GET['flag'] : null;//充值标识充值标示 0=向账户充值 1=从账户提现(比如退钱)



	if(empty($uid)){
		echo Response::show(300,"请使用微信客户端打开该页面!",array(),null);
	}else if(empty($amnt)){
		echo Response::show(301,"充值金额为空！",array(),null);
	}else if(is_null($flag)){
		echo Response::show(302,"充值标识为空!",array(),null);
	}else{

		$connect = Db::getInstance()->connect();
		//日期格式化
		date_default_timezone_set('PRC');
		$ReChargeSql = " insert into `zqq_charge_history` (userInfoID,charge,otime,flag) values ";
		$ReChargeSql .= "(".$uid.",".$amnt.",'".date('Y-m-d H:i:s')."',$flag)"; 
		if($flag == 0){
			//向账户充值
			mysql_query("update `zqq_users_info` set charge = charge+".$amnt.",credits = credits+".$amnt." where id = ".$uid,$connect);
			mysql_query($ReChargeSql,$connect);//充值记录
			echo Response::show(200,"充值成功!",array(),null);
		}else{
			//向账户提现
			$userChargeRst = mysql_fetch_assoc(mysql_query("select charge from `zqq_users_info` where id = ".$uid,$connect));
			if($userChargeRst['charge'] < $amnt){
				echo Response::show(201,"提现失败，提现超出余额!",array(),null);
			}else{
				mysql_query("update `zqq_users_info` set charge = charge-".$amnt." where id = ".$uid,$connect);
				mysql_query($ReChargeSql,$connect);//提现记录
				echo Response::show(200,"提现成功!",array(),null);
			}
		}
	}