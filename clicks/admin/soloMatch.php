<!DOCTYPE html>
<html lang="zh-cn">    
    <head>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta charset="utf-8">
    <title>足球圈-单飞匹配</title>
    <link rel="stylesheet" href="../../css/common.css">
    <link rel="stylesheet" href="../../css/index.css">
</head>
<body>
<div class="wrapbox">
<!-- heard -->
<header class="header">
   <h2>单飞匹配</h2>
</header>
<!-- / -->

<!-- main -->
<div>
    <div class="initiater-box">
        <div class="gridbox">
            <div class="headpic">
            <img width="50" height="50" id="creatorImg" src="../../imgs/teamAvatar.jpg" alt="">
            </div>
            <div id="soloInfo" class="grid-1">
                
                
            </div>
        </div>
    </div>
    <div class="placeBlock-40 bg-gray">
         <h2 class="h2-title" style="float:left;">单飞报名</h2>
    </div>
   
    <div class="detail-box">
        <div class="tab-con">
            <ul id="fansListUl" class="fans-list-ul">
                
            </ul>
        </div>
    </div>

    <div id="soloInfoDiv" class="on">
        <ul id="soloList" class="orders-list myzc-ul">                
        <!--单飞席-->
        </ul>
    </div>
    <!--页面底部菜单按钮-->
    <?php include "../bottom.php";?>
    <!--页面底部版权信息-->
    <?php include "../footer.php"; ?>
</div>
</div>

    <!-- end main -->
<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/proTools.js"></script>
<script type="text/javascript" src="../../js/danpin.js"></script>
<script type="text/javascript" src="../../js/fastclick.js"></script>
<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : null;?>
<?php $soloid = isset($_GET['soloid']) ? $_GET['soloid'] : null;?>
<script>
    $(function(){
        new FastClick(document.body);
        //回到顶部
        goToTop($("#goTop"));

        $.post("../../servers/solo/soloDetail.php",{
             "soloid":<?php echo $soloid;?>
            },function(data){
                if(data && data.code == 200){
                    var soloDetail = data.data.soloDetail;
                    //加载创建人头像
                    $("#creatorImg").attr("src",soloDetail.headerImgUrl);
                    var soloInfo = '<h4>'+soloDetail.soloDate+'('+getWeek(soloDetail.soloDate)+')</h4><p>创建人：'+soloDetail.nickName+'</p>'
                    +'<p><span class="mr20">需求：'+soloDetail.numberWanted+'人</span>'
                    +'<span>已安排：人</span></p>';
                    $("#soloInfo").html(soloInfo);
                    if(data.data.soloMember){
                        var soloMemberHtml = '';
                        $.each(data.data.soloMember,function(index,item){
                            soloMemberHtml += '<li id="li_'+index+'" class="bottom-border gridbox">'
                                        +'<div class="orders-pic">'
                                        +'<img class="pitchsavatar" src="'+item.headerImgUrl+'" alt="">'
                                        +'</div>'
                                        +'<div class="grid-1">'
                                        +'<h2 class="h2-title">'+item.nickName+'<a href="javascript:;" onclick="matchTeam(\''+item.userOpenId+'\')" style="display:block;float:right;margin-right:10px">分配队伍</a>'
                                        +'</h2>'
                                        +'<h3 class="h3-title">电话：<a href="tel:">'+(item.phoneNumber?item.phoneNumber:"")+'</a></h3>'
                                        +'<p>战力：'+buildStar(item.personalLevel)+'&nbsp;&nbsp;信用评级：'+buildStar(item.creditLevel)+'</p>'
                                    +'</div>'
                                +'</li>';
                        });
                        $("#fansListUl").html(soloMemberHtml);
                    }
                }
        },"json");
    });

    function buildStar(forces) {
        var starHtml = "";
        for (var i = 0; i < Math.round(forces); i++) {
            starHtml += "<i style='color:red;'>★</i>";
        }
        return starHtml;
    }
</script>
</body>
</html>