
<?php
	/**
	*创建球赛活动
	*/
	
	require_once('../Response.php');
	require_once('../DB.php');
	require_once('../Util.php');
	
	$openId = $_POST["openId"];//创建人的openid
	$matchName =$_POST["matchName"];//比赛名称
	$selectPitch =$_POST["selectPitch"];//所选球场名称
	$selectPitchId = $_POST["selectPitchId"];//所选球场id
	$scaleByHand =$_POST["scaleByHand"];//手动填写的比赛规模
	$ifReval =$_POST["ifReval"];//是否约对手
	$ifNeedSolo =$_POST["ifNeedSolo"];//是否约单飞
	$mymatenum =$_POST["mymatenum"];//队友人数
	$creatorTel = $_POST["creatorTel"];//创建人电话
	$myforces =$_POST["myforces"];//自评战力
	
	//是否约对手
	if($ifReval){

	}
	if($ifNeedSolo){
		
	}
	//根据是否选择了球场判断活动是否应该创建还是计划中
	$activityStatus = 0;
	if($selectPitchId == null || $selectPitchId == ""){
		$activityStatus = 0;//球赛计划
	}else{
		$activityStatus = 1;//球赛创建
	}

	date_default_timezone_set('PRC');
	$connect = Db::getInstance()->connect();
	$creat = "insert into `zqq_activities` (activityCreatorOpenId,phoneNumber,activityName,activityCreateTime,pitchOrderInfoID,activityWantedTime,oppWanted,soloWanted,activityStatus,activityLevel) values ";
	$creat .= "('".$openId."','".$creatorTel."','".$matchName."','".date('Y-m-d H:i:s')."','".$selectPitchId."','".$scaleByHand."',".$ifReval.",".$ifNeedSolo.",".$activityStatus.",".$myforces.")";
	//创建比赛活动
	$rep = array();
	if(mysql_query($creat, $connect)){
		$matchId = mysql_insert_id();
		$creatMember = "insert into `zqq_activity_members` (activitymemberOpenId,host_or_guest,delegateNumber,id_activities) values";
		$creatMember .= "('".$openId."',1,".$mymatenum.",".$matchId.")";

		mysql_query($creatMember,$connect);
		mysql_query("update `zqq_pitchs_order_info` set orderStatus=1 where id=".$selectPitchId,$connect);
		$rep['matchId'] = $matchId;

		//活动创建成功之后，通知用户创建的活动具体信息
		$crtActs = mysql_fetch_assoc(mysql_query("select * from `zqq_activities` where id_activities = ".$matchId,$connect));
		//默认期望时间比赛
		$descrStr = $crtActs['activityWantedTime'];
		if($crtActs){
			if($crtActs['pitchOrderInfoID'] > 0  && empty($crtActs['activityWantedTime'])){
				$crtPitshInfo = mysql_fetch_assoc(mysql_query("select a.zDate,a.startTime,a.endTime,a.charge,a.credits,b.capacity,b.pitchCode,b.pitchDesc,b.pitchAddr from `zqq_pitchs_order_info` a,`zqq_pitchs_info` b where a.pitchInfoID  = b.id and a.id = ".$crtActs['pitchOrderInfoID']));
				$descrStr = $crtPitshInfo['pitchAddr'].$crtPitshInfo['pitchDesc']."，".$crtPitshInfo['pitchCode']."          ●参赛时间：".$crtPitshInfo['zDate']."  ".$crtPitshInfo['startTime']."-".$crtPitshInfo['endTime'];
			}
		}
		$star = Util::buildForceStar(intval($crtActs["activityLevel"]));
		$template = array(
        	'title'=>'【'.$crtActs['activityName'].'】比赛创建成功！',
            'description'=>"您留的电话：".$creatorTel."请确认!              ●参赛信息：".$descrStr."        ●竞技强度：".$star,
            'url'=>'http://www.xishuma.com/fb55/clicks/match/matchDetail.php?matchId='.$matchId.'&openId='.$openId,
            'picurl'=>'http://www.xishuma.com/fb55/imgs/qiuchang2.jpg',
        );
        Util::SendPushMsg($openId,'record',$template);
		echo Response::show(200,"活动创建成功！",$rep,null);
	}else{
		echo Response::show(203,"活动创建失败！",array(),null);
	}
?>