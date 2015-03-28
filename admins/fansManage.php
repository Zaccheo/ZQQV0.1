<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>会员信息</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="../css/common.css" />
		<link rel="stylesheet" href="../css/index.css" />
		<style type="text/css">
			input:-webkit-autofill,
			input:-webkit-autofill:hover,
			input:-webkit-autofill:focus {
			    box-shadow:0 0 0 60px #fff inset;
			    -webkit-text-fill-color: #333;
			}
		</style>
		<script src="../js/wxcheck.js" type="text/javascript"></script>
		<script src="../js/zepto.min.js" type="text/javascript"></script>
		<script src="../js/zepto.picLazyLoad.min.js" type="text/javascript"></script>
		<script src="../js/proTools.js" type="text/javascript"></script>
		<script src="../js/home.js" type="text/javascript"></script>
	</head>
	<body>
		<header class="header">
			<h2><span>关注会员列表</span></h2>
		</header>
		<div class="wrapbox">
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
			<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : null;
			?>
			
			$(function(){
				 //异步加载公开比赛信息列表
				 $.post("../servers/match/MatchList.php",
				 	{"zqq_token":"4389c044a602997c5489235fc0fdda65"},function(data){
				 	if(data.code==200){
				 		var matchHtml = "";
				 		$.each(data.data, function(index,item) { 
				 			matchHtml += '<li id="li_'+(index+1)+'"><a href="matchDetail.php?matchId='+item.id_activities+'&openId=<?php echo $openId;?>" class="gridbox">'
							+'<div class="orders-pic"><img class="pitchsavatar" src="../imgs/orderAvatar.jpg" alt=""></div>'
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