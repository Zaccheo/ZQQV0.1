<!DOCTYPE html>
<html lang="zh-cn">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta charset="utf-8">
		<title>我的球赛</title>
		<link rel="stylesheet" href="../../css/common.css">
		<link rel="stylesheet" href="../../css/index.css">
		<script type="text/javascript" src="../../js/wxcheck.js" />
	</head>
	<body>
		<header class="header">
			<div class="hd-btn">
				<a href="＃" data-url="#takepart" class="hd-btn-l active">我参与的</a>
				<a href="＃" data-url="#created" class="hd-btn-r">我创建的</a>
			</div>
		</header>
		<div class="tabbox" id="takepart">
			<div class="tab-con">
				<ul class="orders-list myzc-ul">
					<li id="li1">
						<a href="#" class="gridbox">
							<div class="orders-pic">
								<img src="../../imgs/orderAvatar.jpg" alt="">
							</div>
							<div class="grid-1">
								<h5 class="h5-title">无聊的来踢球，求一位单飞</h5>
								<p>约球时间：2015-03-20 15:00</p>
								<p>约球地点：成都5+5足球俱乐部5号场地
								</p>
								<p>球赛状态：9/10人 未开赛</p>
							</div>
						</a>
						<div class="goods-btnbox clearfix">
							<strong>综合实力4星</strong>
							<a name="btn_delete" href="javascript:;" class="btn btn-normal fr">退出球赛</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
		
		
		<div class="tabbox" id="created">
			<div class="tab-con">
				<ul class="orders-list myzc-ul">
					<li id="li1">
						<a href="#" class="gridbox">
							<div class="orders-pic">
								<img src="../../imgs/orderAvatar.jpg" alt="">
							</div>
							<div class="grid-1">
								<h5 class="h5-title">无聊的来踢球，求一位单飞</h5>
								<p>约球时间：2015-03-20 15:00</p>
								<p>约球地点：成都5+5足球俱乐部5号场地
								</p>
								<p>球赛状态：9/10人 未开赛</p>
							</div>
						</a>
						<div class="goods-btnbox clearfix">
							<strong>综合实力4星</strong>
							<a name="btn_delete" href="javascript:;" class="btn btn-normal fr">退出球赛</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
		
		<div class="mypanel f-text2">
			<a href="about_5plus5.php">5+5</a>
			<a href="javascript:;" class="fr" id="goTop">回到顶部</a>
		</div>
		<div class="footer">
			<p class="f-text1">Copyright © 2014－2015四川誉合誉科技版权所有</p>
			<p class="f-text2"></p>
		</div>
		<script src="../../js/zepto.min.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<!--组件依赖js end-->
		<script type="text/javascript" src="../../js/core/gmu.js"></script>
		<script type="text/javascript" src="../../js/core/event.js"></script>
		<script type="text/javascript" src="../../js/core/widget.js"></script>
		<script type="text/javascript" src="../../js/tabs/tabs.js"></script>
		<script type="text/javascript" src="../../js/tabs/$swipe.js"></script>
		<script type="text/javascript" src="../../js/tabs/$ajax.js"></script>
		<script type="text/javascript">
			$(function() {
				goToTop($("#goTop"));

				//组装openID，随时取用
					window.localStorage.setItem('openId','<?php echo isset($_GET['openId']) ? $_GET['openId'] : "";?>');

				
			});
		</script>
	</body>
</html>