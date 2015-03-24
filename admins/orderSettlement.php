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
<title>订单结算</title>
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
var selected_orderID = null;
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
 	    search();
        
    }
  })
    }
    );
    function search(){
  	  $.ajax({
          type:"GET",
          url:"../servers/UserOrder.php",
          data: $("#formID").serialize(),
          dataType:"json",
          success:function(data){
              if(data.code==200){
              	  $("#uid")[0].value = data.data.user.id;
              	  $("#cardId")[0].textContent = data.data.user.cardID;
              	  $("#charge")[0].textContent = data.data.user.charge;
              	  $("#username")[0].textContent = data.data.user.username;
              	  $("#telphone")[0].textContent = data.data.user.phoneNumber;
              	  $("#credits")[0].textContent = data.data.user.credits;

              	  constructTable(data.data.orders);
             	   $("#resultDIV")[0].style.display="";
            }else{
        	    $("#errorDIV")[0].textContent = data.message;
        	    $("#errorDIV")[0].style.display="";
            }
          },
          error:function(xhr,type){
              //TODO
          }

          });
    }
function constructTable(orders){
	 if($.isArray(orders)){
	    	$("#orderTable tbody").empty();
	    	$.each(orders, function(index, item){
	    	$temp = "<tr>";
	    	       $temp +="<td>"+item.zDate+"</td>";
	    	   $temp +="<td>"+item.startTime+"至"+item.endTime+"</td>";
	       $temp +="<td>"+item.orderCharge+"</td>";
	       $temp +="<td><input name='oName' type='radio' id='"+item.oid+"' onchange=getOrderID("+item.oid+")></td>";
	    	$temp +="</tr>";
	    		$("#orderTable tbody").append($temp);
		})
	}
}
function getOrderID(orderID){
	if($("#"+orderID)[0].checked==true){
		   selected_orderID = orderID;
	}
}
</script>
<script type="text/javascript">
//结算
$(document).ready(function () {
    $('#formID').isHappy({
       classes:{
    	   field:'unhappy',
    	   message:'tip-bubble tip-bubble-top'
       },
      fields: {
        '#chargeID': {
        	errorTarget:'#chargeIDDIV',
          required: true,
          message: '该字段为必须！',
          test:function(e){
              return /[0-9]/.test(e);
          }
        },
        '#creditsID': {
        	errorTarget:'#creditsIDDIV',
          required: true,
          message: '该字段为必须！',
          test:function(e){
              return /[0-9]/.test(e);
          }
        }
    },
    submitButton:'#saveBtn',
    happy:function(){
        //if($(""))
        //提交表单
        if(selected_orderID==null){
            alert("请先选择订单！");
            return;
        }
        $.ajax({
            type:"GET",
            url:"../servers/Settle.php",
            data: {"uoId":selected_orderID,"uid":$("#uid")[0].value,
                "amnt":$("#chargeID")[0].value ,"credits":$("#creditsID")[0].value },
            dataType:"json",
            success:function(data){
                if(data.code==200){
                    alert(data.message);
                    reset();
                    search();
                }else{
                    alert(data.message);
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
    function reset(){
    	selected_orderID = null;
    	$('#uid')[0].value = "";
    	$('#chargeID')[0].value = "";
    	$('#creditsID')[0].value = "";
    	$('#resultDIV')[0].style.display = "none";
    }
</script>
</head>
<body>
<form id="formID">
<input type="hidden" name="uid" id="uid" value="">
	<div class="qb_gap pg_upgrade_content">
	<div class="mod_color_weak  qb_gap qb_pt10">订单结算</div>
	   <div class="qb_flex qb_mb10">
			<div class="mod_input flex_box qb_mr10">
				<div class="qb_flex" id="key_searchDIV">
					<input class="flex_box" type="tel" name="inputId"  id="key_search"
                           required="required"
                           placeholder="请输入订单号、电话号码、会员卡号" />
				</div>
			</div>
			<a class="mod_btn btn_block" id="search" href="#">&nbsp;搜索&nbsp;</a>
		</div>
		<div id="errorDIV" style="display:none"></div>
		<div id="resultDIV" style="display: none">
		<!-- 会员信息 -->
            <table  style="width: 100%;">
                <tr>
                    <td>会员卡号：</td>
                    <td id="cardId"></td>
                    <td>余额：</td>
                    <td id="charge"></td>
                <tr>
                 <tr>
                    <td>姓名：</td>
                    <td id="username"></td>
                    <td>电话：</td>
                    <td id="telphone"></td>
                <tr>
                <tr>
                    <td>积分：</td>
                    <td id="credits"></td>
                    <td></td>
                    <td></td>
                <tr>
            </table>
        <!-- 查询结果 -->
        <div class="mod_color_weak  qb_gap qb_pt10">订单信息</div>
         <table border="1" style="width: 100%;" id="orderTable">
    	<thead>
    		<tr>
    			<th>日期</th>
    			<th>时间</th>
    			<th>费用</th>
    			<th>选择</th>
    		</tr>
    	</thead>
      <tbody>
      	
      </tbody>
    </table>
    <div id="chargeIDDIV" 
		class="mod_input qb_mb10 qb_flex"
	>
			<label>折扣价格：</label> <input 
				value=""
				name = "amnt"
				class="flex_box"
				placeholder="请输入打折后的金额"
				id="chargeID"
				type="number"
				required="required"
				min="0"
			>
		</div>
		<div id="creditsIDDIV"
		class="mod_input qb_mb10 qb_flex"
	>
			<label>积分：</label> <input 
				value=""
				name = "credits"
				class="flex_box"
				placeholder="请输入积分数目"
				id="creditsID"
				type="number"
				required="required"
				min="0"
			>
		</div>
        <div class="qb_flex qb_mb10" >
        	<a id="saveBtn"  class="mod_btn btn_block qb_mb10 " style="width: 100% " href="#">执行结算</a> 
    	</div>
	</div>
	</div>
	</form>
</body>
</html>