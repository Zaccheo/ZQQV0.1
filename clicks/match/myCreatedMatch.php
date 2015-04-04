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
				<a href="javascript:;" id="myJoinMatch" class="hd-btn-l">我参与的</a>
				<a href="javascript:;" id="myCreatedMatch" class="hd-btn-r active">我创建的</a>
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
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : null;?>
		<script type="text/javascript">
			
			$(function() {
				goToTop($("#goTop"));

				//第一次加载我创建的球赛
				loadMyCreatedMatch();
				//点击事件，触发页面加载
				$(".hd-btn-l").on("click",function(){
					loadMyJoinMatch();
				});
			});

			//加载我参与的比赛
			function loadMyJoinMatch(){
				window.location = "myJoinMatch.php?openId=<?php echo $openId;?>";
			}

			//加载我创建的比赛
			function loadMyCreatedMatch(){
				$.post("../../servers/match/LoadMyCreateMatch.php",
					{"openId":'<?php echo $openId;?>'},
					function(data){
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
								+'<h5 class="h5-title">'+item.activityName+'</h5>'
								+'<p>约球时间：'+item.zDate+'('+getWeek(item.zDate)+') '+shortTime(item.startTime)+'-'+shortTime(item.endTime)+'</p>'
								+'<p>约球地点：'+item.pitchAddr+item.pitchCode+'</p>'
								+'<p>球赛状态：'+item.memCunt+'/'+item.capacity+'人 '+status+'</p>'
								+'</div>'
								+'</a>'
								+'<div class="goods-btnbox clearfix">'
								+'<strong></strong>'
								+'<a name="btn_delete" href="javascript:;" onclick="dismissMatch('+item.id_activities+')" class="btn btn-normal fr">解散球赛</a>'
							+'</div>'
						+'</li>';
							});
						}
						$("#matchList").html(matchList);
				},"json");
			}

			//解散球赛
			function dismissMatch(actId){
				if(confirm("确认删除活动！删除后无法恢复！")){
					$.post("../../servers/match/dismissMatch.php",
					{"openId":'<?php echo $openId;?>',
					 "actId":actId},
					function(data){
						if(data.code==200){
							alertSuccess('解散成功', 'top');
							setTimeout(function() {
								location.reload();
							}, 200);
						}else{
							alertWarning(data.message, 'top');
						}
					},"json");
				}
			}
		</script>
	</body>
</html>