<?php
	/**
	*加入单飞席位匹配
	*@author yangzhiqian
	*@version 1.0
	*@copyright 四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$openId = $_POST['openId'];
	$soloid = $_POST['soloid'];
	$userTelNum = $_POST['userTelNum'];

	$connect = Db::getInstance()->connect();
	//校验是否重复
	$repeatSql = "select count(*) cntNum from `zqq_solo_member` where soloMemberOpenId = '".$openId."' and id_solo_list =".$soloid;
	//查询球赛活动信息
	$repeatRst = mysql_query($repeatSql, $connect);
	$rptRow = mysql_fetch_assoc($repeatRst);
	if($rptRow['cntNum'] > 0){
		echo Response::show(201,"校验失败，重复记录!",array(),null);
	}else{
		$joinSoloSql = "insert into `zqq_solo_member` (soloMemberOpenId,id_solo_list) values ";
		$joinSoloSql .= "('".$openId."',".$soloid.")";
		if(mysql_query($joinSoloSql,$connect)){
			echo Response::show(200,"成功!",array(),null);
		}else{
			echo Response::show(202,"系统出问题!",array(),null);
		}
	}
?>