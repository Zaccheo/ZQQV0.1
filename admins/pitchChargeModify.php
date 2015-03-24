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
<title>修改球场定价信息</title>
<script src="../js/zepto.js"></script>
<script src="../js/happy.js"></script>
<link
	rel="stylesheet"
	type="text/css"
	href="../css/wei_bind.css"
>
<!--组件依赖css begin-->
<link rel="stylesheet" type="text/css" href="../imgs/gmu/widget/calendar/calendar.css" />
<link rel="stylesheet" type="text/css" href="../imgs/gmu/widget/calendar/calendar.default.css" />
<link rel="stylesheet" type="text/css" href="../css/gmu/widget/dialog/dialog.css" />
<link rel="stylesheet" type="text/css" href="../css/gmu/widget/dialog/dialog.default.css" />
<!--组件依赖css end-->
<!--组件依赖js begin-->
<script type="text/javascript" src="../js/gmu/core/gmu.js"></script>
<script type="text/javascript" src="../js/gmu/core/event.js"></script>
<script type="text/javascript" src="../js/gmu/core/widget.js"></script>
<script type="text/javascript" src="../js/gmu/extend/parseTpl.js"></script>
<script type="text/javascript" src="../js/gmu/extend/touch.js"></script><!--新版zepto合并版中不包括touch.js-->
<script type="text/javascript" src="../js/gmu/extend/highlight.js"></script>
<script type="text/javascript" src="../js/gmu/widget/calendar/calendar.js"></script>
<script type="text/javascript" src="../js/gmu/widget/dialog/dialog.js"></script>
<script type="text/javascript" src="../js/gmu/widget/dialog/$position.js"></script>
<!--组件依赖js end-->
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

	$(document).ready(function () {
		$.ajax({
	        type:"GET",
	        url:"../servers/PitchsInfo.php",
	        dataType:"json",
	        success:function(data){
	       	  //获取到的信息是data.data,是一个数组
	         	  //{"code":200,"message":"\u83b7\u53d6\u6210\u529f",
	       	  //"data":[{"id":"1","capacity":"5","pitchCode":"code01","pitchDesc":"\u63cf\u8ff001","pitchAddr":"\u5730\u574001"}]}
	    	    if($.isArray(data.data)){
	    	    	$("#pitchInfo").empty();
	    	    	$temp = "<option value=\"-1\" selected=\"selected\">请选择需要设定的球场</option>";
	    	    	$("#pitchInfo").append($temp);
	    	    	$.each(data.data, function(index, item){
	        	    	$temp = "<option value=\""+item.id+"\">";
	      	    	       $temp +=item.pitchCode+"-"+item.capacity+"人场";
	        	    	$temp +="</option>";
	    	    		$("#pitchInfo").append($temp);
	  	    		})
	        	}
	            },
	        error:function(xhr,type){
	            //TODO
	        }

	        });
	});
	
</script>
<script type="text/javascript">

function change(){
	reset();
	var pDate = $("#pDate")[0].value;
	var pitchInfo=$("#pitchInfo")[0].value;
	if(pDate !="" && pitchInfo != "-1" ){
		getPitchOrderInfo(pDate,pitchInfo);
	}else{
	    $("#resultID")[0].style.display="none";
	}
}
function getPitchOrderInfo(pDate,pitchInfo){
	$.ajax({
        type:"GET",
        url:"../servers/PitchsOrder.php",
        data:{"qdate":pDate,"pcid":pitchInfo},
        dataType:"json",
        success:function(data){
        	constructTable(data);
            },
        error:function(xhr,type){
            //TODO
        }

        });
}
function constructTable(data){
	 //获取到的信息是data.data,是一个数组
    if($.isArray(data.data)){
    	$("#resultID tbody").empty();
    	$.each(data.data, function(index, item){
	    	$temp = "<tr onclick='displayInfo("+JSON.stringify(item)+")'>";
	    	       $temp +="<td>"+item.startTime+"</td>";
 	    	   $temp +="<td>"+item.endTime+"</td>";
   	       $temp +="<td>"+item.charge+"</td>";
      	    $temp +="<td>"+item.credits+"</td>";
   	       $temp +="<td>"+mapOrderStatus(item.orderStatus)+"</td>";
	    	$temp +="</tr>";
    		$("#resultID tbody").append($temp);
  		});
  		$("#resultID")[0].style.display="";
	}
}

function displayInfo(item){
	$("#poId")[0].value=item.id;
	$("#st")[0].value=item.startTime;
	$("#et")[0].value=item.endTime;
	$("#charge")[0].value=item.charge;
	$("#credit")[0].value=item.credits;
	$("#infoDIV")[0].style.display="";
	if(item.orderStatus=="0"){
		$("#opDiv")[0].style.display="";
	}else{
		$("#opDiv")[0].style.display="none";
	}
}

