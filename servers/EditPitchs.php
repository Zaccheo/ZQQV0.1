<?php
	/**
	 *describe 编辑球场信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$ptcId = isset($_GET['ptcId']) ? $_GET['ptcId'] : null;//球场信息编号
	$code = isset($_GET['code']) ? $_GET['code'] : null;//球场信息编号
	$capacity = isset($_GET['capa']) ? $_GET['capa'] : null;//容纳人数
	$desc = isset($_GET['desc']) ? $_GET['desc'] : null;//球场描述
	$addr = isset($_GET['addr']) ? $_GET['addr'] : null;//地址


	if(empty($ptcId)){
		echo Response::show(310,"球场信息Id不能为空!",array(),null);
	}else if(empty($capacity)){
		echo Response::show(311,"球场容纳人数为空!",array(),null);
	}else if(empty($desc)){
		echo Response::show(312,"描述为空!",array(),null);
	}else if(empty($addr)){
		echo Response::show(313,"球场地址为空!",array(),null);
	}else{
		$connect = Db::getInstance()->connect();

		$editSql = "update `zqq_pitchs_info` set capacity = ".$capacity.",pitchDesc = '".$desc."',pitchAddr = '".$addr."'";
		if(!empty($code)){
  			$editSql .= ",pitchCode = '".$code."'";
		}
		$editSql .= " where id = ".$ptcId;
		if(mysql_query($editSql, $connect)){
			echo Response::show(200,"球场信息修改成功！",mysql_fetch_assoc(mysql_query("select * from `zqq_pitchs_info` where id = '".$ptcId."'", $connect)),null);
		}else{
			echo Response::show(209,"球场信息编辑失败!",null,null);
		}
	}