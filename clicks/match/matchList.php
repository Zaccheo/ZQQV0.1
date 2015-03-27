<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>加入球赛</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="../../css/common.css" />
		<link rel="stylesheet" href="../../css/index.css" />
		<style type="text/css">
			input:-webkit-autofill,
			input:-webkit-autofill:hover,
			input:-webkit-autofill:focus {
			    box-shadow:0 0 0 60px #fff inset;
			    -webkit-text-fill-color: #333;
			}
		</style>
		<script src="../../js/wxcheck.js" type="text/javascript"></script>
		<script src="../../js/zepto.min.js" type="text/javascript"></script>
		<script src="../../js/zepto.picLazyLoad.min.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<script src="../../js/home.js" type="text/javascript"></script>
	</head>
	<body>
		<header class="header">
			<h2><span>开放球赛列表</span></h2>
		</header>
		<div class="eromsg-box">
			<div class="eromsg-txt alinetxt" id="scrollSpan"><span>您是代表一个队伍参赛，所带人数大于等于队伍人数，请选择一个比赛！</span><span>如果您是一个人，或者不足一支队伍，请选择单飞席，我们将给您匹配队伍！</span>
			</div>
		</div>
		<div class="wrapbox">
			<div class="tabul-div">
				<ul class="orders-list myzc-ul">
					<li>
						<a href="waiteMate.html" class="gridbox">
							<div class="orders-pic">
								<img src="../../imgs/orderAvatar.jpg" alt="">
							</div>
							<div class="grid-1">
								<h2 class="h2-title">单飞席</h2>
								<p>2015-03-20(星期四) 15:00</p>
								<p>如果大哥想单飞，小弟带你飞。人数：5人</p>
							</div>
						</a>
					</li>
				</ul>
			</div>
			<div class="tab-con">
				<ul id="openMatchList" class="orders-list myzc-ul">
					<!--开放球赛列表-->
				</ul>
			</div>
			<div class="mypanel f-text2">
				<a href="./about_5plus5.php">5+5</a>
				<a href="javascript:;" class="fr" id="goTop">回到顶部</a>
			</div>
			<div class="footer">
				<p class="f-text1">Copyright © 2014－2015四川誉合誉科技版权所有</p>
				<p class="f-text2"></p>
			</div>
		</div>
		<script>
			<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : null;?>
			//滚动消息控件
			var msgScroll = new MarqueeBox({
				obj: $("#scrollSpan")
			});
			
			$(function(){
				 //异步加载公开比赛信息列表
				 $.post("../../servers/match/MatchList.php",
				 	{"zqq_token":"4389c044a602997c5489235fc0fdda65"},function(data){
				 	if(data.code==200){
				 		var matchHtml = "";
				 		$.each(data.data, function(index,item) { 
				 			matchHtml += '<li id="li_'+(index+1)+'"><a href="matchDetail.php?matchId='+item.id_activities+'&openId=<?php echo $openId;?>" class="gridbox">'
							+'<div class="orders-pic"><img class="pitchsavatar" src="../../imgs/orderAvatar.jpg" alt=""></div>'
							+'<div class="grid-1"><h2 class="h2-title">'+item.activityName+'</h2><p>'+item.activityCreateTime+'</p>'
							+'<p>战力'+buildStar(item.personalLevel)+'&nbsp;&nbsp;主队5/5&nbsp;&nbsp;客队4/5</p></div></a></li>';
				 		});
				 		$('#openMatchList').html(matchHtml);
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