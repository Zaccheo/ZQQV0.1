<<<<<<< Updated upstream
<?php
	
	/**
	*球赛活动信息
	*/
	
	require_once('../Response.php');
	require_once('../DB.php');
	require_once('../Util.php');

	$matchId = $_POST['matchId'];
	$openId = $_POST['openId'];//当前登录人的openId，查询当前登录人的手机号码

	$connect = Db::getInstance()->connect();
	$sql = "select a.*,b.*,c.zDate,c.startTime,c.endTime from `zqq_activities` a,`zqq_users_info` b,`zqq_pitchs_order_info` c where a.activityCreatorOpenId = b.userOpenId and a.pitchOrderInfoID = c.id and a.id_activities = ".$matchId;//查询活动
	//查询球赛活动信息
	$result = mysql_fetch_assoc(mysql_query($sql, $connect));
	if($result){
		//查询活动队员数据
		$memeberSql = "select a.host_or_guest,a.delegateNumber,a.personalLevel,b.nickName,b.headerImgUrl,b.creditLevel from `zqq_activity_members` a,`zqq_users_info` b where a.activitymemberOpenId = b.userOpenId and a.id_activities = ".$matchId;//查询活动的成员信息
		$memeberRst = mysql_query($memeberSql,$connect);
		$memeberArr = array();
		$matesArr = array();
		if($memeberRst){
			while ($memberRow = mysql_fetch_assoc($memeberRst)) {
				$memeberArr[] = $memberRow;
				//处理带队友情况,重复添加队友数据
				$matesNum = (int)$memberRow['delegateNumber'];
				if($matesNum > 0){
					for($i=0;$i<$matesNum;$i++){
						$newMate = array(
							"delegateNumber"=> "0",
							"headerImgUrl"=>"../../imgs/teamAvatar.jpg",
							"host_or_guest"=> $memberRow['host_or_guest'],
							"nickName"=>$memberRow['nickName']."的队友",
							"creditLevel" => "",
							"personalLevel"=>"0");
						$matesArr[] = $newMate;
						array_push($memeberArr, $newMate);
					}	
				}
			}
		}
		
		$result['member'] = $memeberArr;//活动的成员信息

		//意见信息列表查询
		$commentsSql = "select a.*,b.nickName,b.headerImgUrl from `zqq_msg_board` a,`zqq_users_info` b where a.msgUserOpenId = b.userOpenId and id_activity = ".$matchId;//根据活动id查询评论
		$commentsRst = mysql_query($commentsSql,$connect);
		$commentsArr = array();
		if($commentsRst){
			while ($commentsRow = mysql_fetch_assoc($commentsRst)) {
				$commentsArr[] = $commentsRow;
			}
		}
		$result['comments'] = $commentsArr;//活动的意见信息

		//当前登录人的电话号码
		$telSerch = "select phoneNumber from `zqq_users_info` where userOpenId='".$openId."'";
		$telNum = mysql_fetch_array(mysql_query($telSerch,$connect));
		$result['curTelNum'] = $telNum['phoneNumber'];
	}
	echo Response::show(200,"获取成功!",$result,null);
=======
<?php
	
	/**
	*球赛活动信息
	*/
	
	require_once('../Response.php');
	require_once('../DB.php');
	require_once('../Util.php');

	$matchId = $_POST['matchId'];
	$openId = $_POST['openId'];//当前登录人的openId，查询当前登录人的手机号码

	$connect = Db::getInstance()->connect();
	$sql = "select a.*,b.*,c.zDate,c.startTime,c.endTime from `zqq_activities` a,`zqq_users_info` b,`zqq_pitchs_order_info` c where a.activityCreatorOpenId = b.userOpenId and a.pitchOrderInfoID = c.id and a.id_activities = ".$matchId;//查询活动
	//查询球赛活动信息
	$result = mysql_fetch_assoc(mysql_query($sql, $connect));
	if($result){
		//查询活动队员数据
		$memeberSql = "select a.host_or_guest,a.delegateNumber,a.personalLevel,b.nickName,b.headerImgUrl,b.creditLevel from `zqq_activity_members` a,`zqq_users_info` b where a.activitymemberOpenId = b.userOpenId and a.id_activities = ".$matchId;//查询活动的成员信息
		$memeberRst = mysql_query($memeberSql,$connect);
		$memeberArr = array();
		$matesArr = array();
		if($memeberRst){
			while ($memberRow = mysql_fetch_assoc($memeberRst)) {
				$memeberArr[] = $memberRow;
				//处理带队友情况,重复添加队友数据
				$matesNum = (int)$memberRow['delegateNumber'];
				if($matesNum > 0){
					for($i=0;$i<$matesNum;$i++){
						$newMate = array(
							"delegateNumber"=> "0",
							"headerImgUrl"=>"../../imgs/teamAvatar.jpg",
							"host_or_guest"=> $memberRow['host_or_guest'],
							"nickName"=>$memberRow['nickName']."的队友",
							"creditLevel" => "",
							"personalLevel"=>"0");
						$matesArr[] = $newMate;
						array_push($memeberArr, $newMate);
					}	
				}
			}
		}
		
		$result['member'] = $memeberArr;//活动的成员信息

		//意见信息列表查询
		$commentsSql = "select a.*,b.nickName,b.headerImgUrl from `zqq_msg_board` a,`zqq_users_info` b where a.msgUserOpenId = b.userOpenId and id_activity = ".$matchId;//根据活动id查询评论
		$commentsRst = mysql_query($commentsSql,$connect);
		$commentsArr = array();
		if($commentsRst){
			while ($commentsRow = mysql_fetch_assoc($commentsRst)) {
				$commentsArr[] = $commentsRow;
			}
		}
		$result['comments'] = $commentsArr;//活动的意见信息

		//当前登录人的电话号码
		$telSerch = "select phoneNumber from `zqq_users_info` where userOpenId='".$openId."'";
		$telNum = mysql_fetch_array(mysql_query($telSerch,$connect));
		$result['curTelNum'] = $telNum['phoneNumber'];
	}
	echo Response::show(200,"获取成功!",$result,null);
>>>>>>> Stashed changes
?>