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
		<script src="../../js/home.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="wrapbox">
			<!-- 比赛基础信息 start -->
			<div class="order-box">
				<div class="order-item clearfix">
					<div class="order-item-key">
						球赛信息：
					</div>
					<div class="order-item-value">
						世界杯比赛(5)
					</div>
				</div>
				<div class="order-item clearfix">
					<div class="order-item-key">
						单飞席信息：
					</div>
					<div class="order-item-value red">
						2015-03-31 (星期二)
					</div>
				</div>
				<div class="order-item clearfix">
					<div class="order-item-key">
						活动发起人：
					</div>
					<div class="order-item-value red">
						George(管理员)
					</div>
				</div>
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
				<div class="pitch-tel-num-last clearfix" style="font-size: 15px;">
					请填电话号码
					<input id="userTelNum" class="text-input" placeholder="电话号码" />
				</div>
				<div class="order-item clearfix">
					<div class="item item-btns">
						<a id="joinSinglePlace" class="btn-login " href="javascript:;">创建单飞席</a>
					</div>
				</div>
			</div>
		</div>
		<!--加载页面底部版权信息-->
		<?php include "../footer.php";?>
		<!-- main wrap end-->
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : null;?>
		<script>
		var openId = '<?php echo $openId;?>';

		$(function() {
			
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
		})

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