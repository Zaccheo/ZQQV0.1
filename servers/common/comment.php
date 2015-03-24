<?php
	/*
	*通用的评论系统处理后台
	*@author yangzhiqian
	*@date 2015-03-24
	*@version v0.1 
	*@copy  四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$openId = $_POST['openId'];
	$moduleId = $_POST['moduleId'];
	$content = $_POST['content'];
	$moduleFlag = $_POST['moduleFlag'];

	date_default_timezone_set('PRC');
	$connect = Db::getInstance()->connect();
	$commentsql = "insert into `zqq_msg_board` (msgUserOpenId,msgDateTime,msgContent,msgModuleFlag,msgModuleId) values ";
	$commentsql .= "('".$openId."','".date('Y-m-d H:i:s')."','".$content."','".$moduleFlag."','".$moduleId."')";
	//创建比赛活动
	if(mysql_query($commentsql, $connect)){
		echo Response::show(200,"评论成功！",array(),null);
	}else{
		echo Response::show(203,"评论失败！",array(),null);
	}
?>