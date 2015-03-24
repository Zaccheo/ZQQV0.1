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
<title>添加球场定价信息</title>
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
String.prototype.replaceAll = function(reallyDo, replaceWith, ignoreCase) { 
	if (!RegExp.prototype.isPrototypeOf(reallyDo)) { 
	  return this.replace(new RegExp(reallyDo, (ignoreCase ? "gi": "g")), replaceWith); 
	} else { 
	  return this.replace(reallyDo, replaceWith); 
	}
}

var WEEK_DAYS=["周日","周一","周二","周三","周四","周五","周六"];
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
	//添加新记录
	$(document).ready(function () {
	    $('#mainForm').isHappy({
	       classes:{
	    	   field:'unhappy',
	    	   message:'tip-bubble tip-bubble-top'
	       },
	      fields: {
	      '#pitchInfo': {
	          errorTarget:'#pitchInfoDIV',
	          required: true,
	          message: '该字段为必须！',
	          test:function(e){
	        	  return !(/-1/.test(e));
	          }
	      }
	    },
	    submitButton:'#saveBtn',
	    happy:function(){
		    var dates2BeAdded = getSelectedWeekDay();
		    if(dates2BeAdded.length<1){
		    	alert('请至少选择一个周几！');
		    	return;
		    }
		    if(isTimeCrossed()==true){
		        return;
			}

	       var trs = $("#resultID tbody tr");
	       var i=0;
	       var picInfos = new Array();
	       while(i<trs.length-1){
	    	   picInfos.push(JSON.parse(trs[i].getAttribute('data')));
	    	   i++;
	       }
	       if(picInfos.length<1){
	    	   //TODO
	    	   alert('请至少添加一行数据');
		   }else{
			    //TODO
			    var tmpObj = new Object();
			    tmpObj.sDate = $('#sDate')[0].value;
			    tmpObj.eDate = $('#eDate')[0].value;
			    tmpObj.ptcId = $('#pitchInfo')[0].value;
			    tmpObj.dates2BeAdded = dates2BeAdded
			    tmpObj.pitchInfo = picInfos;
		        addMutilPictInfos(JSON.stringify(tmpObj));
			}
	  }})
	    }
	    );
    function isTimeCrossed(){
    	var trs = $("#resultID tbody tr");
    	var count = trs.length-1;
    	for(var i=0;i<count;i++){
    	    var di = JSON.parse(trs[i].getAttribute("data"));
        	for(var j=i+1;j<count;j++){
         		   var dj = JSON.parse(trs[j].getAttribute("data"));
             		if(((dj.startTime<=di.startTime) && (di.startTime<dj.endTime))
              		   ||((dj.startTime<di.endTime) && (di.endTime<=dj.endTime))
              		   ||((di.startTime<=dj.startTime) && (dj.startTime<di.endTime))
              		   ||((di.startTime<dj.endTime) && (dj.endTime<=di.endTime)))
              		   {
             		    alert("第"+(i+1)+"行和第"+(j+1)+"行数据时间有冲突！");
             		    return true;
              		   }
            }
    	}
    	return false;
    }
    function addMutilPictInfos(pics){
   	 $.ajax({
         type:"POST",
         url:"../servers/AddMutilPtcOrder.php",
         data: {"param":pics},
         dataType:"json",
         success:function(data){
             alert(data.message);
         },
         error:function(xhr,type){
             //TODO
         }

         });

        }
    function resetAll(){
    }
