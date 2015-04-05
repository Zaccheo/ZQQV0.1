<?php
	/**
	*公开比赛活动信息列表
	*
	*/
	
	require_once('../Response.php');
	require_once('../DB.php');

	$id_activities = $_POST['id_activities'];//球赛活动信息ID
	$winner = $_POST['winner'];//胜利方队伍,1=主队，2=客队，3=平局
	$activityCharge = $_POST['activityCharge'];//结算金额
	$credits = $_POST['credits'];//积分数目
	$capacity = $_POST['capacity'];//规模,5人制，7人制
	
	$connect = Db::getInstance()->connect();
	
	
	if (empty($id_activities)||empty($winner)||empty($activityCharge)||empty($credits)||empty($capacity)){
	    echo Response::show(300,"输入参数错误!",array(),null);
	}else{
    	//IN id_activities_in int,IN winner_in tinyint,IN activityCharge_in float,IN credits_in int,IN capacity_in int
    	$sql = "call matchsettle_proc(".$id_activities.",".$winner.",".$activityCharge.",".$credits.",".$capacity.")";
    	//$sql = "call matchsettle_proc(44,3,500,50,null)";
    	
    	$result = mysql_fetch_assoc(mysql_query($sql, $connect));
    	
     	if($result['t_error']==0){
     	    echo Response::show(200,"结算成功！",array(),null);
     	}else if($result['t_error']==2){
     	    echo Response::show(300,"输入参数错误!",array(),null);
     	}else{
     	    echo Response::show(301,"结算失败!",array(),null);
     	}
	}
?>