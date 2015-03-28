<<<<<<< Updated upstream
<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta charset="utf-8">
		<title>选择对应比赛场地</title>
		<link rel="stylesheet" href="../../css/common.css">
		<link rel="stylesheet" href="../../css/order.css" />
		<style>
		</style>
	</head>
	<body>
		<header class="header">
			<div class="backleft">
				<a href="javascript:window.history.go(-1);">
				<i class="icon-back"></i></a>
			</div>
			<h2 id="pitchTitleInfo"><?php echo $_GET['pdate'];?>(<?php echo $_GET['pweek'];?>)</h2>
		</header>
		<div class="qu">
			<div class="page page-submitOrder">
				<div class="order-bd">
					<div class="tbl-wrap clearfix">
						<div class="time-wrap">
							<ul class="J_timeSlice">
								<!--处理左边时间菜单-->
							</ul>
						</div>
						<div class="court-wrap clearfix J_courts" id="wrapper">
							<div class="inner" id="scroller">
								<!--处理单元格和表头-->
								<div class="col">
									<div class="court-name" ></div>
								</div>
								<div class="col">
									<div class="court-name" ></div>
								</div>
								<!--空白div两个保留，预加载样式-->
							</div>
						</div>
					</div>
					<div class="tips-wrap">
						<div class="color-tips">
							<i class="cb available"></i><span>可预订</span>
							<i class="cb disable"></i><span>已预定</span>
							<i class="cb active"></i><span>我的预订</span>
						</div>
					</div>
					<div class="order-detail clearfix">
						<div class="left" style="height: 35px;line-height: 35px;">
							<p class="total"><em style="font-size: 14px;"></em>&nbsp;&nbsp;共计：<span>0</span>元</p>
							<p class="coupon"></p>
						</div>
						<div class="right">
							<a href="javascript:;" class="btn-orange btn-orange-l pitch_submit">确定选场</a>
						</div>
					</div>
				</div>
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
		<script type="text/javascript">

			$(function() {
				goToTop($("#goTop"));
				
				//加载可选场地数据	
				$.post("../../servers/pitch/selectPitchs.php",{
					"pid":<?php echo $_GET['pid'];?>
					},function(data){
						if(data.code == 200){
							var court = "";
							$.each(data.data.pitch,function(index,item){
								court+='<div class="col"><div class="court-name" >'+index+'</div>';
								$.each(item,function(idx,itm){
									var status = "";
									if(itm.orderStatus == 0){
										status = "available";
									}else{
										status = "disable";
									}
									court+='<div id="pitch_'+itm.id+'" zDate="'+itm.zDate+'" startTime="'+itm.startTime+'" endTime="'+itm.endTime+'" pitchid="'+itm.id+'" class="court-detail '+status+'">'+itm.charge+'</div>';
								});
								court += '</div>';
							});
							$("#scroller").html(court);
							var timeSlice = "";
							$.each(data.data.time,function(idx,itm){
								timeSlice += "<li>"+itm+"</li>";
							});
							$(".J_timeSlice").html(timeSlice);
							//生成html元素后，再进行事件绑定
							loadEvent();
						}
				},"json");
			});
			
			function loadEvent(){
				//已选择的球场编号
			var selectPitchs = {};
			//创建触屏事件
			var touchClick = ('createTouch' in document) ? 'tap':'click';
			var dateStr = "";
			//点击场次选择
				$('.court-detail').on('click',function(){
					//已选择的球场编号
					//var currentPitchs = {};
					var el = $(this);
					var curPid = el.attr('pitchid');//当前选择的预订场次
					if(el.hasClass('disable')){
						return;
					}
					//若已经被选中,点击一次则进行删除操作
					if(selectPitchs[curPid]){
						delete selectPitchs[curPid];
						dateStr = "";
						//alert("!");
						el.removeClass('selected');
						el.addClass('available');
					}else{
						//点击未选中的，则进行选中操作
						selectPitchs[curPid] = parseInt(el.html());
						dateStr =el.attr('zDate')+" "+getWeek(el.attr('zDate'))+" "+el.attr('startTime').substr(0, 5)+" "+el.attr('endTime').substr(0, 5);
						el.removeClass('available');
						$('.court-detail').each(function(){
							$(this).removeClass('selected');
							$(this).addClass('available');
						});
						el.addClass('selected');
					}
				});
				
				//提交选中的场次
				$(".pitch_submit").on('click',function(){
					if($.isEmptyObject(selectPitchs)){
						alert("请选择一个场！");
						return;
					}
					var pIDS = new Array();
					$.each(selectPitchs,function(k,v){
						pIDS.push(k);
					});
					window.localStorage.setItem("pitchOrderId",pIDS);
					window.localStorage.setItem("selpitch",dateStr);
					window.history.go(-1);
				});
			}
		</script>		
		<script>
			//处理宽度
			var wi = (document.body.clientWidth - 45);
			$('#wrapper').css('width', wi + 'px');
			
			//处理内部宽度
			var innerWi = $("#scroller").children("div").length;
			$('#scroller').css('width',innerWi*58+18+'px');
			
			//外部高度处理
			$("#wrapper").css('height',10*25+10+"px");
			$('#scroller').css('height',10*25+10+"px");
			//单列宽度58px，高度25px，根据此数值计算列表项的容器宽高
		</script>
	</body>

