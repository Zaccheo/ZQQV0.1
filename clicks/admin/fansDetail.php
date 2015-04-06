<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
	<title>会员信息</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" type="text/css" href="../../css/common.css">
		<link rel="stylesheet" type="text/css" href="../../css/index.css">
		<link rel="stylesheet" type="text/css" href="../../css/user_info.css">
		<?php 
		    $openId = isset($_GET['openId']) ? $_GET['openId'] : null;
		?>
</head>

<body>
	<header>
  		<div>
  			<span class="logo-com" style="background-image:url(../../imgs/teamAvatar.jpg)">
  			</span>
  		</div>
  		<h1 id="userName"></h1>
  		<h2>排名:29/200</h2>
  		<h2>胜：<span id="winCount"></span>场、平：<span id="leverageCount"></span>场、败：<span id="failCount"></span>场</h2>
  		<h2>战力：<span id="userForces"></span>，积分：<span id="credits"></span></h2>
	</header>
	<div class="warp1rem">
		<section>
	  		<h1>会员卡号：<span id="vipcard"></span></h1>
	  		
	  	</section>
	  	<section>
	  		<h1>会员余额：<span id="remainAmount"></span></h1>
	  	</section>
	  	<section>
	  		<h3>会员充值：</h3>
	  		<p>
	  			<input type="number" style="padding-left:10px;" class="text-input" id="charge" value=""/>元
	    	</p>
	  	</section>
		<section>
	    	<h1>联系电话：<span id="userPhoneNUm"></span></h1>
	    	
	  	</section>
	  	<section>
	  		<h3>擅长位置：</h3>
	  		<p>
	  		<input type="checkbox" value="MF" name="skilledPosition"/>中场、
	  		<input type="checkbox" value="GD" name="skilledPosition"/>后卫、
	  		<input type="checkbox" value="FW" name="skilledPosition"/>前锋、
	  		<input type="checkbox" value="DK" name="skilledPosition"/>门卫
	  		</p>
	  	</section>
	  	<section>
	  		<h2>注册时间：<span id="regTime"></span></h2>
	  	</section>
  	</div>
  	<div class="order-item clearfix">
		<div class="item item-btns">
			<a id="saveUserInfo" class="btn-login" href="javascript:;">充值或提现</a>
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
			var charge = $("#charge").val();
			if(!isNaN(charge)){
				//数字
				if(charge>0){
					if(confirm("您确定要给该用户充值："+charge+"元")){
						chargeUpdate(charge,0);
					}
				}else{
					if(confirm("您确定要给该用户提现："+charge+"元")){
						chargeUpdate(Math.abs(charge),1);
					}
				}
			}else{
				alertWarning("请输入正确的数字！","top");
			}
		});

		//加载用户数据
		loadUserInfo();
	});

	//余额更新,amnt操作金额, 0=向账户充值 1=从账户提现(比如退钱)
	function chargeUpdate(amnt,flag){
		$(".btn-login").addClass("btn-disable");
		$.post("../../servers/admins/Recharge.php",{
			"openId":'<?php echo $openId;?>',
			"amnt":amnt,
			"flag":flag
		},function(data){
			if(data.code == 200){
				alertSuccess(data.message,"top");
				setTimeout(function() {
					location.reload();
				}, 200);
			}else{
				alertWarning(data.message,"top");
				$(".btn-login").removeClass("btn-disable");
			}
		},"json");
	}

	//加载用户数据
	function loadUserInfo(){
		$.post("../../servers/user/userInfo.php",{
			"openId":'<?php echo $openId;?>'
		},function(data){
			if(data.code == 200){
				var user = data.data;
				$("#userName").html(user.nickName);
				$(".logo-com").css("background-image","url("+user.headerImgUrl+")");
				$("#userForces").html(buildStar(user.personalLevel));
				$("#vipcard").html(user.cardID);
				$("#winCount").html(user.winCount);
				$("#leverageCount").html(user.leverageCount);
				$("#failCount").html(user.failCount);
				$("#credits").html(user.credits);
				$("#remainAmount").html(user.charge);
				var userPhone = user.phoneNumber ? user.phoneNumber : "";
				$("#userPhoneNUm").html('<a href="tel:'+userPhone+'">'+userPhone+'</a>');
				$("#regTime").html(user.regTime);
				//设置用户的擅长位置
				if(user.skilledPosition !=null && user.skilledPosition != ""){
					var skills = user.skilledPosition.split(",");
					$.each(skills,function(index,item){
						$("input[name=skilledPosition][value='"+item+"']").attr('checked','true');
					});
				}
			}else{
				alertWarning(data.message, 'top');
			}
		},"json");
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