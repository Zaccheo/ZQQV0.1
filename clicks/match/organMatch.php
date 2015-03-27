<!DOCTYPE html>
<html>
	<head>
		<meta name="author" content="yuheyu" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta charset="utf-8">
		<title>足球圈</title>
		<link rel="stylesheet" href="../../css/modal.css" />
		<link rel="stylesheet" href="../../css/common.css">
		<link rel="stylesheet" href="../../css/style.css">
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
		<div class="wrapper">
			<div class="slide-main base-layer">
				<header class="header">
					<h2>创建球赛</h2>
				</header>
					<div class="title-box">
						<h5>请创建一个球赛活动名称</h5>
						<div class="dice-btn">
							<input placeholder="请填写名字或摇骰子随机产生" style="width:80%; height:30px;" type="text" id="matchName" />
							<a id="dice" onclick="getRandomName()" class="dice-img"></a>
						</div>
					</div>
					<div class="placeBlock-10 bg-gray"></div>
					<div class="title-box">
						<h5>请预约一个场地</h5>
						<input class="text-input" id="selectPitch" onfocus="blur()" placeholder="点击选择一个场地" />
					</div>
					<div class="title-box" style="display: block;">
						<h5>或手动输入一个时间段</h5>
						<input class="text-input" id="scaleByHand" placeholder="手动填写" />
					</div>
					<div class="placeBlock-10 bg-gray"></div>
					<div class="pitchListDiv">
						<div class="checkboxFive">
							<input type="checkbox" value="0" id="checkboxFiveInput" name="getRival" />
							<label for="checkboxFiveInput"></label>
						</div>
						<input type="hidden" id="selectPitchId"/>
						<span style="margin-left: 2px;">约对手</span>
						<label class="pitchRowLabel">我带</label>
						<div class="pitchRowDiv">
							<input type="button" value="-" class="pitchRowBtn" />
							<input id="mymatenum" class="pitchRowNum" value="0">
							<input type="button" id="btn-plus" value="+" class="pitchRowBtn" /> 人参加
						</div>
					</div>
					<div class="title-box">
						<label>请留您的电话号码以确认预定信息</label>
						<input type="text" class="text-input" id="creatorTelNum"/>
					</div>
					<div class="pitchListDiv">
						战力自评：
						<ul class="pitchStarUl">
							<li>★</li>
							<li>★</li>
							<li>★</li>
							<li>★</li>
							<li>★</li>
						</ul>
					</div>
					<div class="item item-btns">
						<a id="matchCreateBtn" class="btn-login " href="javascript:;">创建活动</a>
					</div>
			</div>
			<div class="footer">
				<p class="f-text1">Copyright © 2014－2015四川誉合誉科技版权所有</p>
				<p class="f-text2">成都5+5足球俱乐部</p>
			</div>
		</div>
		<!-- 模态对话框的内容 -->
		<div id="pitch-modal-data">
			<div class="modal-header">请先选择时间</div>
			<div class="modal-body">
				<ul id="avaliablePitchs">
					<!--
                    		场地预约时间选择窗口
                    -->
				</ul>
			</div>
			<div class="modal-footer">
				<h5>可提前预定一周以内的球场</h5>
				<h6>点击时间，进入球场预约操作</h6>
				[<a href="#" class="modal-close" >关闭</a>]
			</div>
		</div>
		<script type="text/javascript" src="../../js/zepto.min.js"></script>
		<script type="text/javascript" src="../../js/zepto.modal.min.js"></script>
		<script type="text/javascript" src="../../js/proTools.js"></script>
		<script>
			var data = ["国家德比",
				"皇家马德里",
				"巴塞罗那",
				"顿涅茨克矿工",
				"北京国安",
				"四川全兴",
				"拜仁慕尼黑",
				"博卡青年",
				"克鲁嫩塞罗",
				"马德里竞技",
				"尤文图斯",
				"首尔FC",
				"全北现代",
				"广州恒大",
				"巴黎圣日耳曼",
				"曼彻斯特联队",
				"阿森纳"
			];
			
			$(function() {
					//组装openID，随时取用
					window.localStorage.setItem('openId','o5896s_Gge1x6UA_3bCsj9AK7kOI');
					//获取当前可预约的时间列表信息
					$.getJSON('../../servers/pitch/pitchTimeSelect.php',function(data){
						if(data.code == 200){
							var selectPitchHtml = "";
							$.each(data.data, function(index,item) {  
								var pweek = getWeek(item.zDate);
								selectPitchHtml+='<li><a href="../pitchsvr/selectPitchs.php?pid='+item.id+'&pdate='+item.zDate+'&pweek='+pweek+'">'+item.zDate+'('+pweek+')</a></li>';
							});
							$('#avaliablePitchs').html(selectPitchHtml);
						}
					});
					/*选择预约场地，弹出窗*/
					$('#selectPitch').on('click', function() {
						var modalObj = $('#pitch-modal-data').modal({
							overlayClose: true, // 当点击模态对话框外的区域时，是否自动关闭模态对话框
							close: true, // 是否在模态对话框上显示关闭close元素
							containerCss: {
								width: '300px', // 重新 指定模态对话框的宽度
								height: '400px',
								overlayClose: true
							}
						});
						return false;
					})
					
					//预约场地回传数据
					if(window.localStorage && window.localStorage.getItem("selpitch")){
						$("#selectPitch").val(window.localStorage.getItem("selpitch"));
						$("#selectPitchId").val(window.localStorage.getItem("pitchOrderId"));
						window.localStorage.removeItem("selpitch");
						window.localStorage.removeItem("pitchOrderId");
					}
					
					//加减控件
					$(".pitchRowBtn").on("click", function() {
						var n = $("#mymatenum").val();
						var num = parseInt(n);
						if (this.value == "-") {
							if (num - 1 < 0) {
								return
							}
							$("#mymatenum").val(num - 1);
						} else {
							$("#mymatenum").val(num + 1);
						}
					});
					$(".pitchRowLabel").hide();
					$(".pitchRowDiv").hide();
					/*选择约对手选项*/
					$('#checkboxFiveInput').live('change', function() { 
						if ($('#checkboxFiveInput').is(":checked")) {
							$(".pitchRowLabel").show();
							$(".pitchRowDiv").show();    
						} else {      
							$(".pitchRowLabel").hide();
							$(".pitchRowDiv").hide();    
						}
					});
					$(".pitchStarUl li").live("click", function() {
						if ($(this).hasClass('forceStarRed')) {
							$(".pitchStarUl li").removeClass('forceStarRed');
						} else {
							var _thisI = $(this).index();
							$(".pitchStarUl li").each(function() {
								if ($(this).index() <= _thisI) {
									$(this).addClass('forceStarRed');
								}
							})
						}
					});
					
					//点击创建活动按钮，提交球赛数据到数据库
					$('#matchCreateBtn').on('click',function(){
						if($('#matchName').val() == ""){
							$('#matchName').parent().css('border-color','brown');
							alert("请掷骰子创建一个活动名字!");
						}
						else if($('#selectPitch').val() == ""){
							$('#selectPitch').css('border-color','brown');
							alert("创建球赛必须选择一个场地!");
						}else if($('#creatorTelNum').val() == ""){
							$('#creatorTelNum').css('border-color','brown');
							alert("请填写您的联系方式，方便管理员与您缺人信息!");
						}else{
							$.post("../../servers/match/MatchCreate.php",{
								"openId":"o5896s_Gge1x6UA_3bCsj9AK7kOI",
								"matchName":$('#matchName').val(),
								"selectPitch":$('#selectPitch').val(),
								"selectPitchId":$('#selectPitchId').val(),
								"scaleByHand":$('#scaleByHand').val(),
								"ifReval":$('#checkboxFiveInput').is(":checked"),
								"mymatenum":$('#mymatenum').val(),
								"creatorTel":$('#creatorTelNum').val(),
								"myforces":$('.forceStarRed').size()},
								function(data){
								if(data.code == 200){
									// $("#matchCreateBtn").
									var secs =3; //倒计时的秒数 
									var URL; 
									for(var i=secs;i>=0;i--){ 
										window.setTimeout(delayJump(i), (secs-i) * 1000);
									}
								}else{
									alert(data.message);
								}
							},"json");
						}
					});
				})

			//延时跳转
			function delayJump(num){
				$("#matchCreateBtn").html(data.message+"将自动返回");
				if(num == 0) { 
					window.location="matchList.php?openId='o5896s_Gge1x6UA_3bCsj9AK7kOI'";
				}
			}
			
			function openSelectPitchs(url){
				window.location.href=url;
			}
			
			//获取随机名字
			function getRandomName() {
				var index = GetRandomNum(0, data.length - 1);
				$("#matchName").val(data[index]);
			}

		</script>
	</body>

</html>