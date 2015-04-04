<?php
namespace LaneWeChat\oauthRedirect;
use LaneWeChat\servers\users\UserRegister;
use LaneWeChat\Core\WeChatOAuth;
use LaneWeChat\Core\UserManage;
include_once  '../lanewechat.php';

/*
*
*动态处理路径，检测当前访问用户是否是注册用户，进行相应的操作
*by 杨志乾
*
*/

$code = isset($_GET['code'])?$_GET['code']:null;
$dispatchUrl = isset($_GET['dispatch'])?$_GET['dispatch']:null;//动态跳转路径 by 杨志乾
// echo "user info 1 = ".$userInfo1."\n\t";
// echo "Code = ".$code."\n\t";
if (empty($code)) {
    //第一步，获取CODE
    WeChatOAuth::getCode('http://www.xishuma.com/fb55/lanewechat/oauth/oauthRedirect.php?dispatch='.$dispatchUrl, 1,'snsapi_base');
}else{
    //第二步，获取access_token网页版
    $response = WeChatOAuth::getAccessTokenAndOpenId($code);
    //第三步，获取用户信息
    $userInfo = UserManage::getUserInfoByOauth2($openId['access_token'],$openId['openid']);
    print_r($user);
    if($user['subscribe'] == 0){
        //用户没有关注，跳转到关注页面去
        //第一步，获取CODE
        UserRegister::register($user['openid'],$user['nickname'],$user['headimgurl']);
        
    }
    //跳转到相应页面
    $redirectUrl = urldecode($dispatchUrl)."&openId=".$response['openid'];
    header('Location: '.$redirectUrl);
    exit;
}
?>