<?php

	/**
	 *describe 添加球场信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$code = isset($_GET['code']) ? $_GET['code'] : null;//球场编号
	$capacity = isset($_GET['capa']) ? $_GET['capa'] : null;//容纳人数
	$desc = isset($_GET['desc']) ? $_GET['desc'] : null;//球场描述
	$addr = isset($_GET['addr']) ? $_GET['addr'] : null;//地址

	if(empty($code)){
		echo Response::show(310,"球场编号不能为空!",array(),null);
	}else if(empty($capacity)){
		echo Response::show(311,"球场容纳人数为空!",array(),null);
	}else if(empty($desc)){
		echo Response::show(312,"描述为空!",array(),null);
	}else if(empty($addr)){
		echo Response::show(313,"球场地址为空!",array(),null);
	}else{

		$connect = Db::getInstance()->connect();
		$aptch = "insert into `zqq_pitchs_info` (capacity,pitchCode,pitchDesc,pitchAddr) values ";
		$aptch .= "(".$capacity.",'".$code."','".$desc."','".$addr."')";

		if(mysql_query($aptch, $connect)){
			echo Response::show(200,"添加成功！",array(),null);
		}else{
			echo Response::show(203,"添加失败！",array(),null);
		}
	}