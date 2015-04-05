<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>
			球赛结算
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="../../css/common.css" />
		<link rel="stylesheet" href="../../css/style.css" />
		<link rel="stylesheet" href="../../css/index.css" />
		<style type="text/css">
			input:-webkit-autofill,
			input:-webkit-autofill:hover,
			input:-webkit-autofill:focus {
				box-shadow: 0 0 0 60px #fff inset;
				-webkit-text-fill-color: #333;
			}
		</style>
		
		<script src="../../js/wxcheck.js" type="text/javascript" ></script>
		<script src="../../js/zepto.min.js" type="text/javascript"></script>
		<script src="../../js/zepto.picLazyLoad.min.js" type="text/javascript"></script>
		<script src="../../js/proTools.js" type="text/javascript"></script>
		<script src="../../js/home.js" type="text/javascript"></script>
		<?php $openId = isset($_GET['openId']) ? $_GET['openId'] : null;?>
	</head>
	<body>
		<header class="header">
			<h2>
				<span id="headerTitle"></span>
			</h2>
		</header>
		<div class="wrapbox">
			<!-- 比赛基础信息 start -->
			<div class="order-box">
			     <div class="order-item clearfix">
					<div class="order-item-key">
						比赛发起人：
					</div>
					<div id="activityCreator" class="order-item-value red">
					</div>
				</div>
				<div class="order-item clearfix">
					<div class="order-item-key">
						比赛时间：
					</div>
					<div id="matchtime" class="order-item-value red">
					</div>
				</div>
				<div class="order-item clearfix">
				    <div class="order-item-key">
						球赛信息：
					</div>
					<div class="order-item-value">
						 &nbsp;<span id="capacityId"></span> 
						 <input type="hidden" id="capacityInputId" value="">
						&nbsp;|&nbsp;<span id="pitchCodeId"></span>
						&nbsp;|&nbsp;<span id="activityStatusId" style="color: red"></span>
					</div>
					
				</div>
				<div style="display: block;">
					      <h3> 比赛胜利方:</h3> <br>
						<select  id="winnerId" class="text-input">
						<option value="0">请选择胜利的队伍</option>
						<option value="1">主队胜利</option>
						<option value="2">客队胜利</option>
						<option value="3">平局</option>
                        </select>
						<br>
				
						<h3> 结算金额(RMB):<label  id="pitchChargeId" style="color: red"></label> </h3><br>
						<input type="number" min="0" class="text-input" id="activityChargeId" /><br>
				
						<h3> 积分数目:<label  id="pitchCreditsId"  style="color: red"></label></h3> <br>
						<input type="number" min="0" class="text-input" id="creditsId" />
				</div>
				<div class="item item-btns">
					<a id ="confirmId" href="javascript:;" style="display: none" class="joinmatch-btn host-btn">
						结算
					</a>
					<a href="javascript:window.history.go(-1);"  class="joinmatch-btn visit-btn">
						返回
					</a>
				</div>
			</div>
			<!-- 比赛基础信息 end -->
			
			
		</div>
		
		<br>
		<div style="float: left;width: 100%;">
			<div class="footer">
				<p class="f-text1">
					Copyright © 2014－2015四川誉合誉科技版权所有
				</p>
				<p class="f-text2">
				</p>
			</div>
		</div>
		<!-- main wrap end-->
		
		<script>
		var openId = '<?php echo $openId;?>';
	   $(function() {
	//获取活动比赛信息
	$.post("../../servers/match/MatchManageItem.php",{
			"id_activities":<?php echo $_GET['id_activities'];?>,
			"openId":openId
			},function(data) {
				//alert(JSON.string);
			if (data.code == 200) {
				var detailObj = data.data;
				
				//处理时间
				var matchtime = detailObj.zDate + "(" + getWeek(detailObj.zDate)+")<p style='font-size:18px;color:red;'>"+shortTime(detailObj.startTime)+"-"+shortTime(detailObj.endTime)+"</p>";
				
				//头部
				$("#headerTitle").html(detailObj.activityName + "-" + detailObj.nickName);
				//比赛时间
				$("#matchtime").html(matchtime);
				//规模
				$("#capacityId").html(detailObj.capacity+" 人制");
				$("#capacityInputId")[0].value=detailObj.capacity;
				// 球场预约定价金额
				$("#pitchChargeId").html(detailObj.charge);
				//球场默认积分
				$("#pitchCreditsId").html(detailObj.credits);
				//规模
				$("#pitchCodeId").html(detailObj.pitchCode);
				$("#activityStatusId").html(mapActivityStatus(detailObj.activityStatus));
				activityCreatorHtml = '<a href="#" class="gridbox">'+'<div class="orders-pic"><img class="pitchsavatar" src="'+detailObj.headerImgUrl+'" alt=""></div>'
				+'<div class="grid-1"><h2 class="h2-title">'+detailObj.nickName+'</h2><p>电话: '+detailObj.phoneNumber
				+'</p><p>余额: '+detailObj.userCharge+'</p><p>信用等级: '+detailObj.creditLevel+'</p><p>会员积分: '+detailObj.userCredits+'</p></div></a>';

				$("#activityCreator").html(activityCreatorHtml);
			}
		},"json");


});
	   //活动状态[0=计划，1=创建，2=进行中，3=完成，4=已取消]
		    function mapActivityStatus(key){
			    var retStr = "未知";
		        switch(key){
		            case "0":retStr = "已预约";break;  
    		        case "1":retStr = "等待入场比赛";break;
    		        case "2":retStr = "比赛中...";$("#confirmId")[0].style.display="";break;
    		        case "3":retStr = "比赛已结束";break;
    		        case "4":retStr = "已取消";break; 
    		        default:   break;
		        }
		        return retStr;
		    }

	   $('#confirmId').on('click',function(){
		   if($('#winnerId').val() == "0"){
				$('#winnerId').css('border-color','brown');
				alertWarning('请选择胜利队伍!','top');
		   }else if($('#activityChargeId').val() == ""){
			   $('#activityChargeId').css('border-color','brown');
				alertWarning('请输入结算金额!','top');
		   }else if($('#creditsId').val() == ""){
			   $('#creditsId').css('border-color','brown');
				alertWarning('请输入积分数目!','top');
		   }else{
			    alertLoading("执行结算中，请耐心等待......");
		   		$.post("../../servers/match/SettleMatch.php",{
		   				"id_activities":<?php echo $_GET['id_activities'];?>,
				   		"winner":$('#winnerId').val(),
				   		"activityCharge":	$('#activityChargeId').val(),
				   		"credits":	$('#creditsId').val(),
				   		"capacity":$("#capacityInputId").val()
		   			},function(data){
		   				if(data.code == 200){
		   					$(".div-mask").remove();
		   					alertSuccess('结算成功', 'top');
							setTimeout(function() {
								window.history.go(-1);
							}, 1000);

		   				}else{
		   					$(".div-mask").remove();
		   					alertWarning(data.message,"top");
		   				}
		   		},"json");

			   }

		   });
</script>
	</body>
</html>