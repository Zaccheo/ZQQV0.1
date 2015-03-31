<?php
	/*
	*获取注册的用户列表
	*@author yangzhiqian
	*@date 2015-03-24
	*@version v0.1 
	*@copy  四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$page = isset($_POST["page"]) ? $_POST["page"] : 0;//分页

	$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : null;

	$connect = Db::getInstance()->connect();
	$usersql = "select * from `zqq_users_info` ";
	$userCntSql = "select count(*) as ucount from `zqq_users_info` ";
	if(!empty($keyword)){
		$usersql .= "where phoneNumber = '".$keyword."' or nickName like '%".$keyword."%'";
		$userCntSql .= "where phoneNumber = '".$keyword."' or nickName like '%".$keyword."%'";
	}
	$usersql .= " order by regTime desc limit ".$page.",10";//分页显示
	$results = mysql_query($usersql, $connect);
	$result = array();
	if($results){
		while ($row = mysql_fetch_assoc($results)){
			$result['userData'][] = $row;
		}
	}
	$ucount = mysql_query($userCntSql);
	$ucnts = mysql_fetch_array($ucount);
	$result['userCount'] = $ucnts['ucount'];
	echo Response::show(200,"数据获取成功！",$result,null);
?>