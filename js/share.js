/*share*/
if (!dataForWeixin)
{
    var dataForWeixin = {
        title: '足球圈，让您感受足球的魅力', // 分享标题
        desc: '足球圈可以获得足球组队，活动举办，场地预约功能', // 分享描述
        link: 'http://www.xishuma.com/fb55/lanewechat/oauth/oauthRedirect.php?dispatch='+window.location.href,
        //link: 'http://www.xishuma.com/fb55/lanewechat/oauth/oauthRedirect.php?dispatch='+encodeURI(window.location.href), // 分享链接
        imgUrl: 'http://www.xishuma.com/fb55/imgs/55.jpg', // 分享图标
        type: '', // 分享类型，默认为链接
        dataUrl: '' // 如果type是music或video，则要提供数据链接，默认为空
    };
}

var hideMenus = [
    'menuItem:copyUrl', // 复制链接
    'menuItem:originPage', // 原网页
    'menuItem:openWithQQBrowser', //QQ浏览器打开
    'menuItem:openWithSafari',//safari浏览器打开
    'menuItem:share:email'//邮件打开
];

//微信配置
wx.config({
    debug: false,
    appId: wxconfig.appId,
    timestamp: wxconfig.timestamp,
    nonceStr: wxconfig.nonceStr,
    signature: wxconfig.signature,
    jsApiList: ['onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'hideMenuItems'] 
});

//调用接口方法
wx.ready(function () {
    //保护类按钮隐藏
    wx.hideMenuItems({
        menuList: hideMenus
    });

    //分享到朋友
    wx.onMenuShareAppMessage({
        title: dataForWeixin.title, // 分享标题
        desc: dataForWeixin.desc, // 分享描述
        link: 'http://www.xishuma.com/fb55/lanewechat/oauth/oauthRedirect.php?dispatch='+dataForWeixin.link, // 分享链接
        imgUrl: dataForWeixin.imgUrl, // 分享图标
        type: dataForWeixin.type, // 分享类型
        dataUrl: dataForWeixin.dataUrl, // 如果type是music或video，则要提供数据链接，默认为空
        success: function () { 
            // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });

    //分享到朋友圈
    wx.onMenuShareTimeline({
        title: dataForWeixin.title,// 分享标题
        desc: dataForWeixin.desc, // 分享描述
        link: 'http://www.xishuma.com/fb55/lanewechat/oauth/oauthRedirect.php?dispatch='+dataForWeixin.link, // 分享链接
        imgUrl: dataForWeixin.imgUrl, // 分享图标
        success: function () { 
            // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });

    //分享到QQ
    wx.onMenuShareQQ({
        title: dataForWeixin.title, // 分享标题
        desc: dataForWeixin.desc, // 分享描述
        link: 'http://www.xishuma.com/fb55/lanewechat/oauth/oauthRedirect.php?dispatch='+dataForWeixin.link, // 分享链接
        imgUrl: dataForWeixin.imgUrl, // 分享图标
        success: function () { 
           // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
           // 用户取消分享后执行的回调函数
        }
    });

    //分享到腾讯weibo
    wx.onMenuShareWeibo({
        title: dataForWeixin.title, // 分享标题
        desc: dataForWeixin.desc, // 分享描述
        link: 'http://www.xishuma.com/fb55/lanewechat/oauth/oauthRedirect.php?dispatch='+dataForWeixin.link, // 分享链接
        imgUrl: dataForWeixin.imgUrl, // 分享图标
        success: function () { 
           // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });


   
});