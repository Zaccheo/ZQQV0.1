<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
  			<span class="logo-com" style="background-image:url(../../imgs/teamAvatar.jpg)">
  			</span>
  		</div>
  		<h1 id="userName"></h1>
  		<h2>排名:29/200</h2>
  		<h2>胜：<span id="winCount"></span>场、平：<span id="leverageCount"></span>场、败：<span id="failCount"></span>场</h2>
  		<h2>战力：<span id="userForces"></span>&nbsp;&nbsp;&nbsp;&nbsp;积分：<span id="credits"></span></h2>
	</header>
	<div class="warp1rem">
		<section>
	  		<h1>会员卡号：<span id="vipcard"></span></h1>
	  	</section>
	  	<section>
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
			<a id="saveUserInfo" class="btn-login " href="javascript:;">保存个人信息</a>
		</div>
	</div>
	<?php include "../footer.php";?>
</div>
<script type="text/javascript" src="../../js/wxcheck.js"></script>
<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/proTools.js"></script>
<script type="text/javascript">
	//电话号码，旧号码
	var oldTel;
	
	$(function(){
		$("#saveUserInfo").on("click",function(){
			var phoneNumber = $('#userPhoneNUm').val();
			if(phoneNumber == ""){
				alertWarning("电话号码不能为空!","top");
			}else if(!isMobile(phoneNumber) && !isTel(phoneNumber)){
				alertWarning("请填写正确的电话号码!","top");
			}else{
				//封装选择的擅长位置
				var skilledPosition = new Array();
				$('input[name=skilledPosition]').each(function() {
            		if ($(this).attr('checked') ==true) {
            			skilledPosition.push($(this).val());
            		}
        		});
        		$(".btn-login").addClass("btn-disable");
				$.post("../../servers/user/updateUserInfo.php",{
					 "openId":'<?php echo $openId;?>',
					 "phoneNumber":phoneNumber,
					 "skilledPosition":skilledPosition
					},function(data){
						if(data.code == 200){
							alertSuccess(data.message,"top");
							setTimeout(function() {
								location.reload();
							},200);
						}else{
							alertWarning(data.message,"top");
							$(".btn-login").removeClass("btn-disable");
						}
				},"json");
			}
		});

		//加载用户数据
		loadUserInfo();

		
	});


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
				$("#charge").html(user.charge);
				$("#userPhoneNUm").val(user.phoneNumber);
				oldTel = user.phoneNumber;
				$("#regTime").html(user.regTime);
				//设置用户的擅长位置
				if(user.skilledPosition != ""){
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