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
			<h2>
			<select id="pitchTitleInfo" class="select-input">
				
			</select>
			</h2>
		</header>
		<!--时间条件-->
		<div id="timeFilter" class="off">
			<ul id="soloTimeList">
				
			</ul>
		</div>
		<div class="qu">
			<div class="page page-submitOrder">
				<div class="order-bd">
					<div id="pitchBlockContainer" class="tbl-wrap clearfix">
						<!--处理左边时间菜单-->
						<!--处理单元格和表头-->
					</div>
					<div class="tips-wrap">
						<div class="color-tips">
							<i class="cb available"></i><span>可预订</span>
							<i class="cb disable"></i><span>已预定</span>
							<i class="cb active"></i><span>我的预订</span>
						</div>
					</div>
					<div class="order-detail clearfix">
						<div class="left">
							<p class="total" style="line-height:19px">
								<em style="font-size: 14px;" id="selectedTimeInfo">已选：<?php echo $_GET['pdate'];?>(<?php echo $_GET['pdate'];?>)</em>
								<!--&nbsp;&nbsp;共计：<span>0</span>元-->
							</p>
							<p class="coupon" style="font-weight: bold;line-height:19px"></p>
						</div>
						<div class="right">
							<a href="javascript:;" class="btn-orange btn-orange-l pitch_submit">确定选场</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--加载页面底部版权信息-->
		<?php include "../footer.php";?>
		<script src="../../js/zepto.min.js" type="text/javascript"></script>
		<script src="../../js/fastclick.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<!--组件依赖js end-->
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : null;?>
		<script type="text/javascript">
			//已选择的球场编号
			var selectPitchs = {};
			var dateStr = "";
			
			$(function() {
				new FastClick(document.body);

				goToTop($("#goTop"));

				//加载title位置的时间下拉框
				loadSelPitchTimer();

				//加载场地信息
				loadSelPitchsInfo('<?php echo $_GET['pdate'];?>');

				$("#pitchTitleInfo").on("change",function(){
					//变化一次日期，清空已选择的数据，重新选择
					selectPitchs = {};
					dateStr = "";
					$(".court-detail").removeClass('selected');
					$(".coupon").html('');
					//重新根据日期加载
					loadSelPitchsInfo($(this).val());
					$("#selectedTimeInfo").html("已选："+$(this).val()+"("+getWeek($(this).val())+")");
				});
			});

			//加载时间选择器
			function loadSelPitchTimer(){
				$("#selectedTimeInfo").html("已选："+'<?php echo $_GET['pdate'];?>'+"("+getWeek('<?php echo $_GET['pdate'];?>')+")");
				//获取当前可预约的时间列表信息
				$.getJSON('../../servers/pitch/pitchTimeSelect.php',function(data){
					var selectTitleHtml = "";
					if(data.code == 200){
						$.each(data.data, function(index,item) {  
							var pweek = getWeek(item.zDate);
							var selected = "";
							if(item.zDate == '<?php echo $_GET['pdate'];?>'){
								selected = "selected";
							}
							selectTitleHtml+='<option '+selected+' value="'+item.zDate+'">'+item.zDate+'('+pweek+')</option>';
						});
					}
					$("#pitchTitleInfo").html(selectTitleHtml);
				});
			}

			//加载可选场地
			function loadSelPitchsInfo(pdate){
				//加载可选场地数据	
				$.post("../../servers/pitch/selectPitchs.php",{
					"pdate":pdate
					},function(data){
						if(data.code == 200){
							var timeSlices = data.data.time;
							var court = '<div class="court-wrap clearfix J_courts" id="wrapper"><div class="inner" id="scroller">';
							$.each(data.data.pitch,function(index,item){
								court+='<div class="col"><div class="court-name" >'+index+'</div>';
								var container = "";
								$.each(item,function(idx,itm){
									container += itm.startTime;
								});
								//根据时间建立遍历条件
								for(var i=0;i<timeSlices.length-1;i++){
									if(container.indexOf(timeSlices[i])>-1){
										$.each(item,function(idx,itm){
											var status = "";
											if(itm.orderStatus == 0){
												status = "available";
											}else{
												status = "disable";
											}
											if(itm.startTime == timeSlices[i]){
												court+='<div id="pitch_'+itm.id+'" courtName='+index+' zDate="'+itm.zDate+'" startTime="'+itm.startTime+'" endTime="'+itm.endTime+'" pitchid="'+itm.id+'" class="court-detail '+status+'">'+itm.charge+'</div>';
											}
										});
									}else{
										court+=disabedCourtPitch();
									}
								}
								// $.each(timeSlices,function(tdx,tda){
									
										// var status = "";
										// if(itm.orderStatus == 0){
										// 	status = "available";
										// }else{
										// 	status = "disable";
										// }
										// //如果时间线等于开始时间，则数据绑定
										// if(tda == itm.startTime){
										// 	court+='<div id="pitch_'+itm.id+'" courtName='+index+' zDate="'+itm.zDate+'" startTime="'+itm.startTime+'" endTime="'+itm.endTime+'" pitchid="'+itm.id+'" class="court-detail '+status+'">'+itm.charge+'</div>';
										// }else{
											
								// 	// 	}
								// 	// });
								// });
								// $.each(item,function(idx,itm){
								// 	//填充
								// 	//court += fillCourtPitchs(index,itm,timeSlices);
								// 	// //判断是否包含在对应的时间菜单里
								// 	// $.each(timeSlices,function(k,v){
								// 	// 	//判断是否有开始时间
								// 	// 	if(v == itm.startTime){

								// 	// 	}
								// 	// });
									
									
								// });
								court += '</div>';
							});
							court += '</div></div>';
							
							var timeSlice = '<div class="time-wrap"><ul class="J_timeSlice">';
							$.each(data.data.time,function(idx,itm){
								timeSlice += '<li>'+shortTime(itm)+'</li>';
							});
						timeSlice +='</ul></div>'+court;
						$("#pitchBlockContainer").html(timeSlice);
						$("#pitchBlockContainer").trigger("create");
						//生成html元素后，再进行事件绑定
						loadEvent();
						resizeWinSize();
					}
				},"json");
			}

			//填充球场内容块
			function fillCourtPitchs(index,itm,times){
				//首先遍历时间列表长度
				var status = "";
				if(itm.orderStatus == 0){
					status = "available";
				}else{
					status = "disable";
				}
				var html = "";
				$.each(times,function(dk,dv){
					//dv;//时间
					if(itm.startTime == dv){
						html += '<div id="pitch_'+itm.id+'" courtName='+index+' zDate="'+itm.zDate+'" startTime="'+itm.startTime+'" endTime="'+itm.endTime+'" pitchid="'+itm.id+'" class="court-detail '+status+'">'+itm.charge+'</div>';
					}else{
						html += disabedCourtPitch();
					}
				});
				
				return html;
			}

			//补充模块
			function disabedCourtPitch(){
				return '<div class="court-detail disable"></div>';
			}

			// function obj2str(o){   
	  //           var r = [];   
	  //           if(typeof o =="string") return o.replace(/(['"\])/g,"\$1").replace(/(n)/g,"\n").replace(/(r)/g,"\r").replace(/(t)/g,"\t");   
	  //           if(typeof o =="undefined") return "";   
	  //           if(typeof o == "object"){   
	  //               if(o===null) return "null";   
	  //               else if(!o.sort){   
	  //                   for(var i in o)   
	  //                       r.push(i+":"+obj2str(o[i]))   
	  //                   r="{"+r.join()+"}"  
	  //               }else{   
	  //                   for(var i =0;i<o.length;i++)   
	  //                       r.push(obj2str(o[i]))   
	  //                   r="["+r.join()+"]"  
	  //               }   
	  //               return r;   
	  //           }   
	  //           return o.toString();   
	  //       }  
			
			function loadEvent(){
				//点击场次选择
				$('.court-detail').on('click',function(){
					//已选择的球场编号
					var el = $(this);
					var curPid = el.attr('pitchid');//当前选择的预订场次
					if(el.hasClass('disable')){
						return;
					}
					//若已经被选中,点击一次则进行删除操作
					if(selectPitchs[curPid]){
						delete selectPitchs[curPid];
						dateStr = "";
						el.removeClass('selected');
						el.addClass('available');
						$(".coupon").html('');
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
						var dateTime = el.attr('courtName')+" "+shortTime(el.attr("starttime"))+"-"+shortTime(el.attr("endtime"));
						$(".coupon").html(dateTime);
					}
				});
				
				//提交选中的场次
				$(".pitch_submit").on('click',function(){
					if($.isEmptyObject(selectPitchs)){
						alertWarning("请选择一个场！","top");
						return;
					}else{
						var pIDS = new Array();
						$.each(selectPitchs,function(k,v){
							pIDS.push(k);
						});
						window.localStorage.setItem("pitchOrderId",pIDS);
						window.localStorage.setItem("selpitch",dateStr);
						window.location = "../match/organMatch.php?openId=<?php echo $openId;?>";
					}
				});
			}

			//重新计算选择球场的容器尺寸
			var resizeWinSize = function(){
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
			}
		</script>		
		<script>
			
		</script>
	</body>
</html>