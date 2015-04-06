<?php
namespace LaneWeChat;
use LaneWeChat\Servers\Dbutils\Response;
use LaneWeChat\Servers\Dbutils\Db;
use LaneWeChat\Core\Curl;
use LaneWeChat\Core\ResponseInitiative;
include_once  '/lanewechat.php';
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
$contents = $_POST['content'];

if(empty($openId)){
	exit;
}else{
	//echo $openId.$event;
	//判断消息推送类型
	switch ($event) {
	 	case 'comment':
	 		$content_str = "有人在足球圈回复了你，";
	 		$content_str .= "消息内容：".$contents;
	 		return ResponseInitiative::text($openId, $contents);
	 		break;
	 	case 'record':
	 		$content_json=json_decode($contents); //将字符转成JSON
	 		$arr = array();
	 		foreach ($content_json as $key => $value) {
	 			$arr[0][$key] = $value;
	 		}
			//$news = ResponseInitiative::newsItem($content_json->title,$content_json->description,$content_json->url,$content_json->picurl);
            //echo $arr;
            //var_dump($news);
           	return ResponseInitiative::news($openId,$arr);
	 		break;
	 	default:
	 	
	 		break;

	}
}
?>