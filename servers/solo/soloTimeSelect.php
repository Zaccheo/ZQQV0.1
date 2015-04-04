<?php
	/**
	*单飞席时间选择数据接口
	*@author yangzhiqian
	*@version 1.0
	*@copyright 四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	date_default_timezone_set('PRC');
	$connect = Db::getInstance()->connect();
	$sql = "select soloDate from `zqq_solo_list`  where soloDate >= '".date('Y-m-d')."' group by soloDate";
	//查询当天以后的可用单飞席
	$result = mysql_query($sql, $connect);
	$results = array();
	if($result){
		while ($row = mysql_fetch_assoc($result)) {
			// $countSql = "select count(*) cntNum from `zqq_solo_member` where id_solo_list = ".$row['id_solo_list'];
			// $countRst = mysql_fetch_assoc(mysql_query($countSql,$connect));
			// $row['cntNum'] = $countRst['cntNum'];
			$results[] =$row;
		}
	}
	echo Response::show(200,"获取成功!",$results,null);

?>