=======
<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta charset="utf-8">
		<title>选择对应比赛场地</title>
		<link rel="stylesheet" href="../../css/common.css">
		<link rel="stylesheet" href="../../css/order.css" />
		<style>
		</style>
	</head>
	<body>
		<header class="header">
			<div class="backleft">
				<a href="javascript:window.history.go(-1);">
				<i class="icon-back"></i></a>
			</div>
			<h2 id="pitchTitleInfo"><?php echo $_GET['pdate'];?>(<?php echo $_GET['pweek'];?>)</h2>
		</header>
		<div class="qu">
			<div class="page page-submitOrder">
				<div class="order-bd">
					<div class="tbl-wrap clearfix">
						<div class="time-wrap">
							<ul class="J_timeSlice">
								<!--处理左边时间菜单-->
							</ul>
						</div>
						<div class="court-wrap clearfix J_courts" id="wrapper">
							<div class="inner" id="scroller">
								<!--处理单元格和表头-->
								<div class="col">
									<div class="court-name" ></div>
								</div>
								<div class="col">
									<div class="court-name" ></div>
								</div>
								<!--空白div两个保留，预加载样式-->
							</div>
						</div>
					</div>
					<div class="tips-wrap">
						<div class="color-tips">
							<i class="cb available"></i><span>可预订</span>
							<i class="cb disable"></i><span>已预定</span>
							<i class="cb active"></i><span>我的预订</span>
						</div>
					</div>
					<div class="order-detail clearfix">
						<div class="left" style="height: 35px;line-height: 35px;">
							<p class="total"><em style="font-size: 14px;"></em>&nbsp;&nbsp;共计：<span>0</span>元</p>
							<p class="coupon"></p>
						</div>
						<div class="right">
							<a href="javascript:;" class="btn-orange btn-orange-l pitch_submit">确定选场</a>
						</div>
					</div>
				</div>
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
		<script type="text/javascript">

			$(function() {
				goToTop($("#goTop"));
				
				//加载可选场地数据	
				$.post("../../servers/pitch/selectPitchs.php",{
					"pid":<?php echo $_GET['pid'];?>
					},function(data){
						if(data.code == 200){
							var court = "";
							$.each(data.data.pitch,function(index,item){
								court+='<div class="col"><div class="court-name" >'+index+'</div>';
								$.each(item,function(idx,itm){
									var status = "";
									if(itm.orderStatus == 0){
										status = "available";
									}else{
										status = "disable";
									}
									court+='<div id="pitch_'+itm.id+'" zDate="'+itm.zDate+'" startTime="'+itm.startTime+'" endTime="'+itm.endTime+'" pitchid="'+itm.id+'" class="court-detail '+status+'">'+itm.charge+'</div>';
								});
								court += '</div>';
							});
							$("#scroller").html(court);
							var timeSlice = "";
							$.each(data.data.time,function(idx,itm){
								timeSlice += "<li>"+itm+"</li>";
							});
							$(".J_timeSlice").html(timeSlice);
							//生成html元素后，再进行事件绑定
							loadEvent();
						}
				},"json");
			});
			
			function loadEvent(){
				//已选择的球场编号
			var selectPitchs = {};
			//创建触屏事件
			var touchClick = ('createTouch' in document) ? 'tap':'click';
			var dateStr = "";
			//点击场次选择
				$('.court-detail').on('click',function(){
					//已选择的球场编号
					//var currentPitchs = {};
					var el = $(this);
					var curPid = el.attr('pitchid');//当前选择的预订场次
					if(el.hasClass('disable')){
						return;
					}
					//若已经被选中,点击一次则进行删除操作
					if(selectPitchs[curPid]){
						delete selectPitchs[curPid];
						dateStr = "";
						//alert("!");
						el.removeClass('selected');
						el.addClass('available');
					}else{
						//点击未选中的，则进行选中操作
						selectPitchs[curPid] = parseInt(el.html());
						dateStr =el.attr('zDate')+" "+getWeek(el.attr('zDate'))+" "+el.attr('startTime').substr(0, 5)+" "+el.attr('endTime').substr(0, 5);
						el.removeClass('available');
						$('.court-detail').each(function(){
							$(this).removeClass('selected');
							$(this).addClass('available');
						});
						el.addClass('selected');
					}
				});
				
				//提交选中的场次
				$(".pitch_submit").on('click',function(){
					if($.isEmptyObject(selectPitchs)){
						alert("请选择一个场！");
						return;
					}
					var pIDS = new Array();
					$.each(selectPitchs,function(k,v){
						pIDS.push(k);
					});
					window.localStorage.setItem("pitchOrderId",pIDS);
					window.localStorage.setItem("selpitch",dateStr);
					window.history.go(-1);
				});
			}
		</script>		
		<script>
			//处理宽度
			var wi = (document.body.clientWidth - 45);
			$('#wrapper').css('width', wi + 'px');
			
			//处理内部宽度
			var innerWi = $("#scroller").children("div").length;
			$('#scroller').css('width',innerWi*58+18+'px');
			
			//外部高度处理
			$("#wrapper").css('height',10*25+10+"px");
			$('#scroller').css('height',10*25+10+"px");
			//单列宽度58px，高度25px，根据此数值计算列表项的容器宽高
		</script>
	</body>

>>>>>>> Stashed changes
</html>