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
<title>会员账户</title>
<script src="../js/zepto.min.js"></script>
<script src="../js/happy.js"></script>
<link
	rel="stylesheet"
	type="text/css"
	href="../css/wei_bind.css"
>
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
<script type="text/javascript">
//搜索
$(document).ready(function () {
    $('#formID').isHappy({
       classes:{
    	   field:'unhappy',
    	   message:'tip-bubble tip-bubble-top'
       },
      fields: {
        '#key_search': {
          errorTarget:'#key_searchDIV',
          required: true,
          message: '该字段为必须！',
        }
    },
    
    submitButton:'#search',
    happy:function(){
        //提交表单
    	$("#resultDIV")[0].style.display="none";
    	$("#errorDIV")[0].style.display="none";
        $.ajax({
            type:"GET",
            url:"../servers/UserInfo01.php",
            data: $("#formID").serialize(),
            dataType:"json",
            success:function(data){
                if(data.code==200){
            	$("#uid")[0].value=data.data.id;
	        	$("#cardId")[0].textContent = data.data.cardID;
	        	$("#charge")[0].textContent = data.data.charge;
	        	$("#username")[0].textContent = data.data.username;
	        	$("#telphone")[0].textContent = data.data.phoneNumber;
	        	$("#credits")[0].textContent = data.data.credits;
                $("#resultDIV")[0].style.display="";
              }else{
          	    $("#errorDIV")[0].textContent = "没有符合条件的用户！";
            	$("#errorDIV")[0].style.display="";
              }
            },
            error:function(xhr,type){
                //TODO
            }

            });
        
    }
  })
    }
    );
</script>
<script type="text/javascript">
//充值
$(document).ready(function () {
    $('#formID').isHappy({
       classes:{
    	   field:'unhappy',
    	   message:'tip-bubble tip-bubble-top'
       },
      fields: {
        '#amnt': {
        	errorTarget:'#amntDIV',
          required: true,
          message: '该字段为必须！',
          test:function(e){
              return /[0-9]/.test(e);
          }
        }
    },
    
    submitButton:'#addBtn',
    happy:function(){
    	$("#flag")[0].value=0;
        //提交表单
        $.ajax({
            type:"GET",
            url:"../servers/Recharge.php",
            data: $("#formID").serialize(),
            dataType:"json",
            success:function(data){
                if(data.code==200){
                    $("#charge")[0].textContent = parseFloat($("#charge")[0].textContent)+parseFloat($("#amnt")[0].value);
                    $("#amnt")[0].value=null;
                    alert("操作成功！");
                }
            },
            error:function(xhr,type){
                //TODO
            }

            });
        
    }
  })
    }
    );
</script>
<script type="text/javascript">
//提现
$(document).ready(function () {
    $('#formID').isHappy({
       classes:{
    	   field:'unhappy',
    	   message:'tip-bubble tip-bubble-top'
       },
       fields: {
           '#amnt': {
           	errorTarget:'#amntDIV',
             required: true,
             message: '该字段为必须！',
             test:function(e){
                 return /[0-9]/.test(e);
             }
           }
       },
    
    submitButton:'#delBtn',
    happy:function(){
        //提交表单
    	$("#flag")[0].value=1;
        $.ajax({
            type:"GET",
            url:"../servers/Recharge.php",
            data: $("#formID").serialize(),
            dataType:"json",
            success:function(data){
            	if(data.code==200){
                    $("#charge")[0].textContent = parseFloat($("#charge")[0].textContent)-parseFloat($("#amnt")[0].value);
                    $("#amnt")[0].value=null;
                }
            	alert(data.message);
            },
            error:function(xhr,type){
                //TODO
            }

            });
        
    }
  })
    }
    );
</script>
</head>
<body>
<form id="formID">
<div class="qb_gap pg_upgrade_content">
	<div class="mod_color_weak  qb_gap qb_pt10">会员充值或提现</div>
	   <div class="qb_flex qb_mb10">
			<div class="mod_input flex_box qb_mr10">
				<div class="qb_flex" id="key_searchDIV">
					<input class="flex_box" type="tel" id="key_search" name="key_search"
                           required="required"
                           placeholder="请输入电话号码或会员卡号" />
				</div>
			</div>
			<a class="mod_btn btn_block" id="search">&nbsp;搜索&nbsp;</a>
		</div>
		<div id="errorDIV" style="display:none"></div>
		<div id="resultDIV" style="display: none">
		<!-- 会员信息 -->
		<div id="userInfoID" class="qb_flex qb_mb10">
            <table  style="width: 100%;">
                <tr>
                    <td>会员号：</td>
                    <td id="cardId">888888</td>
                    <td>余额：</td>
                    <td id="charge">2000</td>
                <tr>
                 <tr>
                    <td>姓名：</td>
                    <td id="username">张三</td>
                    <td>电话：</td>
                    <td id="telphone">13800000000</td>
                <tr>
                <tr>
                    <td>积分：</td>
                    <td id="credits">500</td>
                <tr>
            </table>
        </div>
        
            <input type="hidden" name="uid" id="uid">
            <input type="hidden" name="flag" id="flag">
        <div class="mod_input qb_mb10 qb_flex" id="amntDIV">
			<label>金额：</label> <input name="amnt"
				value=""
				class="flex_box"
				placeholder="请输入充值或提现的金额的金额"
				id="amnt"
				type="number"
				required="required"
				min="0"
			>
		</div>
		
        <div class="qb_flex qb_mb10">
        	<a id="addBtn" class="mod_btn btn_block qb_mb10 " style="width: 40% " href="#">充值</a> 
    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        	<a id="delBtn" class="mod_btn btn_block qb_mb10 " style="width: 40% " href="#">提现</a> 
    	</div>
		</div>
</div>
</form>
</body>
</html>