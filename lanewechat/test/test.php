<?php
namespace LaneWeChat\test;
use LaneWeChat\core\userManage;
use LaneWeChat\servers\users\UserRegister;
include '../lanewechat.php';

//获取用户的微信信息，并添加到用户信息数据库表中.
//$user = UserManage::getUserInfo("o5896s7PEwwnqM67-aeRKrdLLdFk");
//echo $user['openid'];
//echo $user['nickname'];
//echo $user['headimgurl'];
 //echo UserRegister::unsubscribe($user['openid']);
//==============================================================================================
//将已有粉丝信息导入[用户信息表]
/*
$list = UserManage::getFansList();
foreach ($list['data']['openid'] as $openid)
{
    $user = UserManage::getUserInfo($openid);
    UserRegister::register($user['openid'],$user['nickname'],$user['headimgurl']);
    echo $openid."<br/>";
}
*/
//==============================================================================================
// $openid = "";

// $user = UserManage::getUserInfo($openid);
// UserRegister::register($user['openid'],$user['nickname'],$user['headimgurl']);

?>