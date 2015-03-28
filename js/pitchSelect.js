/*
* 选场类操作库
*
*/
$(function(){

	//已选择的球场编号
	var selectPitchs = {};
	//创建触屏事件
	var touchClick = ('createTouch' in document) ? 'tap':'click';
	var dateStr = "";
	//点击场次选择
	var touchPitch = function(){
		$('.J_courts').on(touchClick,'.court-detail',function(){
			//已选择的球场编号
			//var currentPitchs = {};
			var el = $(this);
			var curPid = el.attr('pitchid');//当前选择的预订场次
			if(el.hasClass('disable')){
				return;
			}
			//若已经被选中,点击一次则进行删除操作
			if(selectPitchs[curPid]){
				delete selectPitchs[curPid];
				dateStr = "";
				//alert("!");
				el.removeClass('selected');
				el.addClass('available');
			}else{
				//点击未选中的，则进行选中操作
				selectPitchs[curPid] = parseInt(el.html());
				dateStr =el.attr('zDate')+" "+getWeek(el.attr('zDate'))+" "+el.attr('startTime').substr(0, 5)+" "+el.attr('endTime').substr(0, 5);
				el.removeClass('available');
				$('.court-detail').each(function(){
					$(this).removeClass('selected');
					$(this).addClass('available');
				});
				el.addClass('selected');
			}
			//selectPitchs = currentPitchs;
			
			// if(selectCourts[curGid]){
			// 	delete selectCourts[curGid];
   //              delete selectCourts2[curGid];
			// 	el.addClass('available');
			// 	el.removeClass('selected');
   //              //打包处理
   //              var group_ids = el.attr('group_ids');
   //              var group_arr = new Array();
   //              if (group_ids != ''){
   //                  group_arr=group_ids.split(',');
   //                  for(var i=0;i<group_arr.length;i++){
   //                      var blid = "#pitch_"+group_arr[i];
   //                      if(!$(blid).hasClass('disable')){
   //                          delete selectCourts[group_arr[i]];
   //                          delete selectCourts2[group_arr[i]];
   //          				$(blid).addClass('available');
   //          				$(blid).removeClass('selected');
   //                      }
   //                  }  
   //              }  
   //              //打包处理
			// }else{
   //              //push it to the array
   // 				selectCourts[curGid] = parseInt(el.html());
   //              selectCourts2[curGid] = el.attr('course_content');
   // 				el.removeClass('available');
   // 				el.addClass('selected');
   //              //打包处理
   //              var group_ids = el.attr('group_ids');
   //              var group_arr = new Array();
   //              if (group_ids != ''){
   //                  group_arr=group_ids.split(',');
   //                  for(var i=0;i<group_arr.length;i++){
   //                      var blid = "#pitch_"+group_arr[i];
   //                      if(!$(blid).hasClass('disable')){
   //                          selectCourts[group_arr[i]] = parseInt($(blid).html());
   //                          selectCourts2[group_arr[i]] = $(blid).attr('course_content');
   //         				    $(blid).removeClass('available');
   //         				    $(blid).addClass('selected');
   //                      }
   //                  }  
   //              }


			// }
		});
	};

	//提交选中的场次
	$(".pitch_submit").on(touchClick,function(){
		if($.isEmptyObject(selectPitchs)){
			alert("请选择一个场！");
			return;
		}
		var pIDS = new Array();
		$.each(selectPitchs,function(k,v){
			pIDS.push(k);
		});
		window.localStorage.setItem("pitchOrderId",pIDS);
		window.localStorage.setItem("selpitch",dateStr);
		window.history.go(-1);
		// $.post("../../servers/common/test.php"
		// 	,{"selectPit":selectPitchs,
		// 	  "openId":window.localStorage.getItem("openId")}
		// 	,function(data){

		// 	window.localStorage.setItem("selpitch", "2015-03-13 星期四 1号场 9:00-10:30");
		// 	window.localStorage.setItem("pitchOrderId","111");
		// 	window.history.go(-1);
		// });
		
		// if( == 0){
		// 	alert("请选择一场！");
		// 	return;
		// }
	});

	touchPitch();
});


function shortTime(){

}