<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>单飞管理</title>
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
			<h2><span>单飞管理</span></h2>
		</header>
		<nav>
			<input type="text" placeholder="请输入活动名/创建者" id="searchKey"/>
			<input type="button" class="search-btn">
		</nav>
		<!--<div class="eromsg-box">
			<div class="eromsg-txt alinetxt" id="scrollSpan"><span>您是代表一个队伍参赛，所带人数大于等于队伍人数，请选择一个比赛！</span><span>如果您是一个人，或者不足一支队伍，请选择单飞席，我们将给您匹配队伍！</span>
			</div>
		</div>-->
		<div class="wrapbox">
			<div class="tabul-div">
				<ul id="soloList" class="orders-list myzc-ul">
						<li><a href="waiteMatch.php?wmid='+item.id_solo_list+'&openId='+openId+'" class="gridbox">
							<div class="orders-pic">
								<img src="" alt="">
							</div>
							<div class="grid-1">
								<h2 class="h2-title">单飞席</h2>
								<p>'+item.soloDate+'('+getWeek(item.soloDate)+') 15:00</p>
								<p>如果大哥想单飞，小弟带你飞。人数：5人</p>
							</div>
						</a>
						</li>
					<!--单飞席-->
					
				</ul>
				<div class="orders-add">
					<a href="javascript:;" id="soloAdd"><img src="../../imgs/add2.png" alt=""></a>
				</div>
			</div>
			<!-- 加载底部菜单 -->
			<?php include "../bottom.php"; ?>
			<!-- 加载页脚版权 -->
			<?php include "../footer.php"; ?>
		</div>
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : "";?>
		<script>
			var openId = '<?php echo $openId;?>';
			//滚动消息控件
			var msgScroll = new MarqueeBox({
				obj: $("#scrollSpan")
			});
			
			$(function(){
				var openId = '<?php echo $openId;?>';
				//加载单飞席信息表
				loadSoloList(openId);

				//添加单飞信息
				$("#soloAdd").on("click",function(){
					window.location = "soloAdd.php?openId="+openId;
				});
			});

			//加载单飞席
			function loadSoloList(openId){
				$.getJSON("../../servers/solo/soloList.php",function(data){
					var matchHtml = '';
				 	if(data && data.code==200){
				 		$.each(data.data, function(index,item) { 
				 			matchHtml += '<li><a href="waiteMatch.php?wmid='+item.id_solo_list+'&openId='+openId+'" class="gridbox">'
							+'<div class="orders-pic">'
								+'<img src="'+item.headerImgUrl+'" alt="">'
							+'</div>'
							+'<div class="grid-1">'
								+'<h2 class="h2-title">单飞席</h2>'
								+'<p>'+item.soloDate+'('+getWeek(item.soloDate)+') 15:00</p>'
								+'<p>如果大哥想单飞，小弟带你飞。人数：5人</p>'
							+'</div>'
						+'</a>'
						+'</li>';
				 		});
				 	}
				 	matchHtml += '';
				 	$('#soloList').html(matchHtml);
				 });
			}

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