</script>
<script type="text/javascript">
function dchange(){
	//设置日期的级联关系
	var sDateV = $("#sDate")[0].value;
	var eDateV = $("#eDate")[0].value;
    if(sDateV!=""&&eDateV!=""){
		cWeekDay(new Date(sDateV.replaceAll("-","/")),new Date(eDateV.replaceAll("-","/")));
    }
}
//设置星期几的checkbox,在某个日期范围内，可能没有对应的weekday
function cWeekDay(sDateV,eDateV){
	var t = sDateV;
	$("#weekDayDIV").empty();
	var i =0;
	while((t<=eDateV)&&(i<7)){
		$temp = "<input style='zoom: 1.5' type='checkbox' data-value=\""+t.getDay()+"\"><label>"
		   +WEEK_DAYS[t.getDay()]+"</label>";
		$("#weekDayDIV").append($temp);  
    	t.setDate(t.getDate()+1);
    	i++;
	}
	
}
function getCheckBoxValues(){
	var weekdays = $('#weekDayDIV input');
	selectedWeekDays = null;
	selectedWeekDays = new Array();
	for(a=0;a<weekdays.length;a++){
	    v = weekdays[a].checked;
	    if(v==true){
	    	selectedWeekDays.push(weekdays[a].getAttribute('data-value'));
		}
	}
	return selectedWeekDays;
}
function getSelectedWeekDay(){
	dates2BeAdded = null;
	dates2BeAdded = new Array();
	var weekDaysV = getCheckBoxValues();
	if(weekDaysV.length>0){
		var sDateV =new Date($("#sDate")[0].value);
		var eDateV = new Date($("#eDate")[0].value);
		var t = sDateV;
		while(t<=eDateV){
			if($.inArray(""+t.getDay(),weekDaysV)>-1){
				dates2BeAdded.push(t.getFullYear()+"-"+mapInt2Str(t.getMonth()+1)+"-"+mapInt2Str(t.getDate()));
			}
	    	t.setDate(t.getDate()+1);
		}
	}
	return dates2BeAdded;
}
function mapInt2Str(ii){
	if(ii<10){
		return "0"+ii;
		}else{
		   return ""+ii;
		}
}
function addImgClk(){
	$("#mainDIV")[0].style.display="none";
	$("#opDIV")[0].style.display="";
}
function delImgClk(item){
	$("#"+item).remove();
}
</script>
</head>
<body>
<div class="qb_gap pg_upgrade_content">
<div id="mainDIV">
<div class="mod_color_weak qb_gap qb_pt10">
批量添加球场预定信息
</div>
<form id="mainForm">
        <!-- 日期 -->
        <div
			class="mod_input qb_mb10 qb_flex"
		>
			<label>开始日期：</label> <input name="sd" style="padding-top:5px"
				class="flex_box" type="text" readonly="readonly"
				id="sDate">
			</div>
			<div
			class="mod_input qb_mb10 qb_flex"
		>
			<label>结束日期：</label> <input name="ed" style="padding-top:5px"
				class="flex_box" type="text" readonly="readonly"
				id="eDate">
			</div>
			<!-- 星期N -->
        <div id="weekDayDIV" class="weekDayCheckBox">
            <input type="checkbox" data-value="1"><label>周一</label>
            <input type="checkbox" data-value="2"><label>周二</label>
            <input type="checkbox" data-value="3"><label>周三</label>
            <input type="checkbox" data-value="4"><label>周四</label>
            <input type="checkbox" data-value="5"><label>周五</label>
            <input type="checkbox" data-value="6"><label>周六</label>
            <input type="checkbox" data-value="0"><label>周日</label>
		</div>
		  <!-- 规模 -->
        <div id="pitchInfoDIV"
			class="mod_input qb_mb10 qb_flex"
		>
			<label>球场信息：</label>
            <select class="flex_box" name="ptcId" id="pitchInfo" 
            style="border:none; background:white"
            >
            </select>
		</div>

    <table id="resultID" border="1" style="width: 100%">
	<thead>
		<tr>
			<th>开始时间</th>
			<th>结束时间</th>
			<th>金额</th>
			<th>默认积分</th>
			<th>+/-</th>
		</tr>
	</thead>
	<tbody>
	<tr id="addBtnID">
	<td colspan="4" align="center">点击右边的+添加新信息！</td>
	<td align="center"><a href="javascript:addImgClk()"><img style="width:25px" src="../imgs/add2.png"></a></td></tr>
	</tbody>
</table>
<div class="qb_flex qb_mb10">
    	<a id="saveBtn" href="#" class="mod_btn btn_block qb_mb10" style="width:100%">保存</a> 
