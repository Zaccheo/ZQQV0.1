<?php
	/**
	*退出球赛
	*@author yangzhiqian
	*@version 1.0
	*@copyright 四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$actmbeId = $_POST["actmbeId"];//member表中主键
	$type = $_POST["type"];//退出类型 1是本人退出，0是退出队友数量
	$openId = $_POST["openId"];//登录人的openId

	if(empty($openId)){
		echo Response::show(203,"操作失败，openI获取失败!",array(),null);
		exit();
	}
	$connect = Db::getInstance()->connect();
	$quitSql = "";
	if($type == 0){
		$quitSql = "update `zqq_activity_members` set delegateNumber = delegateNumber-1 where id_activity_member = ".$actmbeId;
	}else{
		//检测退出用户是否是最后一个
		$checkLastSql = "select count(*) as cntNum from `zqq_activity_members` where id_activities = (select id_activities from `zqq_activity_members` where id_activity_member = ".$actmbeId.")";
		$memberCntRst = mysql_fetch_assoc(mysql_query($checkLastSql,$connect));
		$cntNum = $memberCntRst['cntNum'];
		if($cntNum == 1){
			//最后一个用户，连同活动一起取消
			$quitSql = "delete from `zqq_activities` where id_activities =(select id_activities from `zqq_activity_members` where id_activity_member = ".$actmbeId.") and activityCreatorOpenId = '".$openId."'";
		}else{
			$quitSql = "delete from `zqq_activity_members` where id_activity_member = ".$actmbeId;
		}
	}
	//退出活动
	if(mysql_query($quitSql, $connect)){
		echo Response::show(200,"退出成功！",array(),null);
	}else{
		echo Response::show(203,"退出失败，系统忙，请稍后再试！",array(),null);
	}
?>