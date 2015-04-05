<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
	<title>球员信息</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css" href="../../css/common.css">
<link rel="stylesheet" type="text/css" href="../../css/index.css">
<link rel="stylesheet" type="text/css" href="../../css/user_info.css">
<?php 
    $openId = isset($_GET['openId']) ? $_GET['openId'] : "o5896s_Gge1x6UA_3bCsj9AK7kOI";
?>
</head>

<body>
	<header>
  		<div>
  			<span class="logo-com" style="background-image:url(http://wx.qlogo.cn/mmopen/fRcLAzkicIFicexOUYZUxJOsndIqupWx1DiaXDhjHsWGICcQsWH28nlp04IDyJkcSiaLJHIASzFTESBd7AsZ9LUyNXE7Mg5FibgE6/0)">
  			</span>
  		</div>
  		<h1>George</h1>
  		<h2>胜：70场，败：10场</h2>
  		<h2>战力：★★★★★，积分：200</h2>
	</header>
	<div class="warp1rem">
		<section>
	  		<h1>会员卡号：<span id="vipcard"></span></h1>
	  		<h1>会员余额：<span id="charge"></span>元</h1>
	  	</section>
		<section>
	    	<h3>联系电话：</h3>
	    	<p>
	    	<input type="text" class="text-input" style="padding-left:10px" placeholder="您的电话号码" id="userPhoneNUm" value="" />
	    	</p>
	  	</section>
	  	<section>
	  		<h3>擅长位置：</h3>
	  		<p><input type="checkbox"/>中场、后卫、前锋</p>
	  	</section>
	  	
	  	<section>
	  		<h2>注册时间：<span id="regTime"></span></h2>
	  	</section>
  	</div>
  	<div class="order-item clearfix">
		<div class="item item-btns">
			<a id="saveUserInfo" class="btn-login " href="javascript:;">保存个人信息</a>
		</div>
	</div>
	<?php include "../footer.php";?>
</div>
<script type="text/javascript" src="../../js/wxcheck.js"></script>
<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/proTools.js"></script>
<script type="text/javascript">
	
	$(function(){
		$("#saveUserInfo").on("click",function(){
			alert("TODO");
		});


		$.post("../../servers/user/userInfo.php",{
			"openId":'<?php echo $openId;?>'
		},function(data){
			if(data.code == 200){
				var user = data.data;
				$("#vipcard").html(user.cardID);
				$("#charge").html(user.charge);
				$("#userPhoneNUm").val(user.phoneNumber);
				$("#regTime").html(user.regTime);
			}else{
				alertWarning(data.message, 'top');
			}
		},"json");
	});
</script>
</body>
</html>