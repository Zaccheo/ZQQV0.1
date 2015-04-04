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
		<link rel="stylesheet" href="../../css/checkBox.css">
		<style type="text/css">
			input:-webkit-autofill,
			input:-webkit-autofill:hover,
			input:-webkit-autofill:focus {
				box-shadow: 0 0 0 60px #fff inset;
				-webkit-text-fill-color: #333;
			}
		</style>
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : "o5896s_Gge1x6UA_3bCsj9AK7kOI";?>
		<script type="text/javascript" src="../../js/wxcheck.js" ></script>
		<script type="text/javascript" src="../../js/zepto.js"></script>
		<script type="text/javascript" src="../../js/fastclick.js"></script>
		<script type="text/javascript" src="../../js/zepto.modal.min.js"></script>
		<script type="text/javascript" src="../../js/proTools.js"></script>
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
							<a id="dice" class="dice-img"></a>
						</div>
					</div>
					<div class="placeBlock-10 bg-gray"></div>
					<div class="title-box">
						<h5>预约场地(<font style="color:red">或者在下一栏手动填写</font>)</h5>
						<input type="text" class="text-input" id="selectPitch" onfocus="blur()" placeholder="点击选择一个场地" />
					</div>
					<div class="title-box" style="display: block;">
						<h5>或输入时间段</h5>
						<input type="text" class="text-input" id="scaleByHand" placeholder="手动填写时间" />
					</div>
					<div class="title-box">
						<label>请留您的电话号码以确认预定信息</label>
						<input type="text" class="text-input" placeholder="您的电话号码" id="creatorTelNum"/>
					</div>
					<div class="placeBlock-10 bg-gray"></div>
					<div class="pitchInfoPanel">
						<div class="roundedOne">
					      <input type="checkbox" value="None" id="roundedOne" name="roundedOne" />
					      <label for="roundedOne"></label>
					    </div>
						<input type="hidden" id="selectPitchId"/>
						<label for="roundedOne" style="display:block;width:87px;height:25px;font-size:14px;margin:5px 20px 0 5px;">接受队伍挑战</label>
						
						<div class="roundedOne">
					      <input type="checkbox" value="None" id="needSolo" name="needSolo" />
					      <label for="needSolo"></label>
					    </div>
						<label for="needSolo" style="display:block;width:87px;height:25px;font-size:14px;margin:5px 0 0 5px;">接受单飞报名</label>
					</div>
					<div class="pitchListDiv">
						<label class="pitchRowLabel">我带</label>
						<div class="pitchRowDiv">
							<input type="button" value="-" class="pitchRowBtn" />
							<input type="text" id="mymatenum" class="pitchRowNum" value="0">
							<input type="button" id="btn-plus" value="+" class="pitchRowBtn" />
							<label class="pitchRowLabel">人参加</label>
						</div>
					</div>
					<div class="pitchListDiv">
						战力自评：
						<ul id="forceStar">
							<li>★</li>
							<li>★</li>
							<li>★</li>
							<li>★</li>
							<li>★</li>
						</ul>
					</div>
					
					<div class="item item-btns">
						<a id="matchCreateBtn" class="btn-login" href="javascript:;">创建活动</a>
					</div>
			</div>
			<!--页面底部版权信息-->
			<?php include "../footer.php";?>
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
				"阿森纳",
				"屌丝杯",
				"小世界杯",
				"国家德比",
				"世纪大战",
				"小雷米特杯",
				"撸一杯",
				"习大大杯",
				"绿茵杯",
				"足协杯",
				"足联杯"
			];
			
			$(function() {
					new FastClick(document.body);
					//获取当前可预约的时间列表信息
					$.getJSON('../../servers/pitch/pitchTimeSelect.php',function(data){
						if(data.code == 200){
							var selectPitchHtml = "";
							$.each(data.data, function(index,item) {  
								var pweek = getWeek(item.zDate);
								selectPitchHtml+='<li><a href="../pitchsvr/selectPitchs.php?openId=<?php echo $openId;?>&pid='+item.id+'&pdate='+item.zDate+'&pweek='+pweek+'">'+item.zDate+'('+pweek+')</a></li>';
							});
							$('#avaliablePitchs').html(selectPitchHtml);
						}
					});

					$.post('../../servers/pitch/loadUserTel.php',
						{"openId":'<?php echo $openId;?>'},
						function(data){
						if(data.code == 200){
							$('#creatorTelNum').val(data.data.telPhone);
						}
					},"json");
					//随机产生名字
					getRandomName();
					/*绑定筛子随机名字*/
					$("#dice").click(function(){
						getRandomName();
					});	

					/*选择预约场地，弹出窗*/
					$('#selectPitch').on('click', function() {
						$("input[type=text]").each(function(){
							if($(this).val() != ""){
								sessionStorage.setItem($(this).attr("id"),$(this).val());
							}
						});
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
						for (var i=0,len=sessionStorage.length;i<len;i++){     
							var key = sessionStorage.key(i);       
							var value = sessionStorage.getItem(key);
							document.getElementById(key).value = value;
						}
						$("#selectPitch").val(window.localStorage.getItem("selpitch"));
						$("#selectPitchId").val(window.localStorage.getItem("pitchOrderId"));
						window.localStorage.removeItem("selpitch");
						window.localStorage.removeItem("pitchOrderId");
						sessionStorage.clear();
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
					
					$(".pitchListDiv").hide();
					/*选择约对手选项*/
					$('#roundedOne').live('change', function() { 
						if ($('#roundedOne').is(":checked")) {
							$(".pitchListDiv").show();
							
						} else {      
							$(".pitchListDiv").hide();
							
						}
					});
					$("#forceStar li").live("click", function() {
						if ($(this).hasClass('forceStarRed')) {
							$("#forceStar li").removeClass('forceStarRed');
						} else {
							var _thisI = $(this).index();
							$("#forceStar li").each(function() {
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
							alertWarning('请掷骰子创建一个活动名字!','top');
						}else if($('#selectPitch').val() == "" && $('#scaleByHand').val() == ""){
							$('#selectPitch').css('border-color','brown');
							$('#scaleByHand').css('border-color','brown');
							alertWarning('创建球赛必须选择场地或者填写时间!', 'top');
						}else if($('#creatorTelNum').val() == ""){
							$('#creatorTelNum').css('border-color','brown');
							alertWarning('请填写您的联系方式，方便管理员与您缺人信息!', 'top');
						}else if(!isMobile($('#creatorTelNum').val()) && !isTel($('#creatorTelNum').val())){
						 	$('#creatorTelNum').css('border-color','brown');
						 	alertWarning('请填写正确的电话号码!', 'top');
						}else{
							$("#matchCreateBtn").addClass("btn-disable");
							$.post("../../servers/match/MatchCreate.php",{
								"openId":"<?php echo $openId;?>",
								"matchName":$('#matchName').val(),
								"selectPitch":$('#selectPitch').val(),
								"selectPitchId":$('#selectPitchId').val(),
								"scaleByHand":$('#scaleByHand').val(),
								"ifReval":$('#roundedOne').is(":checked"),
								"ifNeedSolo":$('#needSolo').is(":checked"),
								"mymatenum":$('#mymatenum').val(),
								"creatorTel":$('#creatorTelNum').val(),
								"myforces":$('.forceStarRed').size()},
								function(data){
								if(data.code == 200){
									alertSuccess('创建成功');
									setTimeout(function() {
										window.location="matchDetail.php?matchId="+data.data.matchId+"&openId=<?php echo $openId;?>";
									}, 200);
								}else{
									alertWarning('创建失败！'+data.message, 'top');
									$("#matchCreateBtn").removeClass("btn-disable");
								}
							},"json");
						}
					});
				});
			
			//获取随机名字
			function getRandomName() {
				var index = GetRandomNum(0, data.length - 1);
				$("#matchName").val(data[index]);
			}

		</script>
	</body>
</html>