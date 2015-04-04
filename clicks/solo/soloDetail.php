<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>单飞席</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="../../css/common.css" />
		<link rel="stylesheet" href="../../css/style.css" />
		<link rel="stylesheet" href="../../css/index.css" />
		<style type="text/css">
			input:-webkit-autofill,
			input:-webkit-autofill:hover,
			input:-webkit-autofill:focus {
				box-shadow: 0 0 0 60px #fff inset;
				-webkit-text-fill-color: #333;
			}
		</style>
		
		<script src="../../js/wxcheck.js" type="text/javascript" ></script>
		<script src="../../js/zepto.min.js" type="text/javascript"></script>
		<script src="../../js/zepto.picLazyLoad.min.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<script src="../../js/fastclick.js" type="text/javascript"></script>
		<script src="../../js/home.js" type="text/javascript"></script>
	</head>
	<body>
		<header class="header">
		   <h2>加入单飞</h2>
		</header>
		<div class="wrapbox">
			<!-- 比赛基础信息 start -->
			<div class="order-box">
				<div class="order-item clearfix">
					<div class="order-item-key">
						单飞席信息：
					</div>
					<div id="soloDateInfo" class="order-item-value red">
						
					</div>
				</div>
				<div class="order-item clearfix">
					<div class="order-item-key">
						活动发起人：
					</div>
					<div id="soloCreator" class="order-item-value">
						
					</div>
				</div>
				<div class="order-item clearfix">
					<div class="order-item-key">
						单飞预计要：
					</div>
					<div id="soloWantedNum" class="order-item-value red">
						
					</div>
				</div>
			</div>
			<!-- 参赛信息栏 -->
			<div class="order-box clearfix">
				<div class="pitch-tel-num-last clearfix" style="font-size: 15px;">
					请填电话号码
					<input id="userTelNum" class="text-input" placeholder="电话号码" />
				</div>
				<div class="order-item clearfix">
					<div class="item item-btns">
						<a id="joinSoloMatch" class="btn-login " href="javascript:;">加入单飞匹配</a>
					</div>
				</div>
			</div>
			<!--详细信息-->
			<div class="tab-con" style="background-color: white;">
				<ul id="soloUserList" class="com-list">
					
				</ul>
			</div>
			<!-- end 参赛信息栏 -->
			<!-- 球队信息留言板 start-->
			<h2 class="h2-title" style="float:left;">
				留言
			</h2>
			<ul id="soloComments" class="topic-list" style="float:left;width: 100%;">
				<!--
                	留言板
                -->
			</ul>
			<!-- 球队信息留言板 end-->
		</div>
		<div class="fix-box bd-t" id="cmtBox">
			<div class="footCont ">
				<div class="btn-info">
					<span class="close">取消</span>
					<span class="btn-send">发表</span>
				</div>
			</div>
			<div class="cmt-input">
				<div class="textarea-holder">
					<textarea class="cmtTextArea" type="text" placeholder="发表留言" id="emojiInput"></textarea>															
				</div>
			</div>
		</div>
		<br>
		<div style="float: left;width: 100%;">
			<div class="footer">
				<p class="f-text1">
					Copyright © 2014－2015四川誉合誉科技版权所有
				</p>
				<p class="f-text2">
				</p>
			</div>
		</div>
		<!-- main wrap end-->
		<?php 
			$openId = isset($_GET['openId']) ? $_GET['openId'] : null;
			$soloid = isset($_GET['soloid']) ? $_GET['soloid'] : null;
		?>
		<script>
		var openId = '<?php echo $openId;?>';

		var myComment = new Comment({
			cmtBox: $("#cmtBox"),
			hideAry: [$("#header")],
			sendCallback: function() {
				var content = $(".cmtTextArea").val();
				if( content.length < 5){
					alertWarning('兄弟，多说两句话撒！','top');
				}else if (content.length > 140) {
					alertWarning('评论内容不能超过140个字', 'top');
				} else {
					$.post("../../servers/common/comment.php",{
							"openId":openId,
							"moduleId": <?php echo $soloid;?>,
							"content": content,
							"moduleFlag":2 //球赛活动1，单飞营2
						},function(data){
							if (data.code == 200) {
								alertWarning('发表成功', 'top');
								setTimeout(function() {
									location.reload();
								}, 200);
							} else if(data.code == 204){
								alertWarning(data.message, 'top');
							} else{
								alertWarning('系统繁忙', 'top');
							}
					},"json");
				}
			},
			warnning: function(_str) {
				alertWarning('内容输入有误', 'top');
			},
			isLogin: true,
			loginFn: function() {
				var url = "";
				url = "" + encodeURIComponent(url);
				window.location.href = url;
			}
		})

	$(function() {
		new FastClick(document.body);
		//参加
		$("#joinSoloMatch").on("click",function(){
			if(confirm("是否加入单飞匹配席？")){
				joinSoloMatch();
			}
		});
		//获取活动比赛信息
		$.post("../../servers/solo/soloDetail.php",{
			"soloid":<?php echo $soloid;?>,
			"type":1
			},function(data) {
			if (data && data.code == 200) {
				var soloDetail = data.data.soloDetail;
				var soloMember = data.data.soloMember;
				//加载时间
				$("#soloDateInfo").html(soloDetail.soloDate+'('+getWeek(soloDetail.soloDate)+')<br>'+shortTime(soloDetail.soloStartTime)+'-'+shortTime(soloDetail.soloEndTime));
				//活动发起人
				$("#soloCreator").html(soloDetail.nickName);
				//单飞需求人数
				$("#soloWantedNum").html((soloMember?soloMember.length:0)+'/'+soloDetail.numberWanted+'人');

				if(soloMember){
					var soloUserHtml = '';
					$.each(soloMember,function(index,item){
						soloUserHtml+='<li class="clearfix">'
						+'<a class="detial-a" href="javascript:;">'
							+'<div class="li-l-box">'
								+'<img src="'+item.headerImgUrl+'">'
							+'</div>'
							+'<div class="li-r-box">'
								+'<div class="li-r-con" style="height: 53px;">'
									+'<div class="li-r-con-left">'
										+'<h5 class="teamInfo">'+item.nickName+'(100分)</h5>'
										+'<p>战力'+buildStar(item.personalLevel)+'</p>'
										+'<p>信用'+buildStar(item.creditLevel)+'</p>'
									+'</div>'
									+'<div class="li-r-con-right">'
										+'<h6 class="h6-title">暂未匹配</h6>'
										+'<p>规模：无</p>'
										+'<p>时间：无</p>'
									+'</div>'
								+'</div>'
							+'</div>'
						+'</a>'
					+'</li>';
					});
					$("#soloUserList").html(soloUserHtml);
				}
				var soloComments = data.data.soloComment;
				//加载评论
				if(soloComments){
					var soloCommentHtml = '';
					$.each(soloComments,function(index,item){
						soloCommentHtml+= '<li>'
							+'<div class="tpc-headbox">'
								+'<img src="'+item.headerImgUrl+'">'
							+'</div>'
							+'<div class="tpc-main">'
								+'<h5 class="h5-title">'+item.nickName+'</h5>'
								+'<p class="tp-time">'
									+item.msgDateTime
								+'</p>'
								+'<p id="topicContent">'
									+item.msgContent
								+'</p>'
							+'</div>'
						+'</li>';
					});
					$("#soloComments").html(soloCommentHtml);
				}
			}
		},"json");
	})


//加入比赛
function joinSoloMatch(type) {
	$.post("../../servers/solo/soloJoin.php",{
			"openId":openId,
			"soloid":<?php echo $soloid;?>,
			"userTelNum":$("#userTelNum").val()
		},function(data){
			if(data.code == 200){
				alertWarning("加入成功！","mid");
				setTimeout(function() {
					location.reload();
				}, 200);		
			}else if(data.code == 201){
				alertWarning('加入失败，您不能重复加入！', 'top');
			}else{
				alertWarning('加入失败，系统忙，请稍后再试！', 'top');
			}
	},"json");
	// }
}

function quitTeam(hvname) {
	if (confirm("您需要退出参赛队伍吗？")) {
		if (hvname.indexOf("host") > -1) {
			var currNum = $("#currentHostNum").html();
			$("#currentHostNum").html(parseInt(currNum) - 1);
		}
		if (hvname.indexOf("visit") > -1) {
			var currNum = $("#currentVisitNum").html();
			$("#currentVisitNum").html(parseInt(currNum) - 1);
		}
		$("#" + hvname).remove();
	}
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
	
//取大的数据
function max(a, b) {
	return a >= b ? a : b;
}

</script>
	</body>
</html>