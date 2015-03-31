<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta name="author" content="yangwoot@gmail.com" />
		<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />
		<title>足球圈</title>
		<link rel="stylesheet" href="../css/common.css">
		<link rel="stylesheet" href="../css/index.css" />
		
	</head>
	<body>
		<header class="header">
			<h2><span>成都5+5足球俱乐部</span></h2>
		</header>
		
		<!-- 分类 -->
				<div class="slide-box category-box">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<ul class="admin-menu-ul mt15 mb15 clearfix">
								<li><a href="./addPitch.php" class="admin-menu-a category1"><span>添加球场信息</span></a>
								</li>
								<li><a href="./modifyPitch.php" class="admin-menu-a category1"><span>修改球场信息</span></a>
								</li>
								<li><a href="./pitchChargeAdd.php" class="admin-menu-a category1"><span>添加球场定价</span></a>
								</li>
								<li><a href="./pitchChargeModify.php" class="admin-menu-a category1"><span>修改球场定价</span></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<br>
			<div class="footer">
				<p class="f-text1">Copyright © 2014－2015四川誉合誉科技版权所有</p>
				<p class="f-text2">
				</p>
			</div>
		</div>
		<script src="../js/zepto.min.js" type="text/javascript"></script>
		<script>
			 $(function(){

			 	$("#fansManage").on("click",function(){
			 		window.location="fansManage.php";
			 	});
			 });
	
		</script>
	</body>
</html>