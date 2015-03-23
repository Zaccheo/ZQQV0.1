<?php
	/**
	 *describe 删除球场预约信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：球场预约信息ID
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$ptcOdrId = isset($_GET['poId']) ? $_GET['poId'] : null;//球场预约信息ID

	if(empty($ptcOdrId)){
		echo Response::show(300,"球场预约信息id为空！",array(),null);
	}else{
		$connect = Db::getInstance()->connect();
		//日期格式化
		date_default_timezone_set('PRC');
		//查询取出当前要修改的数据
		$result = mysql_fetch_assoc(mysql_query("select * from `zqq_pitchs_order_info` where id=".$ptcOdrId,$connect));
		if($result){
			//只能修改当前时间后，并且未被预约的
			if($result['zDate'] >= date('Y-m-d') && (empty($result['orderID']) || $result['orderID'] == "")){
				$delSql = " delete from `zqq_pitchs_order_info` where id = ".$ptcOdrId;
				if(mysql_query($delSql,$connect)){
					echo Response::show(200,"SUCCESS",array(),null);
				}else{
					echo Response::show(201,"FAILED",array(),null);
				}
			}else{
				echo Response::show(202,"只能删除当前时间后，并且未被预约的！",array(),null);
			}
		}else{
			echo Response::show(203,"删除失败，该条记录不存在！！",array(),null);
		}
	}