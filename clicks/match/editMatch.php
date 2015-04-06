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
		
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : null;?>
	</head>
	<body>
		<header class="header">
			<h2>
				<span id="headerTitle"></span><span id="headerCreator"></span>
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
						竞技强度：
					</div>
					<div id="forcesStar" class="order-item-value">
						
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
				
			</div>
			<div class="placeBlock-10 bg-gray"></div>
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
		<script src="../../js/wxcheck.js" type="text/javascript" ></script>
		<script src="../../js/zepto.min.js" type="text/javascript"></script>
		<script src="../../js/zepto.picLazyLoad.min.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<script src="../../js/home.js" type="text/javascript"></script>
		<script type="text/javascript">
			var url = window.location.href;
				url = url.substring(0,url.indexOf("&"));
				url = url.replace("editMatch","matchDetail");
				var dataForWeixin = {
					title: $("#headerTitle").html(), // 分享标题
	        		desc: $("#matchtime").html(), // 分享描述
	        		link: url, // 分享链接
	        		imgUrl: 'http://www.xishuma.com/fb55/imgs/55.jpg', // 分享图标
	        		type: '', // 分享类型，默认为链接
	        		dataUrl: ''
				};
		</script>
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
							"moduleId": <?php echo $_GET['matchId'];?>,
							"content": content,
							"moduleFlag":1 //球赛活动1，单飞营2
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
	//获取活动比赛信息
	$.post("../../servers/match/MatchDetail.php",{
			"matchId":<?php echo $_GET['matchId'];?>,
			"openId":openId
			},function(data) {
			if (data.code == 200) {
				var detailObj = data.data;
				//头部
				$("#headerTitle").html(detailObj.activityName);
				$("#headerCreator").html("-"+detailObj.nickName);
				//处理时间
				var matchtime = detailObj.zDate + "(" + getWeek(detailObj.zDate)+")<p style='font-size:18px;color:red;'>"+shortTime(detailObj.startTime)+"-"+shortTime(detailObj.endTime)+"</p>";
				
				//拼装微信分享数据
				assemblyWxShare(detailObj);

				if(detailObj.activityStatus == 0){
					//计划中的球赛活动
					matchtime = detailObj.activityWantedTime;
				}
				//比赛时间
				$("#matchtime").html(matchtime);

				//填充当前登录人的电话号码
				//$("#userTelNum").val(detailObj.curTelNum);
				$("#forcesStar").html(buildStar(detailObj.activityLevel));//竞技强度
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
				//战力自评星型图,四舍五入
				//调节高度
				$("#teamDivHeight").css("line-height", max(hostsmember.length, visitsmember.length) * 65 + "px");
				//主队
				var hostTeamHtml = '';
				$("#currentHostNum").html(hostsmember.length);
				$.each(hostsmember, function(index, item) {
					var delBtn = '';
					if(item.activitymemberOpenId == openId){
						delBtn += '<a href="javascript:;" onclick="quitTeam(\'host_'+index+'\','+item.id_activity_member+',\''+item.memberType+'\')"><img src="../../imgs/deleteRole.png" class="del-user"></a>';
					}

					hostTeamHtml += '<li id="host_'+index+'">'
					+'<div class="li-l-box">'+delBtn+'<img src="'+item.headerImgUrl+'">' 
					+ '</div><div class="li-r-box"><div class="li-r-con">'
					+ '<h5 class="teamInfo">' + item.nickName + '</h5><p>'
					+ '战力' + buildStar(item.personalLevel) + '</p><p>' 
					+ '信用' + buildStar(item.creditLevel) + '</p>' 
					+ '</div></div></li>';
				});
				$("#hostTeamList").html(hostTeamHtml);
				//客队
				var visitTeamHtml = "";
				$("#currentVisitNum").html(visitsmember.length);
				$.each(visitsmember, function(index, item) {
					var delBtn = '';
					if(item.activitymemberOpenId == openId){
						delBtn += '<a href="javascript:;" onclick="quitTeam(\'visit_'+index+'\','+item.id_activity_member+',\''+item.memberType+'\')"><img src="../../imgs/deleteRole.png" class="del-user"></a>';
					}
					visitTeamHtml += '<li id="visit_'+index+'"><div class="li-l-box">'+delBtn+'<img src="'+item.headerImgUrl+'">' + '</div><div class="li-r-box">' + '<div class="li-r-con">' + '<h5 class="teamInfo">' + item.nickName + '</h5><p>' + '战力' + buildStar(item.personalLevel) + '</p><p>' + '信用' + buildStar(item.creditLevel) 
					+ '</p></div></div></li>';
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
})


//微信拼装方法
function assemblyWxShare(detailObj){
	var wxdesc = detailObj.zDate + "(" + getWeekShort(detailObj.zDate)+")  "+shortTime(detailObj.startTime)+"-"+shortTime(detailObj.endTime);
		if(detailObj.activityStatus == 0){
			//计划中的球赛活动
			wxdesc = detailObj.activityWantedTime;
		}
		var wxheader = detailObj.activityName;
		//获取是否要对手,1允许对手报名，0不允许
		if(detailObj.oppWanted == "1"){
			wxheader += "【约对手】";
		}
		//是否要约单飞，0不约，1要约
		if(detailObj.soloWanted == "1"){
			wxheader += "【约单飞】";
		}
		dataForWeixin.title = wxheader;
		dataForWeixin.desc = "竞技强度：" + buildBlackStar(detailObj.activityLevel) +"  "+ wxdesc +"， ●"+detailObj.capacity + "人制， ●"+detailObj.pitchCode;
		dataForWeixin.imgUrl = detailObj.headerImgUrl;
}

//退出队伍
function quitTeam(hvname,actmbeId,memberType) {
	if (confirm("您需要退出参赛队伍吗？")) {
		var type = 0;//队友删除
		if(memberType == 'undefined'){
			type = 1;//个人删除;
		}
		$.post("../../servers/match/quitMatch.php",{
			"type":type,
			"openId":openId,
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
	<script type="text/javascript">
		var wxconfig = <?php require_once('weixin/wxjsconfig.php'); echo $wxconJson;?>;
	</script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
	<script src="../../js/share.js" type="text/javascript"></script>
	</body>
</html>