<?php
	/**
	*解散球赛
	*
	*/

	require_once('../Response.php');
	require_once('../DB.php');
	require_once('../Util.php');

	$actId = $_POST["actId"];
	$openId = $_POST["openId"];

	if(empty($openId)){
		echo Response::show(203,"操作失败，openI获取失败!",array(),null);
		exit();
	}
	$connect = Db::getInstance()->connect();
	//活动解散成功之后，通知用户创建的活动具体信息
	$crtActs = mysql_fetch_assoc(mysql_query("select * from `zqq_activities` where id_activities = ".$actId,$connect));

 	//删除活动释放球场
	$releaseSql = "update `zqq_pitchs_order_info` set orderStatus = 0 where id = (select pitchOrderInfoID from `zqq_activities` where id_activities = ".$actId.")";
	mysql_query($releaseSql,$connect);
	
	$deleActSql = "delete from `zqq_activities` where id_activities = ".$actId." and activityCreatorOpenId = '".$openId."'";
	//参加活动创建
	if(mysql_query($deleActSql, $connect)){
		//默认期望时间比赛
		$descrStr = $crtActs['activityWantedTime'];
		if($crtActs){
			if($crtActs['pitchOrderInfoID'] > 0  && empty($crtActs['activityWantedTime'])){
				$crtPitshInfo = mysql_fetch_assoc(mysql_query("select a.zDate,a.startTime,a.endTime,a.charge,a.credits,b.capacity,b.pitchCode,b.pitchDesc,b.pitchAddr from `zqq_pitchs_order_info` a,`zqq_pitchs_info` b where a.pitchInfoID  = b.id and a.id = ".$crtActs['pitchOrderInfoID']));
				$descrStr = $crtPitshInfo['pitchAddr'].$crtPitshInfo['pitchDesc']."，".$crtPitshInfo['pitchCode']."    ●参赛时间：".$crtPitshInfo['zDate']."  ".$crtPitshInfo['startTime']."-".$crtPitshInfo['endTime'];
			}
		}
		$star = Util::buildForceStar(intval($crtActs["activityLevel"]));
		$template = array(
	    	'title'=>'【'.$crtActs['activityName'].'】比赛已解散！谢谢您的参与，欢迎下次再来！',
	        'description'=>"●参赛信息：".$descrStr."   ●竞技强度：".$star,
	        'url'=>'http://www.xishuma.com/fb55/clicks/noMatch.php',
	        'picurl'=>'http://www.xishuma.com/fb55/imgs/qiuchang2.jpg',
	    );
		Util::SendPushMsg($openId,'record',$template);
		
		echo Response::show(200,"删除成功！",array(),null);
	}else{
		echo Response::show(203,"删除失败，系统忙，请稍后再试！",array(),null);
	}
?>