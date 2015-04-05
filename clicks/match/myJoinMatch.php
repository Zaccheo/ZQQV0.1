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
		<script src="../../js/wxcheck.js" type="text/javascript"></script>
		<script src="../../js/zepto.min.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<!--组件依赖js end-->
	</head>
	<body>
		<header class="header">
			<div class="hd-btn">
				<a href="javascript:;" id="myJoinMatch" class="hd-btn-l active">我参与的</a>
				<a href="javascript:;" id="myCreatedMatch" class="hd-btn-r">我创建的</a>
			</div>
		</header>
		<div class="tabbox" id="takepart">
			<div class="tab-con">
				<ul id="matchList" class="orders-list myzc-ul">
					<!--加载我的球赛-->
				</ul>
			</div>
		</div>
		<!--页面底部菜单-->
		<?php include "../bottom.php";?>
		<!--页面底部版权信息-->
		<?php include "../footer.php";?>
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : "o5896s_Gge1x6UA_3bCsj9AK7kOI";?>
		<script type="text/javascript">
			
			$(function() {
				goToTop($("#goTop"));

				//第一次加载我参与的球赛
				loadMyJoinMatch();
				//点击事件，触发页面加载
				$(".hd-btn-r").on("click",function(){
					loadMyCreatedMatch();	
				});
			});

			//加载我参与的比赛
			function loadMyJoinMatch(){
				$.ajax({
					type: "POST",
					async:false,
					url: "../../servers/match/LoadMyJoinMatch.php",
					dataType: 'json',
					data: {"openId":'<?php echo $openId;?>'},
					success: function(data){
						var matchList = '';
						if(data.code == 200){
							$.each(data.data,function(index,item){
								//0=计划，1=创建，2=进行中，3=完成，4=已取消
								var status = "";
								switch(item.activityStatus){
									case "0":
										status = "计划中";
										break;
									case "1":
										status = "创建完";
										break;
									case "2":
										status = "进行中";
										break;
									case "3":
										status = "已完成";
										break;
									case "4":
										status = "已取消";
										break;
									default:
								}
								matchList += '<li id="li'+index+'">'
								+'<a href="editMatch.php?matchId='+item.id_activities+'&openId=<?php echo $openId;?>" class="gridbox">'
								+'<div class="orders-pic">'
								+'<img src="'+item.headerImgUrl+'" alt="">'
								+'</div>'
								+'<div class="grid-1">'
								+'<h5 class="h5-title font-bold">'+item.activityName+'</h5>'
								+'<p>约球时间：'+item.zDate+'('+getWeek(item.zDate)+') '+shortTime(item.startTime)+'-'+shortTime(item.endTime)+'</p>'
								+'<p>约球地点：'+item.pitchAddr+item.pitchCode+'</p>'
								+'<p>球赛状态：<span class="bd-b">'+item.memCunt+'/'+item.capacity*2+'人</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="font-bold">'+status+'</span></p>'
								+'</div>'
								+'</a>'
							// 	+'<div class="goods-btnbox clearfix">'
							// 	+'<strong></strong>'
							// 	+'<a id="btn_delete" href="javascript:;" onclick="quitTeam()" class="btn btn-normal fr">退出球赛</a>'
							// +'</div>'
						+'</li>';
						});
					}
					$("#matchList").html(matchList);
					}
				});
			}

			//退出队伍
			function quitTeam(actmbeId,memberType) {
				if (confirm("您需要退出参赛队伍吗？")) {
					var type = 0;//队友删除
					if(memberType == 'undefined'){
						type = 1;//个人删除;
					}
					$.post("../../servers/match/quitMatch.php",{
						"type":type,
						"openId":'<?php echo $openId;?>',
						"actmbeId":actmbeId
					},function(data){
						if(data.code == 200){
							if (hvname.indexOf("host") > -1) {
								var currNum = $("#currentHostNum").html();
								$("#currentHostNum").html(parseInt(currNum) - 1);
							}
							if (hvname.indexOf("visit") > -1) {
								var currNum = $("#currentVisitNum").html();
								$("#currentVisitNum").html(parseInt(currNum) - 1);
							}
							$("#" + hvname).remove();
						}else{
							alertWarning(data.message,"top");
						}
					},"json");
				}
			}

			//加载我创建的比赛
			function loadMyCreatedMatch(){
				window.location = "myCreatedMatch.php?openId=<?php echo $openId;?>";
			}
		</script>
	</body>
</html>