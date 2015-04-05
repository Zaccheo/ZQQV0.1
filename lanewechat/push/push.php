<?php
namespace LaneWeChat\Push;
use LaneWeChat\Servers\Dbutils\Response;
use LaneWeChat\Servers\Dbutils\Db;
use LaneWeChat\Core\Curl;
use LaneWeChat\Core\ResponseInitiative;
include_once  '../lanewechat.php';
/*
 *
 *
 *
 *消息推送，用于对48小时内访问过足球圈的用户推送对应消息
 *@author 杨志乾
 *@version 1.0
 *@copyright 四川誉合誉科技有限公司
 *
 *
 */
$openId = $_POST['openId'];
$event = $_POST['event'];
$content = $_POST['content'];

if(empty($openId)){
	exit;
}else{
	//echo $openId.$event;
	//判断消息推送类型
	switch ($event) {
	 	case 'comment':
	 		$content = "有人在足球圈回复了你，";
	 		$content .= "消息内容：".$content;
	 		ResponseInitiative::text($openId, $content);
	 		break;
	 	case 'record':
	 		$news = ResponseInitiative::newsItem("国家德比！", "客队：小李，小王，豇豆，来依法，可爱，咖啡","http://www.xishuma.com/fb55/clicks/match/matchDetail.php","http://www.xishuma.com/fb55/imgs/qiuchang1.jpg");
            ResponseInitiative::news($openId,$news);
	 		break;
	 	default:
	 	
	 		break;

	}
}
?>