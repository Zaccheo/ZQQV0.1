<?php
	include_once("/lanewechat/servers/dbutils");
?>
<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
<meta
	http-equiv="Content-Type"
	content="text/html; charset=UTF-8"
>
<meta
	name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"
>
<meta
	content="telephone=no"
	name="format-detection"
/>
<title>个人信息管理</title>
<script src="../../js/zepto.min.js"></script>
<script src="../../js/happy.js"></script>
<script type="text/javascript">
<?php 
    $openId = isset($_GET['openId']) ? $_GET['openId'] : null;
?>
function onBridgeReady(){
	 WeixinJSBridge.call('hideOptionMenu');
	}

	if (typeof WeixinJSBridge == "undefined"){
	    if( document.addEventListener ){
	        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
	    }else if (document.attachEvent){
	        document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
	        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
	    }
	}else{
	    onBridgeReady();
	}
	$(document).ready(function () {
		$.ajax({
	        type:"GET",
	        url:"../../servers/UserInfo.php",
	        dataType:"json",
	        data:{"openId":"<?php echo $openId?>"},
	        success:function(data){
	    	  if(data.code==200){
	    		    $("#cardNumber").html("No."+ data.data.cardID);
	    		    $("#chargeID")[0].value= data.data.charge;
	    		    $("#creditsNumID").html("积分："+data.data.credits);
	    		    $("#regTime")[0].value=data.data.regTime;
	    		    $("#cardUserName").html("会员："+data.data.username);
	    		    $("#userName")[0].value=data.data.username;
	    		    $("#telPhone")[0].value=data.data.phoneNumber;
	    		    $("#openId")[0].value=data.data.weixinNum;
	    	  }else if(data.code==201){
	    		  window.location.href="register.php?openId="+"<?php echo $openId?>";
	    	  }
	            },
	        error:function(xhr,type){
	            //TODO
	        }

	        });
	});
	
</script>
<script type="text/javascript">
$(document).ready(function () {
    $('#formID').isHappy({
       classes:{
    	   field:'unhappy',
    	   message:'tip-bubble tip-bubble-top'
       },
      fields: {
        '#userName': {
        	errorTarget:'#userNameDIV',
          required: true,
          message: '该字段为必须！',
        },
        '#telPhone': {
        	errorTarget:'#telPhoneDIV',
          required: true,
          message: '请填写您11位手机号码',
          test:function(e){
              return /[0-9]{11}/.test(e);
          }
      }
    },
    submitButton:'#saveBtn',
    happy:function(){
        //提交表单
        $.ajax({
            type:"GET",
            url:"../servers/UserEdit.php",
            data: $("#formID").serialize(),
            dataType:"json",
            success:function(data){
               alert(data.message);
               if(data.code==200){
                   //TODO
            	   location.reload();
               }
                                 
            },
            error:function(xhr,type){
                //TODO
                alert("服务器错误！");
                
            }
            });
        
    }
  })
    }
    );
</script>
<link
	rel="stylesheet"
	type="text/css"
	href="../../css/wei_bind.css"
>
</head>

<body>
	<div class="qb_gap pg_upgrade_content">
	<!-- 不可以修改的资料 -->
        <div class="card_preview">
      		<img id="cardBgImg" src="../../imgs/card_bg.png" width="100%" height="100%"></a>
            <span class="card_num" id="cardNumber"></span>
            <span class="card_user_name" id="cardUserName"></span>
            <span class="card_user_credits" id="creditsNumID"></span>
            <span class="card_name">成都5+5足球场VIP会员卡</span>
        </div>
		<!-- 充值金额 -->
		<div
			class="mod_input qb_mb10 qb_flex"
		>
			<label>余额(RMB)：</label> <input 
				value=""
				class="flex_box"
				placeholder=""
				id="chargeID"
				type="text"
				readonly="readonly"
			>
		</div>
			<div
				class="mod_input qb_mb10 qb_flex"
			>
				<label>注册时间：</label> <input id="regTime"
				value=""
				class="flex_box"
				type="text"
				readonly="readonly"
			>
			</div>
			<form id="formID">
			<input type="hidden" id="openId" name="openId" value="<?php echo $openId?>">
			<!-- 可以修改的资料 -->
		 <fieldset>
            <legend>可修改信息</legend>
			       <!-- 姓名 -->
		<div id="userNameDIV"
			class="mod_input qb_mb10 qb_flex"
		>
			<label>姓&nbsp;&nbsp;&nbsp;&nbsp;名：</label> <input 
				value=""
				name="userName"
				class="flex_box"
				placeholder=""
				id="userName"
				type="text"
				required="required"
			>
		</div>
		<!-- 手机号 -->
		<div id="telPhoneDIV"
			class="mod_input qb_mb10 qb_flex"
		>
			<label>手机号码：</label> <input 
				value=""
				name="telPhone"
				class="flex_box"
				placeholder=""
				id="telPhone"
				type="tel"
				required="required"
			>
		</div>
        </fieldset>
        </form>
    <div class="qb_flex qb_mb10">
    	<a href="#" id="saveBtn" class="mod_btn btn_block qb_mb10" style="width:100%">保存</a> 
	</div>
	</div>
</body>
</html>