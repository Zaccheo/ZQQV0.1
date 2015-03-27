<?php
namespace LaneWeChat\test;
use LaneWeChat\servers\users\UserRegister;
use LaneWeChat\Core\WeChatOAuth;
use LaneWeChat\Core\UserManage;
include_once  '../lanewechat.php';

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
// 获取用户所在的分组信息
/*
$group = UserManage::isUserAdministrator("o5896s7PEwwnqM67-aeRKrdLLdFk");


if($group){
    echo "admin";
}else{
    echo "user";
}
*/
// $userInfo1 = $_GET['SID'];
$code = $_GET['code'];
// echo "user info 1 = ".$userInfo1."\n\t";
// echo "Code = ".$code."\n\t";
if (empty($code)) {
    //第一步，获取CODE
    WeChatOAuth::getCode('http://www.xishuma.com/fb55/lanewechat/test/test.php?SID=1', 1, 'snsapi_userinfo');
    //此时页面跳转到了http://www.lanecn.com/index.php，code和state在GET参数中。
}else{
    //第二步，获取access_token网页版
    $openId = WeChatOAuth::getAccessTokenAndOpenId($code);
    print_r($openId);
    //第三步，获取用户信息
    $userInfo = UserManage::getUserInfoByOauth2($openId['access_token'],$openId['openid']);
    
    print_r($userInfo);
    
}


?>