<?php
	/**
	 *describe 查询球场规模
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-30
	 *此接口传入参数：无
	 */

	require_once('./Response.php');
	require_once('./DB.php');



	$scaleSql = "select * from `zqq_pitchs_info` GROUP BY capacity";


	$connect = Db::getInstance()->connect();

    $result = mysql_query($scaleSql, $connect);
   	$results = array();
   	while ($row = mysql_fetch_assoc($result)) {
   		//组装查询到的列
		$results[] = $row;
  	}

  	if(empty($results)){
		echo Response::show(201,"没有查到球场信息！",$results,null);
  	}else{
  		echo Response::show(200,"获取成功！",$results,null);
  	}


