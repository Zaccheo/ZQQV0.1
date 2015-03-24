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
<title>添加球场信息</title>
<script src="../js/zepto.min.js"></script>
<script src="../js/happy.js"></script>
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
//获取球场信息
function init(){
	$.ajax({
        type:"GET",
        url:"../servers/PitchsInfo.php",
        dataType:"json",
        success:function(data){
       	  //获取到的信息是data.data,是一个数组
         	  //{"code":200,"message":"\u83b7\u53d6\u6210\u529f",
       	  //"data":[{"id":"1","capacity":"5","pitchCode":"code01","pitchDesc":"\u63cf\u8ff001","pitchAddr":"\u5730\u574001"}]}
        	constructTable(data);
            },
        error:function(xhr,type){
            //TODO
        }

        });
}
$(document).ready(function () {
	 init();
});
function constructTable(data){
	 if($.isArray(data.data)){
	    	$("tbody").empty();
	    	$.each(data.data, function(index, item){
	    	$temp = "<tr>";
	    	       $temp +="<td>"+item.pitchCode+"</td>";
	    	   $temp +="<td>"+item.capacity+"</td>";
 	       $temp +="<td>"+item.pitchDesc+"</td>";
 	       $temp +="<td>"+item.pitchAddr+"</td>";
	    	$temp +="</tr>";
	    		$("tbody").append($temp);
		})
	}
}
</script>
<link
	rel="stylesheet"
	type="text/css"
	href="../css/wei_bind.css"
>
<script type="text/javascript">

//添加
$(document).ready(function () {
    $('#formID').isHappy({
       classes:{
    	   field:'unhappy',
    	   message:'tip-bubble tip-bubble-top'
       },
      fields: {
        '#pitchCode': {
        	errorTarget:'#pitchCodeDIV',
          required: true,
          message: '该字段为必须！',
        },
        '#capacity': {
        	errorTarget:'#capacityDIV',
          required: true,
          message: '该字段为必须！',
          test:function(e){
              return /[0-9]/.test(e);
          }
      }
    },
    
    submitButton:'#addBtn',
    happy:function(){
        //提交表单
        $.ajax({
            type:"GET",
            url:"../servers/AddPitchs.php",
            data: $("#formID").serialize(),
            dataType:"json",
            success:function(data){
            	init();
                $("form")[0].reset();
               
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

<div class="qb_gap pg_upgrade_content">
<div class="mod_color_weak  qb_gap qb_pt10">添加球场信息</div>
<table border="1" style="width: 100%;" >
	<thead>
		<tr>
			<th>球场编号</th>
			<th>容量</th>
			<th>描述</th>
			<th>地址</th>
		</tr>
	</thead>
  <tbody>
  	<tr>
  		<td>1号</td>
  		<td>5人</td>
  		<td>描述XXXX</td>
  		<td>地址XXXX</td>
  	</tr>
  </tbody>
</table>
<form id="formID">
 <fieldset>
    <legend>球场信息</legend>
    <div id="pitchCodeDIV"
			class="mod_input qb_mb10 qb_flex"
		>
			<label>球场编号：</label> <input id="pitchCode"
			     name="code"
				value=""
				class="flex_box"
				type="text"
				required="required"
				placeholder="请输入10字以内的球场编号"
				maxlength="10"
			>
		</div>
    <div id="capacityDIV"
			class="mod_input qb_mb10 qb_flex"
		>
			<label>球场容量：</label> <input id="capacity"
				value=""
				name="capa"
				class="flex_box"
				type="number"
				required="required"
				placeholder="请输入球场的容量(5人,7人...)"
				pattern="[1-9]"
			>
		</div>
		<div
			class="mod_input qb_mb10 qb_flex"
		>
			<label>球场描述：</label> <input  id="desc"
				value=""
				name="desc"
				class="flex_box"
				type="text"
				placeholder="请输入25字内的描述信息"
				maxlength="25"
			>
		</div>
		<div
			class="mod_input qb_mb10 qb_flex"
		>
			<label>球场地址：</label> <input id="addr"
				value=""
				name="addr"
				class="flex_box"
				type="text"
				placeholder="请输入25字内地址信息"
				maxlength="25"
			>
		</div>
 </fieldset>
</form>
<div class="qb_flex qb_mb10">
    	<a id="addBtn" class="mod_btn btn_block qb_mb10 " style="width:100%;" href="#" >添加</a>
	</div>
</div>

</body>
</html>