</div>
</form>
</div>
<div id="opDIV" style="display:none">
<script type="text/javascript">
var TEMPID = 1;
function reset(){
    $("#st")[0].value="";
    $("#et")[0].value="";
    $("#charge")[0].value="";
    $("#credit")[0].value="";
}
function add2Table(item){
	$temp = "<tr id=\"id_"+TEMPID+"\" data='"+JSON.stringify(item)+"'>";
	   $temp +="<td>"+item.startTime+"</td>";
	   $temp +="<td>"+item.endTime+"</td>";
	   $temp +="<td>"+item.charge+"</td>";
	   $temp +="<td>"+item.credits+"</td>";
	   $temp +="<td align=\"center\"><a href=\"javascript:delImgClk('id_"+TEMPID+"')\"><img style=\"width:25px\" src=\"../imgs/del4.png\"></a></td>";
	$temp +="</tr>";
	$("#addBtnID").before($temp);
	TEMPID++;
}
//添加新记录
$(document).ready(function () {
    $('#opForm').isHappy({
       classes:{
    	   field:'unhappy',
    	   message:'tip-bubble tip-bubble-top'
       },
      fields: {
        '#st': {
        	errorTarget:'#stDIV',
          required: true,
          message: '该字段为必须！'
          
        },
        '#et': {
          errorTarget:'#etDIV',
          required: true,
          message: '该字段为必须,且需大于开始时间！',
          test:function(e){
              return e>$('#st')[0].value;
          }
      },
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
    
    submitButton:'#addBtn',
    happy:function(){
        var obj = new Object();
        obj.startTime=$("#st")[0].value;
        obj.endTime=$("#et")[0].value;
        obj.charge=$("#charge")[0].value;
        obj.credits=$("#credit")[0].value;

    	add2Table(obj);
    	back();
    }
  })
    }
    );
function back(){
	$("#mainDIV")[0].style.display="";
	$("#opDIV")[0].style.display="none";
}

</script>
  <!-- 起始时间-->
  <form id="opForm">
        <div id="stDIV"
			class="mod_input qb_mb10 qb_flex"
		>
			<label>起始时间：</label> 
			 <input name="st"
				class="flex_box"
				id="st"
				type="time"
				required="required"
				placeholder="请输入场次结束时间"
			>
		</div>
  <!-- 结束时间-->
  
        <div id="etDIV"
			class="mod_input qb_mb10 qb_flex"
		>
			<label>结束时间：</label> <input name="et"
				class="flex_box"
				id="et"
				type="time"
				required="required"
				placeholder="请输入场次结束时间"
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
<div class="qb_flex qb_mb10">
    	<a id="addBtn" class="mod_btn btn_block qb_mb10" style="width:40%" href="#">添加</a> 
        &nbsp;&nbsp;
        <a  class="mod_btn btn_block qb_mb10" style="width:40%" href="javascript:back()">取消</a>
</div>
</form>
</div>
</div>
<div id="datepicker_start" style="display:none"></div>
<div id="datepicker_end" style="display:none"></div>
<script type="text/javascript">
    (function($, undefined){
        $(function(){//dom ready
            var today = new Date();

            //设置开始时间为今天
            $('#sDate')[0].value=$.calendar.formatDate(today);

            //设置结束事件为7天之后
            $('#eDate')[0].value=$.calendar.formatDate(new Date(today.getFullYear(), today.getMonth(), today.getDate()+7));

            $('#datepicker_start').calendar({//初始化开始时间的datepicker
                date:$('#sDate')[0].value,//设置初始日期为文本内容
                minDate: $.calendar.formatDate(today),//设置最小日期为当月第一天，既上一月的不能选
                maxDate: $('#eDate')[0].value,//设置最大日期为结束日期，结束日期以后的天不能选
                swipeable:true,//设置是否可以通过左右滑动手势来切换日历
                select: function(e, date, dateStr){//当选中某个日期时。
                    $('#datepicker_end').calendar('minDate', date).calendar('refresh');//将结束时间的datepick的最小日期设成所选日期
                    //收起datepicker
                    $('#datepicker_start').dialog('close');
                    //把所选日期赋值给文本
                    $('#sDate')[0].value=dateStr;
                    dchange();
                }
            });
            $('#datepicker_end').calendar({//初始化结束时间的datepicker
                date:$('#eDate')[0].value,//设置初始日期为文本内容
                minDate: $('#sDate')[0].value,//设置最小日期为开始日期，开始日期以前的天不能选
                swipeable:true,//设置是否可以通过左右滑动手势来切换日历
                select: function(e, date, dateStr){//当选中某个日期时。
                    $('#datepicker_start').calendar('maxDate', date).calendar('refresh');//将开始时间的datepicker的最达日期设成所选日期
                    //收起datepicker
                    $('#datepicker_end').dialog('close');
                    //把所选日期赋值给文本
                    $('#eDate')[0].value=dateStr;
                    dchange();
                }
            });

            $('#sDate').click(function(e){//展开或收起日期
            	$('#datepicker_start').dialog('open');
            });
             $('#eDate').click(function(e){//展开或收起日期
            	 $('#datepicker_end').dialog('open');
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
$('#datepicker_end').dialog({
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