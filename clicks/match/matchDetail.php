<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>
			加入球赛
		</title>
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
	</head>
	<body>
		<header class="header">
			<h2>
				<span id="headerTitle"></span>
			</h2>
		</header>
		<div class="wrapbox">
			<!-- 比赛基础信息 start -->
			<div class="order-box">
				<div class="order-item clearfix">
					<div class="order-item-key">
						比赛时间：
					</div>
					<div id="matchtime" class="order-item-value red">
					</div>
				</div>
				<div class="order-item clearfix">
					<div class="order-item-key">
						平均战力：
					</div>
					<div class="order-item-value">
						主队：<span id="forcesHostStar">无</span>&nbsp;&nbsp;&nbsp;&nbsp;
						客队：<span id="forcesVisitStar">无</span>
					</div>
				</div>
			</div>
			<!-- 比赛基础信息 end -->
			<!-- 开始 主客队列表页 -->
			<div class="tab-con clearfix" style="background-color: white;">
				<div class="team-bar host-team">
					<div style="margin-left: 5px;">
						主队（
						<span id="currentHostNum">
						</span>）
					</div>
				</div>
				<div class="team-bar guest-team">
					<div style="margin-right:5px;">
						客队（
						<span id="currentVisitNum">
						</span>）
					</div>
				</div>
				<div style="width:47%;float:left;">
					<ul id="hostTeamList" class="com-list">
						<!--主队队员数据列表-->
					</ul>
				</div>
				<div id="teamDivHeight" style="width:6%;float: left;">
					<img src="../../imgs/vs.png" />
				</div>
				<div style="width:47%;float: right;">
					<ul id="visitTeamList" class="com-list">
						<!--客队队员数据列表-->
					</ul>
				</div>
			</div>
			<!-- end  主客队列表页-->
			<!-- 参赛信息栏 -->
			<div class="order-box clearfix">
				<div class="order-item clearfix">
					<label class="pitchRowLabel" style="display: block;float: left;font-size: 15px;">我带表:</label>
					<div class="pitchRowDiv" style="float: left;font-size: 15px;">
						<input type="button" value="-" class="pitchRowBtn" />
						<input id="num" class="pitchRowNum" value="0">
						<input type="button" id="btn-plus" value="+" class="pitchRowBtn" />
						人参加 
					</div>
				</div>
				<div class="order-item clearfix" style="font-size: 15px;">
					请填电话号码
					<input id="userTelNum" class="text-input" placeholder="电话号码" />
				</div>
				<div class="item item-btns">
					<a href="javascript:;" onclick="joinMatch(1)" style="text-align:center;float:left;width:45%;background-color: #00516E;color:white;padding: 5px 0 5px 0;">
						我是主队员
					</a>
					<a href="javascript:;" onclick="joinMatch(2)" style="text-align:center;float:right;width:45%;background-color: #7F0A0C;color:white;padding: 5px 0 5px 0;">
						我是客队员
					</a>
				</div>
			</div>
			<!-- end 参赛信息栏 -->
			<!-- 球队信息留言板 start-->
			<h2 class="h2-title" style="float:left;">
				留言
			</h2>
			<ul id="comments-listboard" class="topic-list" style="float:left;width: 100%;">
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
		<script src="../../js/zepto.min.js" type="text/javascript"></script>
		<script src="../../js/zepto.picLazyLoad.min.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<script src="../../js/home.js" type="text/javascript"></script>
		<script>
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
					$.post("../../servers/common/comment.php",{"openId":"<?php echo isset($_GET['openId']) ? $_GET['openId'] : "";?>",
							"moduleId": <?php echo $_GET['matchId'];?>,
							"content": content,
							"moduleFlag":1 //球赛活动1，单飞营2
						},function(data){
							if (data.code == 200) {
								alertWarning('发表成功', 'top');
								setTimeout(function() {
									location.reload();
								}, 200);
							} else {
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
//组装openID，随时取用
	window.localStorage.setItem('openId','<?php echo isset($_GET['openId']) ? $_GET['openId'] : "";?>');
	//获取活动比赛信息
	$.get("../../servers/match/MatchDetail.php?matchId="+<?php echo $_GET['matchId'];?>,
		function(data) {
			if (data.code == 200) {
				var detailObj = data.data;
				//头部
				$("#headerTitle").html(detailObj.activityName + "-" + detailObj.nickName);
				//比赛时间
				$("#matchtime").html(detailObj.activityCreateTime + " " + detailObj.weekDay);

				$("#userTelNum").val(detailObj.phoneNumber);
				//处理成员数据，分装为主队和客队
				var hostsmember = new Array();
				var visitsmember = new Array();
				var hostforceTotal = 0;//主队战力
				var visitforceTotal = 0;//客队战力
				var hostcount = 0;
				var visitcount = 0;
				$.each(detailObj.member,function(index,item){
					if (item.host_or_guest==1){
						hostsmember.push(item);
						hostforceTotal += parseInt(item.personalLevel);
						hostcount++;
					}else{
						visitsmember.push(item);
						visitforceTotal += parseInt(item.personalLevel);
						visitcount++;
					}
				});
				if(hostcount > 0){
					$("#forcesHostStar").html(buildStar(hostforceTotal/hostcount));//主队
				}
				if(visitcount > 0){
					$("#forcesVisitStar").html(buildStar(visitforceTotal/visitcount));//客队
				}
				//战力自评星型图,四舍五入
				//调节高度
				$("#teamDivHeight").css("line-height", max(hostsmember.length, visitsmember.length) * 65 + "px");
				//主队
				var hostTeamHtml = '';
				$("#currentHostNum").html(hostsmember.length);
				$.each(hostsmember, function(index, item) {
					hostTeamHtml += '<li><a href="#">' + '<div class="li-l-box"><img src="'+item.headerImgUrl+'">' + '</div><div class="li-r-box">' + '<div class="li-r-con">' + '<h5 class="teamInfo">' + item.nickName + '</h5><p>' + '战力' + buildStar(item.personalLevel) + '</p><p>' + '信用' + buildStar(item.creditLevel) + '</p>' + '</div>' + '</div>' + '</a>' + '</li>';
				});
				$("#hostTeamList").html(hostTeamHtml);
				//客队
				var visitTeamHtml = "";
				$("#currentVisitNum").html(visitsmember.length);
				$.each(visitsmember, function(index, item) {
					visitTeamHtml += '<li><a href="#">' + '<div class="li-l-box"><img src="'+item.headerImgUrl+'">' + '</div><div class="li-r-box">' + '<div class="li-r-con">' + '<h5 class="teamInfo">' + item.nickName + '</h5><p>' + '战力' + buildStar(item.personalLevel) + '</p><p>' + '信用' + buildStar(item.creditLevel) + '</p>' + '</div>' + '</div>' + '</a>' + '</li>';
				});
				$("#visitTeamList").html(visitTeamHtml);
				
				//留言评论
				var commentHtml = "";
				$.each(detailObj.comments, function(index,item) {    
					commentHtml+= '<li>'
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
				$("#comments-listboard").html(commentHtml);
			}
		},"json");
	//点击增减参加人数
	$(".pitchRowBtn").on("click", function() {
		var n = $("#num").val();
		var num = parseInt(n);
		if (this.value == "-") {
			if (num - 1 < 0) {
				return
			}
			$("#num").val(num - 1);
		} else {
			$("#num").val(num + 1);
		}
	});
})


//加入比赛
function joinMatch(type) {
	if($("#userTelNum").val() == ""){
		alert("请输入电话号码！");
	}else{
		$.post("../../servers/match/JoinMatch.php",{
				"openId":"<?php echo isset($_GET['openId']) ? $_GET['openId'] : "";?>",
				"userTelNum":$("#userTelNum").val(),
				"type":type,
				"repreNum":$("#num").val(),
				"activeId":<?php echo $_GET['matchId'];?>
			},function(data){
				if(data.code == 200){
					location.reload();
				}
		},"json");

		// var $obj;
		// var hvname;
		// if (type == 1) {
		// 	var currNum = $("#currentHostNum").html();
		// 	$("#currentHostNum").html(parseInt(currNum) + 1);
		// 	$obj = $("#hostTeamList");
		// 	hvname = "host_" + (parseInt(currNum) + 1);
		// } else {
		// 	var currNum = $("#currentVisitNum").html();
		// 	$("#currentVisitNum").html(parseInt(currNum) + 1);
		// 	$obj = $("#visitTeamList");
		// 	hvname = "visit_" + (parseInt(currNum) + 1);
		// }
		// var addPlayerHtml = "<li id='" + hvname + "'>" + "<div class=\"li-l-box\">" + "<a href=\"javascript:;\" onclick=\"javascript:quitTeam('" + hvname + "')\">" + "<img src=\"../../imgs/deleteRole.png\" class=\"del-user\">" + "</a>" + "<img src=\"../../imgs/teamAvatar.jpg\">" + "</div>" + "<a href='#'><div class=\"li-r-box\">" + "<div class=\"li-r-con\">" + "<h5 class=\"teamInfo\">豇豆的队友</h5>" + "<p>战力 无数据</p>" + "<p>信用 无数据</p>" + "</div>" + "</div>" + "</a>" + "</li>";
		// $obj.append(addPlayerHtml);
	}
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
		return "：无数据";
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