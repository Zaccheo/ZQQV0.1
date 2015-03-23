<?php
namespace LaneWeChat\Servers\Users;
use LaneWeChat\Servers\Dbutils\Response;
use LaneWeChat\Servers\Dbutils\Db;
/**
 *describe 用户注册
 *author 杨志乾
 *corporate 誉合誉科技有限公司
 *version 1.0
 *date 2014-12-28
 *此接口传入参数：用户openId
 */
class UserRegister {
	public static function unsubscribe($openId) {
		if (empty($openId)) {
			return 300;
			//,请使用微信客户端打开该页面!;
		} else {
			$connect = Db::getInstance() -> connect();
			$newUserSql = "update `zqq_users_info` set flag=2 where useropenid= '" . $openId . "'";
			if (mysql_query($newUserSql, $connect)) {
				return 200;
			} else {
				return 301;
			}
		}

	}

	public static function register($openId, $nickName, $headerImgUrl) {
		//日期格式化
		date_default_timezone_set('PRC');

		if (empty($openId)) {
			return 300;
			//,请使用微信客户端打开该页面!;
		} else {
			$connect = Db::getInstance() -> connect();
			//检查openid是否存在，不存在注册
			$result = mysql_fetch_assoc(mysql_query("select id from `zqq_users_info` where useropenid = '" . $openId . "'", $connect));
			$newUserSql = null;
			if (!$result) {
				$newUserSql = "insert into zqq_users_info(useropenid,regTime,nickName,headerImgUrl) values ";
				$newUserSql .= " ('" . $openId . "','" . date('Y-m-d H:i:s') . "','" . $nickName . "','" . $headerImgUrl . "')";
			} else {
				$newUserSql = "update `zqq_users_info` set flag=1 where useropenid= '" . $openId . "'";
			}
			if (mysql_query($newUserSql, $connect)) {
				return 200;
				//,"注册成功!",array(),null);
			} else {
				return 301;
			}
		}
	}

}
