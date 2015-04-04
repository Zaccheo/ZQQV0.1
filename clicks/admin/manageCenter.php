<!DOCTYPE html>
<html>
	<head>
		<!--这里是管理中心界面，包含
		1.“粉丝管理”
		2.“球赛管理”
		3.“单飞管理”

		球场管理，注意区别-->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>管理中心</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="../../css/common.css">
		<link rel="stylesheet" href="../../css/index.css" />
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : "o5896s_Gge1x6UA_3bCsj9AK7kOI";?>
	</head>
	<body>
		<header class="header">
			<h2><span>管理中心</span></h2>
		</header>
		<!-- 分类 -->
		<h2 class="h2-title" style="float:left;">球赛管理</h2>
		<div class="slide-box category-box">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<ul class="admin-menu-ul mt15 mb15 clearfix">
						<li>
						<a href="javascript:;" id="fansManage" class="admin-menu-a category2"><span>粉丝管理</span></a>
						</li>
						<li>
						<a href="javascript:;" id="soloManage" class="admin-menu-a category2">
						<span>单飞管理</span></a>
						</li>
						<li>
						<a href="javascript:;" id="teamInManage" class="admin-menu-a category2">
						<span>球赛管理</span></a>
						</li>
					</ul>			
				</div>
			</div>
		</div>
		<h2 class="h2-title" style="float:left;">球场管理</h2>
		<div class="slide-box category-box">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<ul class="admin-menu-ul mt15 mb15 clearfix">
								<li><a href="../../admins/addPitch.php" class="admin-menu-a category1"><span>添加球场信息</span></a>
								</li>
								<li><a href="../../admins/modifyPitch.php" class="admin-menu-a category1"><span>修改球场信息</span></a>
								</li>
								<li><a href="../../admins/pitchChargeAdd.php" class="admin-menu-a category1"><span>添加球场定价</span></a>
								</li>
								<li><a href="../../admins/pitchChargeModify.php" class="admin-menu-a category1"><span>修改球场定价</span></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
		<br>
		<!--加载页面版权信息-->
		<?php include "../footer.php"; ?>
		</div>
		<script src="../../js/zepto.min.js" type="text/javascript"></script>
		<script>
			 $(function(){

			 	//粉丝管理
			 	$("#fansManage").on("click",function(){
			 		window.location = "fansManage.php";
			 	});
			 	//单飞席管理
			 	$("#soloManage").on("click",function(){
			 		window.location = "soloManage.php?openId='<?php echo $openId;?>'";
			 	});
			 	//球队进场的时候需要记录球赛活动状态，转向待确认进场的列表页面
			 	$("#teamInManage").on("click",function(){
			 		window.location = "teamInList.php";
			 	});
			 	//球队比赛完成结算的时候需要记录状态和更新相关表
			 	$("#matchSettlement").on("click",function(){
			 		window.location = "settlement.php";
			 	});
			 });
	
		</script>
	</body>
</html>