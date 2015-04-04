<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>单飞信息</title>
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
			<h2><span>单飞席</span></h2>
		</header>
		<div class="tabul-box">
            <a name="classify"></a>
            <div class="tabul-div">
                <ul class="tab-ul">
                    <li><a id="chooseTimeFilter" href="javascript:;" class="current">全部时间</a></li>
                    <li><a id="zczd" href="javascript:;">未满员</a></li>
                </ul>
            </div>
        </div>
		<!--<div class="eromsg-box">
			<div class="eromsg-txt alinetxt" id="scrollSpan"><span>您是代表一个队伍参赛，所带人数大于等于队伍人数，请选择一个比赛！</span><span>如果您是一个人，或者不足一支队伍，请选择单飞席，我们将给您匹配队伍！</span>
			</div>
		</div>-->
		<!--时间条件-->
		<div id="timeFilter" class="off">
			<ul id="soloTimeList">
				
			</ul>
		</div>

		<div id="soloInfoDiv" class="on">
			<ul id="soloList" class="orders-list myzc-ul">
						
				<!--单飞席-->
			</ul>
		</div>

		<!-- 加载底部菜单 -->
		<?php include "../bottom.php"; ?>
		<!-- 加载页脚版权 -->
		<?php include "../footer.php"; ?>
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : 'o5896s_Gge1x6UA_3bCsj9AK7kOI';?>
		<script>
			var openId = '<?php echo $openId;?>';
			//滚动消息控件
			var msgScroll = new MarqueeBox({
				obj: $("#scrollSpan")
			});
			
			$(function(){
				
				loadSoloList();
				//异步加载公开比赛信息列表
				//loadSyncOpenList(openId);

				//回到顶部和定位导航栏目
			    var $navHolder = $("#navHolder");
			    var navShow = false;
			    $(window).scroll(function () {
			        $navHolder.css("height", 0);
			        var scroTop = $(window).scrollTop();
			         var tabulTop = $(".tabul-box").offset().top;
			        if (tabulTop - scroTop <= 5) {
			            $(".tabul-div").addClass("tabul-fixed");
			        } else {
			            $(".tabul-div").removeClass("tabul-fixed");
			        }
			    });

			    $("#timeFilter").hide();
			    //时间选择过滤菜单
			    $("#chooseTimeFilter").on("click",function(){
			    	if($("#soloInfoDiv").hasClass("off")){
			    		$("#soloInfoDiv").removeClass("off");
			    		$("#soloInfoDiv").addClass("on");
			    		$("#soloInfoDiv").show();
			    		$("#timeFilter").hide();
			    	}else{
			    		$("#soloInfoDiv").removeClass("on");
			    		$("#soloInfoDiv").addClass("off");
			    		$("#timeFilter").show();
			    		$("#soloInfoDiv").hide();
			    	}
			    });

			    //加载日期选择
			    loadTimeFilter();
			});
			//缓存数据	
			var cacheData;

			//加载单飞席
			function loadSoloList(filterWords){
				$.post("../../servers/solo/soloList.php",
					{"filter":filterWords?filterWords:""},function(data){
						//cacheData = data;
					 	if(data.code==200){
					 		var matchHtml = '<div id="noSoloInfo" style="text-align:center; top: 50%;">暂时没有单飞需求</div>';
							if(data.data){
								matchHtml = '';
								$.each(data.data, function(index,item) {
								matchHtml += '<li><a href="soloDetail.php?soloid='+item.id_solo_list+'&openId='+openId+'" class="gridbox">'
										+'<div class="orders-pic">'
											+'<img src="'+item.headerImgUrl+'" alt="">'
										+'</div>'
										+'<div class="grid-1">'
											+'<h2 class="h2-title">单飞席 '+item.nickName+'</h2>'
											+'<p>'+item.soloDate+'('+getWeek(item.soloDate)+') '+shortTime(item.soloStartTime)+'-'+shortTime(item.soloEndTime)+'</p>'
											+'<p>助您解决找队难题。需求人数：'+item.numberWanted+'人</p>'
										+'</div>'
										+'</a>'
										+'</li>';
								});
								$('#soloList').html(matchHtml);
								//处理高度，让信息垂直水平居中显示
								if($("#noSoloInfo")){
								 	placeCenter();
								}
								$("#soloInfoDiv").removeClass("off");
							    $("#soloInfoDiv").addClass("on");
							    $("#soloInfoDiv").show();
							    $("#timeFilter").hide();
							}
					 	}
				},"json");
			}

			function loadDataFunc(data){
				
			}

			//加载时间过滤条件
			function loadTimeFilter(){
				$.getJSON("../../servers/solo/soloTimeSelect.php",function(data){
					if(data.code == 200){
						var selectHtml = '<li id="filter_0" class="currsel"><a href="javascript:;" onclick="filterFunc(0,null)"><h4>全部时间</h4></a></li>';
						$.each(data.data,function(index,item){
							selectHtml += '<li id=filter_'+(index+1)+'>'
									   +'<a href="javascript:;" onclick="filterFunc('+(index+1)+',\''+item.soloDate+'\')"><h4>'+item.soloDate+'('+getWeek(item.soloDate)+')</h4></a>'
									   +'</li>';
						});
						$("#soloTimeList").html(selectHtml);
					}
				});
			}

			//过滤方法
			function filterFunc(fin,filterWords){
				//重新加载
				loadSoloList(filterWords);
				//处理样式
				$(".currsel").each(function(){
					$(this).removeClass("currsel");
				})
				$("#filter_"+fin).addClass("currsel");
				var text = $("#filter_"+fin).children().children().html();
				$("#chooseTimeFilter").html(text);
			}

			function buildStar(forces) {
				var starHtml = "";
				for (var i = 0; i < Math.round(forces); i++) {
					starHtml += "<i style='color:red;'>★</i>";
				}
				return starHtml;
			}

			function placeCenter(){
				//处理宽度
				var hi = (document.body.clientHeight - 175);
				$('#noSoloInfo').css('line-height', hi + 'px');
			}

		</script>
	</body>
</html>