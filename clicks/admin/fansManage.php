<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>会员信息</title>
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
			<h2><span>关注会员(<span id="userCountNum"></span>)</span></h2>
		</header>
		<nav>
			<input type="text" placeholder="请输入会员微信号/电话号/" id="searchKey"/>
			<input type="button" class="search-btn">
		</nav>
		<div class="wrapbox">
			<div id="userList" class="tab-con">
					<!--开放球赛列表-->
			</div>
			<!-- 加载页面底部菜单-->
			<?php include "../bottom.php"; ?>
			<!-- 加载页面底部版权信息 -->
			<?php include "../footer.php"; ?>
		</div>
		<script>
			<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : null;
			?>
			
			$(function(){
				 //异步加载公开比赛信息列表
				 loadUserLists(0,"");
				 //查询用户
				 searchFans();
			});


			function loadUserLists(page,keyword){
				$.post("../../servers/admins/FansList.php",
				 	{"page":page,
				 	 "keyword":keyword
				 	},function(data){
				 	if(data.code==200){
				 		var fansHtml = "";
				 		fansHtml = '<ul  class="fans-list-ul">';
				 		$.each(data.data.userData, function(index,item) { 
				 			var phoneNumber = item.phoneNumber;
				 			if(item.phoneNumber == null || item.phoneNumber == "null"){
				 				phoneNumber = "";
				 			}
				 			fansHtml += '<li id="li_'+(item.id)+'" class="bottom-border gridbox">'
							+'<div class="orders-pic"><img class="pitchsavatar" src="'+item.headerImgUrl+'" alt=""></div>'
							+'<div class="grid-1"><h2 class="h2-title">'+item.nickName
							+'<a href="fansDetail.php?fansId='+item.id+'" style="display:block;float:right;margin-right:10px">查看</a></h2><h3 class="h3-title">电话：<a href="tel:'+phoneNumber+'">'+phoneNumber+'</a></h3>'
							+'<p>注册时间：'+shortDate(item.regTime)+'</p>'
							+'<p>战力：'+buildStar(item.personalLevel)+'&nbsp;&nbsp;信用评级：'+item.creditLevel+'</p></div></li>';
				 		});
				 		fansHtml += '</ul>';
				 		if(data.data.userCount > 10){
				 			fansHtml += '<div class="clearfix" id="viewmore"><a href="javascript:;" class="btn btn-showmore" id="showmore">查看更多</a></div>'
				 		}
				 		$('#userCountNum').html(data.data.userCount);
				 		$('#userList').html(fansHtml);
				 	}
				 },"json");
			}

			function searchFans(){
				$(".search-btn").on("click",function(){
					loadUserLists(0,$("#searchKey").val());
				})
			}

			function buildStar(forces) {
				var starHtml = "";
				if(forces == ""){
					return "无数据";
				}else{
					for (var i = 0; i < Math.round(forces); i++) {
						starHtml += "<i style='color:red;'>★</i>";
					}
					for(var j = 0; j < (5 - Math.round(forces)); j++){
						starHtml += "<i>★</i>";
					}
					return starHtml;
				}
			}
		</script>
	</body>
</html>