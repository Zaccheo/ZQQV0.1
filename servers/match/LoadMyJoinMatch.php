<?php

	/**
	*加载我参与的比赛
	*@author yangzhiqian
	*@version 1.0
	*@copyright 四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$openId = $_POST['openId'];

	$connect = Db::getInstance()->connect();
	// $sql = "select a.id_activities,b.activityName,b.activityCreatorOpenId,b.activityStatus,b.pitchOrderInfoID,c.headerImgUrl,c.nickName,d.zDate,d.startTime,d.endTime,e.pitchCode,e.capacity,e.pitchAddr";
	// $sql .=" from `zqq_activity_members` a,`zqq_activities` b,`zqq_users_info` c,`zqq_pitchs_order_info` d,`zqq_pitchs_info` e";
	// $sql .=" where a.id_activities = b.id_activities and b.activityCreatorOpenId = c.userOpenId and b.pitchOrderInfoID = d.id and d.pitchInfoID = e.id and a.activitymemberOpenId = '".$openId."'";//查询活动


	//根据memberid查询用户所在的活动
	$sql = " select a.id_activities,b.activityName,b.activityCreatorOpenId,b.activityStatus,b.pitchOrderInfoID,b.activityWantedTime,c.headerImgUrl,c.nickName ";
	$sql .=" from `zqq_activity_members` a,`zqq_activities` b,`zqq_users_info` c ";
	$sql .=" where a.id_activities = b.id_activities and b.activityCreatorOpenId = c.userOpenId and a.activitymemberOpenId = '".$openId."' order by b.activityCreateTime desc";
	//查询球赛活动信息
	$result = mysql_query($sql, $connect);
	$rep = array();
	if($result){
		while ($row = mysql_fetch_assoc($result)) {
			if($row['pitchOrderInfoID'] > 0){
				//没有选择对应的球场信息，而是手动填写的时间
				$queryPitchsql = " select d.zDate,d.startTime,d.endTime,e.pitchCode,e.capacity,e.pitchAddr ";
				$queryPitchsql .= " from `zqq_activities` b,`zqq_pitchs_order_info` d,`zqq_pitchs_info` e";
				$queryPitchsql .= " where b.pitchOrderInfoID = d.id and d.pitchInfoID = e.id and b.id_activities = ".$row['id_activities'];
				$pitchRst = mysql_fetch_assoc(mysql_query($queryPitchsql));
				//var_dump(mysql_fetch_assoc($pitchRst));
				//array_push($row, $pitchRst);
				if(!empty($pitchRst)){
					$row = array_merge_recursive($row, $pitchRst);
				}
				//$row['pitchs'] = ($pitchRst);
			}
			$acid = $row['id_activities'];
			$memSql = "select delegateNumber from `zqq_activity_members` where id_activities = ".$acid;
			//查询球赛活动信息
			$memRst = mysql_query($memSql, $connect);
			if($memRst){
				$memCunt = 0;
				while($memRstRow = mysql_fetch_assoc($memRst)){
					$memCunt += $memRstRow['delegateNumber'] + 1;
				}
				$row['memCunt'] = $memCunt;
			}
			$rep[] = $row;
		}
	}
	echo Response::show(200,"获取成功！",$rep,null);

?>