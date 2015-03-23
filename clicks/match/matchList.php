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
					<li id="li2">
						<a href="orderDetail.html" class="gridbox">
							<div class="orders-pic">
								<img class="pitchsavatar" src="../../imgs/orderAvatar.jpg" alt="">
							</div>
							<div class="grid-1">
								<h2 class="h2-title">开春球赛</h2>
								<p>2015-03-20(星期四) 15:00</p>
								<p>战力<i style="color:red;">★★★★</i><i>★</i>&nbsp;&nbsp;主队6/5&nbsp;&nbsp;客队3/5</p>
							</div>
						</a>
					</li>
					<li id="li3">
						<a href="orderDetail.html" class="gridbox">
							<div class="orders-pic">
								<img class="pitchsavatar" src="../../imgs/orderAvatar.jpg" alt="">
							</div>
							<div class="grid-1">
								<h2 class="h2-title">国家德比</h2>
								<p>2015-03-20(星期四) 15:00</p>
								<p>战力<i style="color:red;">★★★★</i><i>★</i>&nbsp;&nbsp;主队6/5&nbsp;&nbsp;客队3/5</p>
							</div>
						</a>
					</li>
					<li id="li3">
						<a href="orderDetail.html" class="gridbox">
							<div class="orders-pic">
								<img class="pitchsavatar" src="../../imgs/orderAvatar.jpg" alt="">
							</div>
							<div class="grid-1">
								<h2 class="h2-title">国家德比</h2>
								<p>2015-03-20(星期四) 15:00</p>
								<p>战力<i style="color:red;">★★★★</i><i>★</i>&nbsp;&nbsp;主队6/5&nbsp;&nbsp;客队3/5</p>
							</div>
						</a>
					</li>
					<li id="li3">
						<a href="orderDetail.html" class="gridbox">
							<div class="orders-pic">
								<img class="pitchsavatar" src="../../imgs/orderAvatar.jpg" alt="">
							</div>
							<div class="grid-1">
								<h2 class="h2-title">国家德比</h2>
								<p>2015-03-20(星期四) 15:00</p>
								<p>战力<i style="color:red;">★★★★</i><i>★</i>&nbsp;&nbsp;主队6/5&nbsp;&nbsp;客队3/5</p>
							</div>
						</a>
					</li>
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
		<script src="../../js/zepto.min.js" type="text/javascript"></script>
		<script src="../../js/zepto.picLazyLoad.min.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<script src="../../js/home.js" type="text/javascript"></script>
		<script>
			var msgScroll = new MarqueeBox({
				obj: $("#scrollSpan")
			});
			
			$(function(){
				
				 //异步加载
				 $.get("../../servers/match/matchList.json",function(data){
				 	if(data.code==200){
				 		var matchHtml = "";
				 		$.each(data.openList, function(index,item) { 
				 			   matchHtml += '<li id="li_'+(index+1)+'"><a href="matchDetail.php?matchId='+item.id+'" class="gridbox">'
							+'<div class="orders-pic"><img class="pitchsavatar" src="'+item.imgsrc+'" alt=""></div>'
							+'<div class="grid-1"><h2 class="h2-title">'+item.title+'</h2><p>'+item.date+'('+item.week+') '+item.time+'</p>'
							+'<p>战力<i style="color:red;">★★★★</i><i>★</i>&nbsp;&nbsp;主队'+item.hosts+'/'+item.scales+'&nbsp;&nbsp;客队'+item.visits+'/'+item.scales+'</p></div></a></li>';
				 		});
				 		$('#openMatchList').html(matchHtml);
				 	}
				 })
			});
		</script>
	</body>
</html>