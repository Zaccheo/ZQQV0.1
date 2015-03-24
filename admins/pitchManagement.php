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
<title>球场管理</title>
<script type="text/javascript">
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
</script>
<link
	rel="stylesheet"
	type="text/css"
	href="../css/wei_bind.css"
>
</head>
<body>

 <div class="parentBox" >
    <a href="./addPitch.php">
            添加球场信息
    </a>
 </div>
 <div class="parentBox" >
    <a href="./modifyPitch.php">
             修改球场信息
    </a>
 </div>


<div class="parentBox" >
   <a href="./pitchChargeAdd.php"> 
                     添加球场定价
   </a>
</div>
<div class="parentBox" >
   <a href="./pitchChargeModify.php"> 
                     修改球场定价
   </a>
</div>












</body>
</html>