function mapOrderStatus(e){
	var ret = "";
	switch(e){
	case "0":
		ret = "未被预约";
		break;
	case "1":
		ret = "已被预约";
		break;
	case "2":
		ret = "使用完成";
		break;
	default:
		break;
	}
	return ret;
}
</script>
<script type="text/javascript">
function mod2Table(data){
	var item = data.data;
	    	$temp = "<tr>";
	    	   $temp +="<td>"+item.startTime+"</td>";
	    	   $temp +="<td>"+item.endTime+"</td>";
	    	   $temp +="<td>"+item.charge+"</td>";
	    	   $temp +="<td>"+item.credits+"</td>";
	    	   $temp +="<td>"+item.orderStatus+"</td>";
	    	$temp +="</tr>";
  		$("#resultID tbody").append($temp);
}
//修改记录
$(document).ready(function () {
    $('form').isHappy({
       classes:{
    	   field:'unhappy',
    	   message:'tip-bubble tip-bubble-top'
       },
      fields: {
      '#charge': {
        	errorTarget:'#chargeDIV',
          required: true,
          message: '该字段为必须！',
          test:function(e){
              return /[0-9]/.test(e);
          }
      },
      '#credit': {
        	errorTarget:'#creditDIV',
          required: true,
          message: '该字段为必须！',
          test:function(e){
        	  return /[0-9]/.test(e);
          }
      }
    },
    
    submitButton:'#saveBtn',
    happy:function(){
        //提交表单
    	if($("#poId")[0].value==""){
      	    alert("请选择需要修改的记录！");
      	    return;
         	 }
        $.ajax({
            type:"GET",
            url:"../servers/EditPtcOrder.php",
            data: $("form").serialize(),
            dataType:"json",
            success:function(data){
                reset();
            	//mod2Table(data);
                change();
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
        $("#infoDIV")[0].style.display="none";
        $("#poId")[0].value="";
    }
    function delPitchOrder(){
   	 //提交表单
     	 if($("#poId")[0].value==""){
      	    alert("请选择需要删除的记录！");
      	    return;
         	 }
        $.ajax({
            type:"GET",
            url:"../servers/DelPtcOrder.php",
            data: $("form").serialize(),
            dataType:"json",
            success:function(data){
                reset();
            	//mod2Table(data);
                change();
            },
            error:function(xhr,type){
                //TODO
            }

            });
    }
</script>
</head>
<body>
<form>
<input type="hidden" name="poId" id="poId">
<div class="qb_gap pg_upgrade_content">
<div class="mod_color_weak qb_gap qb_pt10">修改球场定价信息</div>
        <!-- 日期 -->
        <div
			class="mod_input qb_mb10 qb_flex"
		>
			<label>日期：</label> <input name="od" style="padding-top:5px"
				class="flex_box" readonly="readonly" type="text"
				id="pDate"
			>
		</div>
		  <!-- 规模 -->
        <div
			class="mod_input qb_mb10 qb_flex"
		>
			<label>球场信息：</label>
            <select class="flex_box" name="ptcId" id="pitchInfo" 
            style="border:none; background:white" onchange="change()"
            >
            </select>
		</div>
<div id="resultID" style="display:none">
		<table border="1" style="width: 100%">
	<thead>
		<tr>
			<th>起始时间</th>
			<th>结束时间</th>
			<th>金额</th>
			<th>积分</th>
			<th>状态</th>
		</tr>
	</thead>
  <tbody>
  	
  </tbody>
</table>
   <div id="infoDIV" style="display:">
  <!-- 起始时间-->
        <div id="stDIV"
			class="mod_input qb_mb10 qb_flex"
		>
			<label>起始时间：</label> <input name="st"
				class="flex_box"
				id="st"
				type="text"
				readonly="readonly"
			>
		</div>
  <!-- 结束时间-->
        <div id="etDIV"
			class="mod_input qb_mb10 qb_flex"
		>
			<label>结束时间：</label> <input name="et"
				class="flex_box"
				id="et"
				type="text"
                readonly="readonly"
				>
		</div>
		  <!-- 预约金额-->
        <div id="chargeDIV"
			class="mod_input qb_mb10 qb_flex"
		>
			<label>定价金额：</label> <input name="charge"
				class="flex_box"
				id="charge"
				type="number"
				required="required"
				placeholder="请输入定价金额"
			>
		</div>
		<div id="creditDIV"
			class="mod_input qb_mb10 qb_flex"
		>
			<label>默认积分：</label> <input name="credit"
				class="flex_box"
				id="credit"
				type="number"
				required="required"
				placeholder="请输入默认积分"
			>
		</div>

<!-- 提交 -->
<div class="qb_flex qb_mb10" id="opDiv">
    	<a id="saveBtn" class="mod_btn btn_block qb_mb10" style="width:45%" href="#">修改</a>
    	&nbsp;&nbsp;
    	<a id="delBtn" class="mod_btn btn_block qb_mb10" style="width:45%" href="javascript:delPitchOrder()">删除</a> 
</div>
</div>
</div>
</div>
</form>
<div id="datepicker_start" style="display:none"></div>
<script type="text/javascript">
    (function($, undefined){
        $(function(){//dom ready
            var today = new Date();

            //设置开始时间为今天
            $('#pDate')[0].value=$.calendar.formatDate(today);
            $('#datepicker_start').calendar({//初始化开始时间的datepicker
                date:$('#pDate')[0].value,//设置初始日期为文本内容
                minDate: $.calendar.formatDate(today),//
                swipeable:true,//设置是否可以通过左右滑动手势来切换日历
                select: function(e, date, dateStr){//当选中某个日期时。
                    //收起datepicker
                    $('#datepicker_start').dialog('close');
                    //把所选日期赋值给文本
                    $('#pDate')[0].value=dateStr;
                    change();
                }
            });
            $('#pDate').click(function(e){//展开或收起日期
            	$('#datepicker_start').dialog('open');
            });
        });
    })(Zepto);
</script>

<script>
    //setup模式
$('#datepicker_start').dialog({
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