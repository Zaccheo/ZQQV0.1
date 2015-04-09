<?php

	/**
	*加载我创建的比赛
	*@author yangzhiqian
	*@version 1.0
	*@copyright 四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');

	$openId = $_POST['openId'];

	$connect = Db::getInstance()->connect();
	$sql = "select a.id_activities,a.activityName,a.activityStatus,a.pitchOrderInfoID,a.activityWantedTime,b.headerImgUrl,b.nickName";
	$sql .=" from `zqq_activities` a,`zqq_users_info` b";
	$sql .=" where a.activityCreatorOpenId = b.userOpenId and a.activityCreatorOpenId = '".$openId."' order by a.activityCreateTime desc";//查询活动
	//查询球赛活动信息
	$result = mysql_query($sql, $connect);
	$rep = array();
	if($result){
		while ($row = mysql_fetch_assoc($result)) {
			$acid = $row['id_activities'];
			if($row['pitchOrderInfoID'] > 0){
				$sql2 = "select c.zDate,c.startTime,c.endTime,d.pitchCode,d.capacity,d.pitchAddr ";
				$sql2 .= " from `zqq_activities` a,`zqq_pitchs_order_info` c,`zqq_pitchs_info` d";
				$sql2 .= " where a.pitchOrderInfoID = c.id and c.pitchInfoID = d.id and a.id_activities = ".$acid;
				$pitchRst = mysql_fetch_assoc(mysql_query($sql2));
				if(!empty($pitchRst)){
					$row = array_merge_recursive($row, $pitchRst);
				}
			}
			$memSql = "select delegateNumber from `zqq_activity_members` where id_activities = ".$acid;
			//查询球赛活动信息
			//查询球赛活动信息
			$memRst = mysql_query($memSql, $connect);
			$memCunt = 0;
			if($memRst){
				while($memRstRow = mysql_fetch_assoc($memRst)){
					$memCunt += $memRstRow['delegateNumber']+1;
				}
			}
			$row['memCunt'] = $memCunt;
			$rep[] = $row;
		}
	}
	echo Response::show(200,"获取成功！",$rep,null);

?>