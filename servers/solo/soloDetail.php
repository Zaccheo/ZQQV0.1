<?php
	/**
	*用户获取对应单飞席信息
	*@author yangzhiqian
	*@version 1.0
	*@copyright 四川誉合誉科技有限公司
	*/

	require_once('../Response.php');
	require_once('../DB.php');


	$soloid = $_POST['soloid'];
	//查询类型，若存在，并且为1，则是需要加载评论信息
	$type = isset($_POST['type']) ? $_POST['type'] : null;

	$connect = Db::getInstance()->connect();
	$sql = "select a.*,b.nickName,b.headerImgUrl from `zqq_solo_list` a,`zqq_users_info` b ";
	$sql .= "where a.soloAdminOpenId = b.userOpenId and a.id_solo_list =".$soloid;//查询活动
	//查询球赛活动信息
	$result = mysql_query($sql, $connect);
	$results = array();
	if($result){
		$row = mysql_fetch_assoc($result);
		$results['soloDetail'] = $row;
		//查询单飞成员
		$memberSql = "select * from `zqq_solo_member` a,`zqq_users_info` b ";
		$memberSql .= "where a.soloMemberOpenId = b.userOpenId and a.id_solo_list=".$soloid;
		$memberRst = mysql_query($memberSql,$connect);
		if($memberRst){
			while ($memberRow = mysql_fetch_assoc($memberRst)) {
				$results['soloMember'][] = $memberRow;
			}
		}

		//加载评论信息
		if($type != null && $type == 1){
			$commentSql = "select a.*,b.nickName,b.headerImgUrl from `zqq_msg_board` a,`zqq_users_info` b where a.msgUserOpenId = b.userOpenId and a.id_solo_list=".$soloid;
			$commentRst = mysql_query($commentSql,$connect);
			if($commentRst){
				while ($commentRow = mysql_fetch_assoc($commentRst)) {
					$results['soloComment'][] = $commentRow;
				}
			}
		}
	}
	echo Response::show(200,"获取成功！",$results,null);
?>