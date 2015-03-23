<?php
	/**
	 *describe 球场预约信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *此接口传入参数：球场信息ID，起始日期，结束日期，球场容量
	 */

	require_once('./Response.php');
	require_once('./DB.php');

	$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;//查询起始日期
	$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;//查询起始日期
	$capacity = isset($_GET['capacity']) ? $_GET['capacity'] : null;//球场信息ID

	if(empty($startDate)){
	    echo Response::show(300,"起始日期参数不能为NULL!",array(),null);
	}if(empty($endDate)){
	    echo Response::show(300,"结束日期参数不能为NULL!",array(),null);
	}else if(empty($capacity)){
	    echo Response::show(301,"请选择球场场次信息!",array(),null);
	}
	
	//日期格式化
	date_default_timezone_set('PRC');

	$connect = Db::getInstance()->connect();

	$querySql = "select uu.username,uu.phoneNumber,uu.sex,uu.id as userId,a.*,zpi.capacity,zpi.pitchCode
        from (`zqq_pitchs_order_info` a inner join `zqq_pitchs_info` zpi on zpi.id = a.pitchInfoID) 
	    left join (select u.*,uo.id as orderID from `zqq_users_orders_info` uo 
	               inner join `zqq_users_info` u on uo.userInfoID=u.id) uu
        on a.orderID = uu.orderID
        where a.zDate between '".$startDate."' and '".$endDate."' "
        ." and a.pitchInfoID in( select id from `zqq_pitchs_info` where capacity=".$capacity.")";
	
	$result = mysql_query($querySql." order by a.zDate", $connect);
   	$results = array();
   	while ($row = mysql_fetch_assoc($result)) {
   		//组装查询到的列
		$results[] = $row;
  	}
 	echo Response::show(200,"获取成功",$results,null);

	