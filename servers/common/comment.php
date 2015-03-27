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
	$moduleFlag = $_POST['moduleFlag'];//模块标识，1代表活动active，2代表单飞营

	date_default_timezone_set('PRC');
	$connect = Db::getInstance()->connect();
	$commentsql = "insert into `zqq_msg_board` (msgUserOpenId,msgDateTime,msgContent,";
	if($moduleFlag == 1){
		$commentsql .= "id_activity"; //活动模块主键
	}else{
		$commentsql .= "id_solo_list";//单飞营模块主键
	}
	$commentsql .= ") values ";
	$commentsql .= "('".$openId."','".date('Y-m-d H:i:s')."','".$content."','".$moduleId."')";
	//创建评论
	if(mysql_query($commentsql, $connect)){
		echo Response::show(200,"评论成功！",array(),null);
	}else{
		echo Response::show(203,"评论失败！",array(),null);
	}
?>