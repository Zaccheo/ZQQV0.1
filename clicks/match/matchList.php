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
		<script src="../../js/fastclick.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<script src="../../js/home.js" type="text/javascript"></script>
	</head>
	<body>
		<header class="header">
			<h2><span>开放球赛列表</span></h2>
		</header>
		<div class="tabul-box">
            <div class="tabul-div">
                <ul class="tab-ul">
                    <li><a id="typeAll" href="javascript:;" class="filterBtn current">全部</a></li>
                    <li><a id="typeSolo" href="javascript:;" class="filterBtn">接受单飞</a></li>
                    <li><a id="typeFive" href="javascript:;" class="filterBtn">5人制</a></li>
                    <li><a id="typeSeven" href="javascript:;" class="filterBtn">7人制</a></li>
                </ul>
            </div>
        </div>
		<!--<div class="eromsg-box">
			<div class="eromsg-txt alinetxt" id="scrollSpan"><span>您是代表一个队伍参赛，所带人数大于等于队伍人数，请选择一个比赛！</span><span>如果您是一个人，或者不足一支队伍，请选择单飞席，我们将给您匹配队伍！</span>
			</div>
		</div>-->
		<div class="tabul-div">
			<ul id="waiteMatchBlock" class="orders-list myzc-ul">

				<!--单飞席-->
			</ul>
		</div>
		<div class="tab-con">
			<ul id="openMatchList" class="orders-list myzc-ul">
				<!--开放球赛列表-->
			</ul>
		</div>
		<!-- 加载底部菜单 -->
		<?php include "../bottom.php"; ?>
		<!-- 加载页脚版权 -->
		<?php include "../footer.php"; ?>

		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : 'o5896s_Gge1x6UA_3bCsj9AK7kOI';?>
		<script>
			
			//滚动消息控件
			var msgScroll = new MarqueeBox({
				obj: $("#scrollSpan")
			});
			
			$(function(){
				new FastClick(document.body);

				var openId = '<?php echo $openId;?>';
				//loadWaiteMatch(openId);
				//异步加载公开比赛信息列表
				loadSyncOpenList(openId);

				//过滤按钮
				$(".filterBtn").on("click",function(){
					//全部
					if(!$(this).hasClass("current")){
						$(".filterBtn").removeClass("current");
						$(this).addClass("current");
						//异步加载公开比赛信息列表
						loadSyncOpenList(openId);
					}
				});

				
				//定位导航栏目
			    //var $navHolder = $("#navHolder");
			    var navShow = false;
			    $(window).scroll(function () {
			        //$navHolder.css("height", 0);
			        var scroTop = $(window).scrollTop();
			         var tabulTop = $(".tabul-box").offset().top;
			        if (tabulTop - scroTop <= 5) {
			            $(".tabul-div").addClass("tabul-fixed");
			        } else {
			            $(".tabul-div").removeClass("tabul-fixed");
			        }
			    });
				
			});

			//加载单飞席
			// function loadWaiteMatch(openId){
			// 	$.getJSON("../../servers/match/WaiteMatchInfo.php",function(data){
			// 	 	if(data.code==200){
			// 	 		var matchHtml = "";
			// 	 		$.each(data.data, function(index,item) { 
			// 	 			matchHtml += '<li><a href="waiteMatch.php?wmid='+item.id_solo_list+'&openId='+openId+'" class="gridbox">'
			// 				+'<div class="orders-pic">'
			// 					+'<img src="'+item.headerImgUrl+'" alt="">'
			// 				+'</div>'
			// 				+'<div class="grid-1">'
			// 					+'<h2 class="h2-title">单飞席</h2>'
			// 					+'<p>'+item.soloDate+'('+getWeek(item.soloDate)+') 15:00</p>'
			// 					+'<p>如果大哥想单飞，小弟带你飞。人数：5人</p>'
			// 				+'</div>'
			// 			+'</a>'
			// 			+'</li>';
			// 	 		});
			// 	 		$('#waiteMatchBlock').html(matchHtml);
			// 	 	}
			// 	 });
			// }

			function loadSyncOpenList(openId){
				var $loadType = $(".current");
				var loadType = "";
				if($loadType.attr("id") == "typeFive"){
					loadType = "five";
				}else if($loadType.attr("id") == "typeSolo"){
					loadType = "solo";
				}else if($loadType.attr("id") == "typeSeven"){
					loadType = "seven";
				}else{
					loadType = "";
				}
 				$.post("../../servers/match/MatchList.php",
				 	{
				 		"zqq_token":"4389c044a602997c5489235fc0fdda65",
				 		"loadType":loadType
				 	},function(data){
				 	if(data.code==200){
				 		var matchHtml = "";
				 		$.each(data.data, function(index,item) { 
				 			var oppWanted = '接受队伍挑战';
				 			if(item.oppWanted == 0){
				 				//不约对手
				 				oppWanted = '拒绝队伍挑战';
				 			}
				 			var soloWanted = '接受单飞报名';
				 			if(item.soloWanted == 0){
				 				//拒绝单飞报名
				 				soloWanted = '拒绝单飞报名';
				 			}
				 			matchHtml += '<li id="li_'+(index+1)+'"><a href="matchDetail.php?matchId='+item.id_activities+'&openId='+openId+'" class="gridbox">'
							+'<div class="orders-pic"><img class="pitchsavatar" src="'+item.headerImgUrl+'" alt=""></div>'
							+'<div class="grid-1"><h2 class="h2-title">'+item.activityName+"("+item.nickName+")"+'</h2><p>'+item.zDate+"("+getWeek(item.zDate)+")"+shortTime(item.startTime)+"-"+shortTime(item.endTime)+'开战！</p>'
							+'<p>赛制：'+item.capacity+'人制</p><p>'+oppWanted+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+soloWanted+'</p></div></a></li>';
				 		});
				 		$('#openMatchList').html(matchHtml);
				 	}
				 },"json");
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