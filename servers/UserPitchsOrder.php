<?php
	/**
	 *describe 球场预约信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：球场信息ID，日期，球场容量
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$queryDate = isset($_GET['qdate']) ? $_GET['qdate'] : null;//查询日期
	$queryId = isset($_GET['pcid']) ? $_GET['pcid'] : null;//球场信息ID

	if(empty($queryDate)){
	    echo Response::show(300,"日期参数不能为NULL!",array(),null);
	}else if(empty($queryId)){
	    echo Response::show(301,"请选择球场场次信息!",array(),null);
	}
	
	//日期格式化
	date_default_timezone_set('PRC');

	$connect = Db::getInstance()->connect();

	$querySql = "select uu.username,uu.phoneNumber,uu.sex,uu.id as userId,a.*
        from `zqq_pitchs_order_info` a 
	    left join (select u.*,uo.id as orderID from `zqq_users_orders_info` uo 
	               inner join `zqq_users_info` u on uo.userInfoID=u.id) uu
        on a.orderID = uu.orderID
        where a.zDate = '".$queryDate."' 
        and a.pitchInfoID = ".$queryId;
	
	$result = mysql_query($querySql." order by a.startTime", $connect);
   	$results = array();
   	while ($row = mysql_fetch_assoc($result)) {
   		//组装查询到的列
		$results[] = $row;
  	}
 	echo Response::show(200,"获取成功",$results,null);

	