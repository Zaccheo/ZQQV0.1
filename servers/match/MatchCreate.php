<?php
	/**
	*创建球赛活动
	*/
	
	require_once('../Response.php');
	require_once('../DB.php');
	
	$openId = $_POST["openId"];//创建人的openid
	$matchName =$_POST["matchName"];//比赛名称
	$selectPitch =$_POST["selectPitch"];//所选球场名称
	$selectPitchId = $_POST["selectPitchId"];//所选球场id
	$scaleByHand =$_POST["scaleByHand"];//手动填写的比赛规模
	$ifReval =$_POST["ifReval"];//是否约对手
	$mymatenum =$_POST["mymatenum"];//队友人数
	$creatorTel = $_POST["creatorTel"];//创建人电话
	$myforces =$_POST["myforces"];//自评战力
	
	//是否约对手
	if($ifReval){

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
	$creat = "insert into `zqq_activities` (activityCreatorOpenId,phoneNumber,activityName,activityCreateTime,pitchOrderInfoID,activityWantedTime,oppWanted,activityStatus) values ";
	$creat .= "('".$openId."','".$creatorTel."','".$matchName."','".date('Y-m-d H:i:s')."','".$selectPitchId."','".$scaleByHand."',".$ifReval.",".$activityStatus.")";
	//创建比赛活动
	if(mysql_query($creat, $connect)){
		$matchId = mysql_insert_id();
		$creatMember = "insert into `zqq_activity_members` (activitymemberOpenId,host_or_guest,delegateNumber,personalLevel,id_activities) values";
		$creatMember .= "('".$openId."',1,".$mymatenum.",".$myforces.",".$matchId.")";

		mysql_query($creatMember,$connect);
		mysql_query("update `zqq_pitchs_order_info` set orderStatus=1 where id=".$selectPitchId,$connect);
		echo Response::show(200,"活动创建成功！",array(),null);
	}else{
		echo Response::show(203,"活动创建失败！",array(),null);
	}
?>