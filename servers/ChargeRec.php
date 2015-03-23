<?php

	/**
	*describe 用户消费记录
	*author 杨志乾
	*corporate 誉合誉科技有限公司
	*version 1.0
	*date 2014-12-28
	*此接口传入参数：用户openId
	*/


	require_once('./Response.php');
	require_once('./DB.php');

	$openId = isset($_GET['openId']) ? $_GET['openId'] : null;
	
	if(empty($openId)){
		echo Response::show(300,"请使用微信客户端打开该页面!",array(),null);
	}else{
		$connect = Db::getInstance()->connect();
		$sql = "select b.* from `zqq_users_info` a join `zqq_charge_history` b 
				on a.id=b.userInfoID where a.weixinNum = '".$openId."'";
		//$result = mysql_fetch_assoc(mysql_query($sql, $connect));
		
		$result = mysql_query($sql, $connect);
		$results = array();
		while ($row = mysql_fetch_assoc($result)) {
		    //组装查询到的列
		    $results[] = $row;
		}
		//if(!$result){
		//	echo Response::show(201,"用户没有消费记录！",array(),null);
		//}else{
			echo Response::show(200,"消费记录获取成功!",$results,null);
		//}
	}

	