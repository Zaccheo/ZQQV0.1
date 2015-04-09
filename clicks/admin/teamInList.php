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
		<script src="../../js/wxcheck.js" type="text/javascript" ></script>
		<script src="../../js/zepto.min.js" type="text/javascript"></script>
		<script src="../../js/zepto.picLazyLoad.min.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<script src="../../js/home.js" type="text/javascript"></script>
	</head>
	<body>
		<header class="header">
			<h2><span>球赛管理</span></h2>
		</header>
<!-- 		<nav> -->
<!-- 			<input type="text" placeholder="请输入活动名/创建者" id="searchKey"/> -->
<!-- 			<input type="button" class="search-btn"> -->
<!-- 		</nav> -->
		<div class="tabul-box">
            <div class="tabul-div">
                <ul class="tab-ul">
                    <li><a id="typeNoIn" href="javascript:;" class="filterBtn current">待入场</a></li>
                    <li><a id="typeNoSt" href="javascript:;" class="filterBtn">待结算</a></li>
                    <li><a id="typeSttd" href="javascript:;" class="filterBtn">已完结</a></li>
                    <li><a id="typeAll" href="javascript:;" class="filterBtn">全部</a></li>
                </ul>
            </div>
        </div>
	
		<div class="wrapbox">
			
			<div class="tab-con">
				<ul id="openMatchList" class="orders-list myzc-ul">
					<!--开放球赛列表-->
				</ul>
			</div>
			<!-- 加载底部菜单 -->
			<?php include "../bottom.php"; ?>
			<!-- 加载页脚版权 -->
			<?php include "../footer.php"; ?>
		</div>
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : null;?>
		<script>
			
			$(function(){
				
				//loadWaiteMatch(openId);
				//异步加载公开比赛信息列表
				loadSyncOpenList();


				//过滤按钮
				$(".filterBtn").on("click",function(){
					//全部
					if(!$(this).hasClass("current")){
						$(".filterBtn").removeClass("current");
						$(this).addClass("current");
						//异步加载公开比赛信息列表
						loadSyncOpenList();
					}
				});
				
			});
			function loadSyncOpenList(){
				var $loadType = $(".current");
				var loadType = "";
				if($loadType.attr("id") == "typeNoIn"){
					loadType = "noin";//待入场
				}else if($loadType.attr("id") == "typeNoSt"){
					loadType = "nost";//待结算
				}else if($loadType.attr("id") == "typeSttd"){
					loadType = "sttd";//已完结
				}else{
					loadType = "";
				}
 				$.post("../../servers/match/MatchManageList.php",
 					{"loadType":loadType},function(data){
				 	if(data.code==200){
				 		var matchHtml = "";
				 		$.each(data.data, function(index,item) { 
				 			matchHtml += '<li id="li_'+(index+1)+'"><a href="javascript:matchManage('+item.id_activities+','+item.activityStatus+');" class="gridbox">'
							+'<div class="orders-pic"><img class="pitchsavatar" src="'+item.headerImgUrl+'" alt=""></div>'
							+'<div class="grid-1"><h2 class="h2-title">'+item.activityName+"("+item.nickName+")"+'</h2><p>'+item.zDate+"("+getWeek(item.zDate)+")"+shortTime(item.startTime)+"-"+shortTime(item.endTime)+'开战！</p>'
							+'<p>赛制：'+item.capacity+'人制</p><p style="color:red;">状态：'+mapActivityStatus(item.activityStatus)+'</p></div></a></li>';
				 		});
				 		$('#openMatchList').html(matchHtml);
				 	}
				 },"json");
			}
			//活动状态[0=计划，1=创建，2=进行中，3=完成，4=已取消]
		    function mapActivityStatus(key){
			    var retStr = "未知";
		        switch(key){
		            case "0":retStr = "已预约";break;  
    		        case "1":retStr = "等待入场比赛";break;
    		        case "2":retStr = "比赛中...";break;
    		        case "3":retStr = "比赛已结束";break;
    		        case "4":retStr = "已取消";break; 
    		        default:   break;
		        }
		        return retStr;
		    }
		    function matchManage(id_activities,activityStatus){
		        if(activityStatus===1){
			        window.location.href='teamInDetail.php?id_activities='+id_activities+'&openId=<?php echo $openId;?>';
		        }else if(activityStatus===2){
		        	window.location.href='teamOutDetail.php?id_activities='+id_activities+'&openId=<?php echo $openId;?>';
			    }
		    }
		</script>
	</body>
</html>