<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>单飞席添加</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="../../css/common.css" />
		<link rel="stylesheet" href="../../css/style.css" />
		<link rel="stylesheet" href="../../css/index.css" />

		<!--日期依赖css begin-->
		<link rel="stylesheet" href="../../imgs/gmu/widget/calendar/calendar.css" />
		<link rel="stylesheet" href="../../imgs/gmu/widget/calendar/calendar.default.css" />
		<link rel="stylesheet" href="../../css/gmu/widget/dialog/dialog.css" />
		<link rel="stylesheet" href="../../css/gmu/widget/dialog/dialog.default.css" />
		<!--日期依赖css end-->
		<style type="text/css">
			input:-webkit-autofill,
			input:-webkit-autofill:hover,
			input:-webkit-autofill:focus {
				box-shadow: 0 0 0 60px #fff inset;
				-webkit-text-fill-color: #333;
			}
		</style>
		<script src="../../js/zepto.js" type="text/javascript"></script>
		<script type="text/javascript" src="../../js/gmu/core/gmu.js"></script>
		<script type="text/javascript" src="../../js/gmu/core/event.js"></script>
		<script type="text/javascript" src="../../js/gmu/core/widget.js"></script>
		<script type="text/javascript" src="../../js/gmu/extend/parseTpl.js"></script>
		<script type="text/javascript" src="../../js/gmu/extend/touch.js"></script>
		<script type="text/javascript" src="../../js/gmu/extend/highlight.js"></script>
		<script type="text/javascript" src="../../js/gmu/widget/calendar/calendar.js"></script>
		<script type="text/javascript" src="../../js/gmu/widget/dialog/dialog.js"></script>
		<script type="text/javascript" src="../../js/gmu/widget/dialog/$position.js"></script>
		
		<script src="../../js/wxcheck.js" type="text/javascript" ></script>
		<script src="../../js/zepto.picLazyLoad.min.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<script src="../../js/home.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="wrapbox">
			<header class="header">
				<h2>创建单飞席</h2>
			</header>
			<!-- 比赛基础信息 start -->
			<div class="order-box">
				<div class="order-item clearfix">
					<div class="order-item-key">
						单飞席日期：
					</div>
					<div class="order-item-value">
						<input class="date-input" id="soloDate" placeholder="单飞日期" />
					</div>
				</div>
				<div class="order-item clearfix">
					<div class="order-item-key">
						开始时间：
					</div>
					<div class="order-item-value">
					<input class="time-input" id="soloStartTime" type="time" placeholder="开始时间" value="09:00"/>
					</div>			
				</div>
				<div class="order-item clearfix">
					<div class="order-item-key">
						结束时间：
					</div>
					<div class="order-item-value">
					<input class="time-input" id="soloEndTime" type="time" placeholder="结束时间" value="22:30"/>
					</div>			
				</div>
				<!--<div class="order-item clearfix">
					<div class="order-item-key">
						球赛活动：
					</div>
					<div class="order-item-value red">
						<input class="text-input" id="pickMatch" placeholder="选择球赛活动" />
					</div>
				</div>-->
				<div class="pitch-tel-num clearfix">
					<label class="pitchRowLabel" style="display: block;float: left;">单飞预计需要:</label>
					<div class="pitchRowDiv" style="float: left;font-size: 15px;">
						<input type="button" value="-" class="pitchRowBtn" />
						<input id="num" class="pitchRowNum" value="0">
						<input type="button" id="btn-plus" value="+" class="pitchRowBtn" />
						人 
					</div>
				</div>
			</div>
			<div class="order-box clearfix">
				<div class="order-item clearfix">
					<div class="item item-btns">
						<a id="createSoloPlace" class="btn-login " href="javascript:;">创建单飞席
						</a>
					</div>
				</div>
			</div>
		</div>
		
		<!--日期控件 start-->
		<div id="datepicker" style="display:none"></div>
		<!--日期控件 end-->

		<!--加载页面底部版权信息-->
		<?php include "../footer.php";?>
		<!-- main wrap end-->
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : null;?>
		<script>
		var openId = '<?php echo $openId;?>';

		$(function() {
			var today = new Date();
            //设置开始时间为今天
            $('#soloDate')[0].value=$.calendar.formatDate(today);

			$('#datepicker').calendar({//初始化开始时间的datepicker
                date:$('#soloDate')[0].value,//设置初始日期为文本内容
                minDate: $.calendar.formatDate(today),//设置最小日期为当月第一天，既上一月的不能选
                //maxDate: $('#eDate')[0].value,//设置最大日期为结束日期，结束日期以后的天不能选
                swipeable:true,//设置是否可以通过左右滑动手势来切换日历
                select: function(e, date, dateStr){
                    //收起datepicker
                    $('#datepicker').dialog('close');
                    //把所选日期赋值给文本
                    $('#soloDate')[0].value=dateStr;
                }
            });

            $('#soloDate').click(function(e){//展开或收起日期
            	$('#datepicker').dialog('open');
            });

            //选择一场球赛
            // $("#pickMatch").on("click",function(){

            // });
			
			//点击增减参加人数
			$(".pitchRowBtn").on("click", function() {
				var n = $("#num").val();
				var num = parseInt(n);
				if (this.value == "-") {
					if (num - 1 < 0) {return}
					$("#num").val(num - 1);
				} else {
					$("#num").val(num + 1);
				}
			});


			//创建单飞席位信息
			$("#createSoloPlace").on("click",function(){
				if($("#soloStartTime").val() == ""){
					alert("请输入开始时间！");
					return;
				}else if($("#soloEndTime").val() == ""){
					alert("请输入结束时间！");
					return;
				}else if($("#soloStartTime").val() >= $("#soloEndTime").val()){
					alert("开始时间不能小于或等于结束时间！");
					return;
				}else if($("#num").val() == 0){
					alert("您没有选择需求人员数量！");
					return;
				}
				$.post("../../servers/solo/soloCreate.php",
					{"openId":openId,
					"soloDate":$("#soloDate").val(),
					"soloStime":$("#soloStartTime").val(),
					"soloEtime":$("#soloEndTime").val(),
					"numberWanted":$("#num").val()},
					function(data){
						if(data.code == 200){
							alertWarning("创建成功！","mid");
							setTimeout(function() {
								window.location = "soloManage.php?openId="+openId;
							}, 200);
							
						}else{
							alertWarning('创建失败，请稍后再试！', 'top');
							setTimeout(function() {
								location.reload();
							}, 200);
						}
				},"json");
			});
		});
	
	</script>
	<script type="text/javascript">
		    //setup模式
		$('#datepicker').dialog({
		    autoOpen: false,
		    closeBtn: false,
		    buttons: {
		        '关闭': function(){
		            this.close();
		        },
		    }
		}).dialog('this')._options['_wrap'].addClass('login-dialog');	
	</script>
</body>
</html>