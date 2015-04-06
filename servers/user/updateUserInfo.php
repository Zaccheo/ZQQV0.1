<?php

	/**
	*describe 更新用户信息
	*author 杨志乾
	*corporate 誉合誉科技有限公司
	*version 1.0
	*date 2014-12-28
	*此接口传入参数：用户openId，电话号码，选择的擅长位置
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$openId = isset($_POST['openId']) ? $_POST['openId'] : null;
	$phoneNumber = $_POST['phoneNumber'];
	$skilledPosition = $_POST['skilledPosition'];
	
	$skill_str = "";
	if(!empty($skilledPosition)){
		foreach ($skilledPosition as $key => $value) {
			if($skill_str == "")
				$skill_str .= $value;
			else
				$skill_str .= ",".$value;
		}
	}

	$connect = Db::getInstance()->connect();
	$updateUserSql = " update `zqq_users_info` set skilledPosition = '".$skill_str."',phoneNumber='".$phoneNumber."' where userOpenId = '".$openId."'";
	//查询球赛活动信息
	if(mysql_query($updateUserSql, $connect)){
		echo Response::show(200,"更新成功！",array(),null);
	}else{
		echo Response::show(201,"更新失败！请稍后再试！",array(),null);
	}
?>