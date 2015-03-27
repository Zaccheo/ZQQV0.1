/*
*检测是否在微信端打开页面，防止用户看页面
*by yangzhiqian
*date 2015-03-27
*/
var ua = navigator.userAgent.toLowerCase();
var isWeixin = ua.indexOf('micromessenger') != -1;
var isAndroid = ua.indexOf('android') != -1;
var isIos = (ua.indexOf('iphone') != -1) || (ua.indexOf('ipad') != -1);
// function onReady(){
//     if(isAndroid) {
//         if (history.length && history.length > 1) 
//             history.back();
//         } else {
//             WeixinJSBridge.invoke('closeWindow');
//         }
//     }
// }
// document.addEventListener?document.addEventListener("WeixinJSBridgeReady",onReady,!1):document.attachEvent&&document.attachEvent("onWeixinJSBridgeReady",onReady);
if (!isWeixin) {
    window.location = "../error.php";
}