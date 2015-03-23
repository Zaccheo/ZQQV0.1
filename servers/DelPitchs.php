<?php

	/**
	 *describe 删除球场信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$ptcId = isset($_GET['ptcId']) ? $_GET['ptcId'] : null;//球场信息编号

	if(empty($ptcId)){
		echo Response::show(315,"球场信息id不能为空!",array(),null);
	}else{
		$connect = Db::getInstance()->connect();

		$queryPtcOrder = "select count(*) as count from `zqq_pitchs_order_info` where pitchInfoID = ".$ptcId;
		$result=mysql_fetch_array(mysql_query($queryPtcOrder));
		$count=$result['count']; 
		if($count>0){
			echo Response::show(207,"删除失败！该球场已经存在有预约信息！",array(),null);
		}else{
			$delPtcSql = "delete from `zqq_pitchs_info` where id = ".$ptcId;
			if(mysql_query($delPtcSql)){
				echo Response::show(200,"删除成功！",array(),null);
			}else{
				echo Response::show(208,"删除失败！",array(),null);
			}
		}
	}