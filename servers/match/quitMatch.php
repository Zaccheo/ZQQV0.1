<?php
	/**
	*退出球赛
	*@author yangzhiqian
	*@version 1.0
	*@copyright 四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');
	require_once('../Util.php');

	$actmbeId = $_POST["actmbeId"];//member表中主键
	$type = $_POST["type"];//退出类型 1是本人退出，0是退出队友数量
	$openId = $_POST["openId"];//登录人的openId

	if(empty($openId)){
		echo Response::show(203,"操作失败，openI获取失败!",array(),null);
		exit();
	}
	$connect = Db::getInstance()->connect();

	$quitRst = array();
	$quitSql = "";
	if($type == 0){
		$quitSql = "update `zqq_activity_members` set delegateNumber = delegateNumber-1 where id_activity_member = ".$actmbeId;
	}else{
		//检测退出用户是否是最后一个
		$checkLastSql = "select count(*) as cntNum from `zqq_activity_members` where id_activities = (select id_activities from `zqq_activity_members` where id_activity_member = ".$actmbeId.")";
		$memberCntRst = mysql_fetch_assoc(mysql_query($checkLastSql,$connect));
		$cntNum = $memberCntRst['cntNum'];
		$quitRst['cntNum'] = $cntNum; 
		if($cntNum == 1){
			//最后一个用户，连同活动一起取消
			$quitSql = "delete from `zqq_activities` where id_activities =(select id_activities from `zqq_activity_members` where id_activity_member = ".$actmbeId.") and activityCreatorOpenId = '".$openId."'";
		}else{
			$quitSql = "delete from `zqq_activity_members` where id_activity_member = ".$actmbeId;
		}
	}
	//先查询出来，待使用
	$crtActs = mysql_fetch_assoc(mysql_query("select * from `zqq_activities` where id_activities =(select id_activities from `zqq_activity_members` where id_activity_member = ".$actmbeId.")",$connect));
	//退出活动
	if(mysql_query($quitSql, $connect)){
		if($type != 0){
			//活动解散成功之后，通知用户创建的活动具体信息
			$headerStr = "";
			$urlStr = "";
			if($quitRst['cntNum'] == 1){
				$headerStr = "比赛已解散！谢谢您的参与，欢迎下次再来！";
				$urlStr = 'http://www.xishuma.com/fb55/clicks/noMatch.php';
			}else{
				$headerStr = "您已成功退出该比赛！谢谢您的参与！";
				$urlStr = 'http://www.xishuma.com/fb55/clicks/match/matchDetail.php?matchId='.$crtActs['id_activities'].'&openId='.$openId;
			}
			//默认期望时间比赛
			$descrStr = $crtActs['activityWantedTime'];
			if($crtActs['pitchOrderInfoID'] > 0  && empty($crtActs['activityWantedTime'])){
				$crtPitshInfo = mysql_fetch_assoc(mysql_query("select a.zDate,a.startTime,a.endTime,a.charge,a.credits,b.capacity,b.pitchCode,b.pitchDesc,b.pitchAddr from `zqq_pitchs_order_info` a,`zqq_pitchs_info` b where a.pitchInfoID  = b.id and a.id = ".$crtActs['pitchOrderInfoID']));
				$descrStr = $crtPitshInfo['pitchAddr'].$crtPitshInfo['pitchDesc']."，".$crtPitshInfo['pitchCode']."    ●参赛时间：".$crtPitshInfo['zDate']."  ".$crtPitshInfo['startTime']."-".$crtPitshInfo['endTime'];
			}
			$star = Util::buildForceStar(intval($crtActs["activityLevel"]));
			$template = array(
		    	'title'=>'【'.$crtActs['activityName'].'】'.$headerStr,
		        'description'=>"●参赛信息：".$descrStr."   ●竞技强度：".$star,
		        'url'=>$urlStr,
		        'picurl'=>'http://www.xishuma.com/fb55/imgs/qiuchang2.jpg',
		    );
		    Util::SendPushMsg($openId,'record',$template);
		}
		echo Response::show(200,"退出成功！",$quitRst,null);
	}else{
		echo Response::show(203,"退出失败，系统忙，请稍后再试！",array(),null);
	}
?>