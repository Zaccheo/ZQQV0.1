<?php
	/**
	*参加活动
	*
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$type = $_POST["type"];
	$openId = $_POST["openId"];
	$userTelNum = $_POST['userTelNum'];
	$repreNum = $_POST['repreNum'];//代表人数
	$activeId = $_POST['activeId'];

	$connect = Db::getInstance()->connect();

	if(empty($openId)){
		echo Response::show(205,"加入失败，openI获取失败!",array(),null);
		exit();
	}
	//查询用户信息
	$userSql = "select phoneNumber,flag,personalLevel from `zqq_users_info` where userOpenId='".$openId."'";
	$userInfo = mysql_fetch_assoc(mysql_query($userSql,$connect));

	//检查电话号码是否需要更新
	if($userInfo['phoneNumber'] == "" || $userInfo['phoneNumber'] != $userTelNum){
		$updateTelSql = "update `zqq_users_info` set phoneNumber = '".$userTelNum."' where userOpenId='".$openId."'";
		if(!mysql_query($updateTelSql,$connect)){
			echo Response::show(205,"加入失败，电话号码未成功录入!",array(),null);
			exit();
		}
	}
	if($userInfo['flag'] == 2){
		echo Response::show(206,"加入失败，请确认是否已关注本公众号！",array(),null);
	}else{
		$joinSql = "insert into `zqq_activity_members` (activitymemberOpenId,host_or_guest,delegateNumber,personalLevel,id_activities)";//查询活动
		$joinSql .= " values('".$openId."','".$type."','".$repreNum."','".$userInfo['personalLevel']."','".$activeId."')";
		//参加活动创建
		if(mysql_query($joinSql, $connect)){
			echo Response::show(200,"加入成功！",array(),null);
		}else{
			echo Response::show(203,"加入失败，系统忙，请稍后再试！",array(),null);
		}
	}
?>