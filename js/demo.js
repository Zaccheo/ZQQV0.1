(function(){

	var touchType = ('createTouch' in document) ? 'tap' : 'click';
	var selectCourts = {}, uParam = {}, selectCourts2 = {};

	var dayTemp = template.compile(
		'<% for(var i = 0; i < list.length; i++) { %>' +
		'<li>' +
		'	<p class="t"><%=list[i].str%></p>' +
		'	<p><%=list[i].num%></p>' +
		'</li>' +
		'<% } %>');

	var timeTemp = template.compile(
	  '<% for(var i = 0; i < list.length; i++) { %>' +
		'  <li><%=list[i]%></li>' +
		'<% } %>');

	var courtTemp = template.compile(
		'<% for(var i = 0; i < list.length; i++) { %>' +
		'<div class="col">' +
		'  <div class="court-name"><%=list[i].course_name%></div>' +
		'  <% for(var j = 0; j < list[i].hour_list.length; j++) { %>' +
		'    <% if(list[i].hour_list[j].status == 0) { %>' +
		'    <div class="court-detail available" goodsid="<%=list[i].hour_list[j].goods_id%>" hour="<%=list[i].hour_list[j].hour%>" price="<%=list[i].hour_list[j].price%>" cid="<%=list[i].course_id%>"><%=list[i].hour_list[j].price%></div>' +
		'    <% } else { %>' +
		'    <div class="court-detail disable"></div>' +
		'    <% } %>' +
		'  <% } %>' +
		'</div>' +
		'<% } %>');


	var utils = {
		showError: function(msg) {
			$('.J_err').html(msg);
			$('.J_err').show();
		},
		hideError: function(){
			$('.J_err').hide();
		},
		getUrlParam: function(){
			var s = location.search;
			if(s.length < 2) {
				return;
			}
			s = s.substr(1);
			var arr = s.split('&');
			$.each(arr, function(i,v){
				var n = v.split('=');
				uParam[n[0]] = n[1];
			});
		},
		getDays: function(data){
			var days = [];
			var dayArr = ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'];
			$.each(data, function(i, v){
				var d = new Date(v.day * 1000);
				var M = (d.getMonth() + 1);
				var D = d.getDate();
				var o = {
					str: dayArr[d.getDay()],
					num: (M.length > 1 ? M : '0' + M) + '.' + (D.length > 1 ? D : '0' + D)
				};
				days.push(o);
			});
			return days;
		},
		updateSum: function(){
			var sum = 0;
			$.each(selectCourts, function(i,v){
				sum += v;
			});
            var cent = '';
            $.each(selectCourts2, function(i,v){
                var contents = v.split(",")
				cent +='<li><span>'+contents[1] + ' ' + contents[0] +'</span>';
                cent +='<input type="hidden" value="'+contents[2]+'" name="price[]" />';
                cent +='<input type="hidden" value="'+contents[1]+'" name="hour[]" />';
                cent +='<input type="hidden" value="'+contents[0]+'" name="course_name[]" /></li>';
			});
			$('.total span').html(sum);
            $('.court-tips ul').html(cent);
		},
		getTimeSlice: function(data){
			var timeSlice = [], start = 0, end = 0;

			$.each(data, function(i,v){
				var hourLen = v.hour_list.length;
				v.hour_list[0].hour = parseInt(v.hour_list[0].hour);
				v.hour_list[hourLen - 1].hour = parseInt(v.hour_list[hourLen - 1].hour);
				if(i == 0) {
					start = v.hour_list[0].hour;
					end = v.hour_list[hourLen - 1].hour;
				} else {
					if(start > v.hour_list[0].hour){
						start = v.hour_list[0].hour;
					}
					if(end < v.hour_list[hourLen - 1].hour){
						end = v.hour_list[hourLen - 1].hour;
					}
				}
			});

			for(var i = start; i <= end; i++){
				timeSlice.push(i + ':00');
			}

			return {
				timeSlice: timeSlice,
				start: start,
				end: end
			};
		},
		getEmptyCourtList: function(start, end){
			var list = [];
			for(var i = start; i <= end; i++){
				list.push({
					hour: i,
					status: 2
				});
			}
			return list;
		},
		getCourtData: function(opts){
		    /*
        	$.ajax({
				url: '/order/getbook',
				type: 'get',
				dataType: 'json',
				cache: false,
				data: {
					bid: uParam.id,
					datetime: opts.datetime
				},
				success: function(res){
				    //var res=JSON.parse(res);
					if(res && res.code == 1){
						if(!res.data.length){
							return;
						}
						
						var timeSliceData = utils.getTimeSlice(res.data);
						$('.J_timeSlice').html(timeTemp({
							list: timeSliceData.timeSlice
						}));

						//填补那些残缺不全的空位
						$.each(res.data, function(i,v){
							var newData = utils.getEmptyCourtList(timeSliceData.start, timeSliceData.end);
							$.each(v.hour_list, function(j, h){
								h.hour = parseInt(h.hour);
								newData[h.hour - timeSliceData.start] = h;
							});
							v.hour_list = newData;
						});

						$('.J_courts .inner').css('width', res.data.length * 65 + 'px');
						$('.J_courts .inner').html(courtTemp({
							list: res.data
						}));
					}
				},
				error: function(res){

				}
			});*/
		},
        getLogin: function(){
            var login_lock = false;
            $('.qu').animate({margin:'0 0 0 0',opacity:'1',rotate:'0'},350,'ease-in-out',function(){
            $.dialog({
                content : '<div class="qu">'+
                            '<div class="page page-login" style="padding-top:5px;padding-bottom:0px;background:#fff;font-size:12px;">'+
                        		'<div class="form" style="box-shadow:0 0 0.0625rem 0.0625rem #fff;margin:0 auto;padding: 0.4875rem 0 0rem;font-size:12px;">'+
                        			'<div class="form-item clearfix" style="height:38px;">'+
                        				'<div class="form-icon" style="margin-left:0.8rem;margin-right:0.2rem;"><i class="icon-phone"></i></div>'+
                        				'<div class="form-input" style="width:170px;margin-bottom:1.4rem;font-size:14px;"><input style="font-size:14px;" type="text" id="phone" placeholder="请输入手机号码" class="J_tel" /></div>'+
                        			'</div>'+
                        			'<div class="form-item clearfix" style="height:32px;">'+
                        				'<div class="form-icon" style="margin-left:0.8rem;margin-right:0.2rem;"><i class="icon-password"></i></div>'+
                        				'<div class="form-input" style="width:170px;margin-bottom:1.3rem;font-size:14px;"><input style="font-size:14px;" id="password" type="password" placeholder="请输入密码" class="J_pwd" /></div>'+
                        			'</div>'+
                        		'</div>'+
                        	'</div>'+'<div class="err"><p class="J_lerr"></p></div>'+
                        '</div>',
                title : '登录',
                lock : true,
                isclose : 1,
                ok : function() {
                    if(login_lock){
            			return;
            		}
            		var tel = $('#phone').val();
            		var pwd = $('#password').val();
            		if(!tel || !/1[2345678]{1}\d{9}$/.test(tel)){
                        $('.J_lerr').html('请输入正确的手机号');		
            			return false;
            		}
            		if(!pwd || pwd.length < 6){
                        $('.J_lerr').html('请输入密码');
            			return false;
            		}
                    $('.J_lerr').html('');
                    var errcode = true; 
                    login_lock = true;
                    $('.rDialog-ok').html('登录中');
            		$.ajax({
            			url: '/login/dologin',
            			type: 'GET',
            			dataType: 'json',
            			cache: false,
            			data: {
            				username: tel,
            				password: pwd,
            			},
            			success: function(res){
            			    $('.rDialog-ok').html('登录');
                            login_lock = false;
            				if(res && res.code == 1){
            				    $('.J_lerr').html('登录成功!');
            				    errcode = false;
            					location.reload();
            				} else{
                                $('.J_lerr').html(res.msg);
                                return false;
            				}
            			},
            			error: function(res){
            				$('.rDialog-ok').html('登录');
                            $('.J_lerr').html('网络出错，请稍后再试');
                            login_lock = false;
                            return false;
            			}
            		});
                    if (errcode){
                        return false;
                    }
                },
                cancel : function() {
                    location.href = '/login/register';           
                },
                okText: ' 登  录 ',
                cancelText: '注册',
                width : 245,
            });
            });
        },
	};

	var bindDOM = function(){
		$('.J_courts').on(touchType, '.court-detail', function(){
			var el = $(this);
			var curGid = el.attr('goodsid');

			if(el.hasClass('disable')){
				return;
			}
            
			//exist in the array, delete it
			if(selectCourts[curGid]){
				delete selectCourts[curGid];
                delete selectCourts2[curGid];
				el.addClass('available');
				el.removeClass('selected');
                //打包处理
                var group_ids = el.attr('group_ids');
                var group_arr = new Array();
                if (group_ids != ''){
                    group_arr=group_ids.split(',');
                    for(var i=0;i<group_arr.length;i++){
                        var blid = "#block_"+group_arr[i];
                        if(!$(blid).hasClass('disable')){
                            delete selectCourts[group_arr[i]];
                            delete selectCourts2[group_arr[i]];
            				$(blid).addClass('available');
            				$(blid).removeClass('selected');
                        }
                    }  
                }  
                //打包处理
			} else {
			    var selectNum=1;
                $.each(selectCourts, function(i,v){
    				selectNum++;
    			});
                if (selectNum > 4){
                    //utils.showError('最多选四个场次');
                    alert("最多选择四个场次");
                    return;
                }
                //push it to the array
   				selectCourts[curGid] = parseInt(el.html());
                selectCourts2[curGid] = el.attr('course_content');
   				el.removeClass('available');
   				el.addClass('selected');
                //打包处理
                var group_ids = el.attr('group_ids');
                var group_arr = new Array();
                if (group_ids != ''){
                    group_arr=group_ids.split(',');
                    for(var i=0;i<group_arr.length;i++){
                        var blid = "#block_"+group_arr[i];
                        if(!$(blid).hasClass('disable')){
                            selectCourts[group_arr[i]] = parseInt($(blid).html());
                            selectCourts2[group_arr[i]] = $(blid).attr('course_content');
           				    $(blid).removeClass('available');
           				    $(blid).addClass('selected');
                        }
                    }  
                }  
                //打包处理
                
                //是否登录,取消，add by chenchao 2015-02-10
                //var id = $('#client_uid').val();
                //if (id > 0){
                    //未支付订单，不再弹窗显示，后台自动取消并下单
                    //var order_count = $('#order_count').val();
                    /*if (order_count == '0'){  
                        //push it to the array
           				selectCourts[curGid] = parseInt(el.html());
                        selectCourts2[curGid] = el.attr('course_content');
           				el.removeClass('available');
           				el.addClass('selected');
                        //打包处理
                        var group_ids = el.attr('group_ids');
                        var group_arr = new Array();
                        if (group_ids != ''){
                            group_arr=group_ids.split(',');
                            for(var i=0;i<group_arr.length;i++){
                                var blid = "#block_"+group_arr[i];
                                if(!$(blid).hasClass('disable')){
                                    selectCourts[group_arr[i]] = parseInt($(blid).html());
                                    selectCourts2[group_arr[i]] = $(blid).attr('course_content');
                   				    $(blid).removeClass('available');
                   				    $(blid).addClass('selected');
                                }
                            }  
                        }  
                        //打包处理
                    }else{
                        $.dialog({
                            content : '<div style="padding-left:20px;">&nbsp;</div>',
                            title : '您有一笔未支付订单',
                            ok : function() {
                                location.href = '/order/pay?id='+order_count;
                            },
                            cancel : function() {
                                $.ajax({
                    				url: '/order/cancel',
                    				type: 'GET',
                    				dataType: 'JSON',
                    				cache: false,
                    				data: {
                    					id: order_count
                    				},
                    				success: function(res){
                                        var json=JSON.parse(res);
                    					if(json && json.code == 1){
                    						//todo:
                                            location.reload();
                    					} else {
                    						utils.showError(res.msg || '取消出错，请稍后再试试');
                    					} 
                    				},
                    				error: function(res){
                    					utils.showError(res.msg || '取消出错，请稍后再试试');
                    				}
                    			});
                            },
                            okText: '支 付',
                            cancelText: '取消',
                            lock : true,
                            width : 215,
                        });
                    }*/
                //}else{
                //    utils.getLogin();
                //}
			} 
			utils.updateSum();
		});

		$('.day-wrap').on(touchType, '.J_selectDay', function(){
			var el = $(this);
			utils.getCourtData({
				datetime: parseInt(el.attr('time'))
			});
		});

		$('.J_submit').on(touchType, function(){
            var gids = [];
		    $.each(selectCourts, function(i,v){
  				gids.push(i);
   			});
            if (gids.length > 0){
                //跳转确认页面
                $('.J_goodsIds').val(gids.join(','));
                $('.J_payConfirm').submit();
                /*
                $.dialog({
                    content : $('#modalContent').html(),
                    title : '确认场次信息',
                    ok : function() {
                        $.ajax({
            				url: '/order/doconfirm',
            				type: 'GET',
            				dataType: 'JSON',
            				cache: false,
            				data: {
            					goods_ids: gids.join(',')
            				},
            				success: function(res){
                                var json=JSON.parse(res);
            					if(json && json.code == 1){
            						//todo: modify the url
            						location.href = '/order/pay?id='+json.data;
            					} else {
            						utils.showError(res.msg || '支付出错，请稍后再试试');
            					} 
            				},
            				error: function(res){
            					utils.showError(res.msg || '支付出错，请稍后再试试');
            				}
            			});           
                    },
                    cancel : function() {
                        //alert("取消订单");
                    },
                    okText: '确定支付',
                    cancelText: '重新选择',
                    lock : true,
                    isclose : 1,
                    width : 240
                });*/
            }else{
                alert("请选择场次");
            }
          
		 /*	var gids = [];
			$.each(selectCourts, function(i,v){
				gids.push(i);
			});
		  $.ajax({
				url: '/order/doconfirm',
				type: 'GET',
				dataType: 'JSON',
				cache: false,
				data: {
					goods_ids: gids.join(',')
				},
				success: function(res){
                    var json=JSON.parse(res);
					if(json && json.code == 1){
						//todo: modify the url
						location.href = '/order/pay?id='+json.data;
					} else {
						utils.showError(res.msg || '支付出错，请稍后再试试');
					}
                    
				},
				error: function(res){
					utils.showError(res.msg || '支付出错，请稍后再试试');
				}
			});*/
		});
        
        $('.J_submit2').on(touchType, function(){
			var gids = [];
			$.each(selectCourts, function(i,v){
				gids.push(i);
			});
		  $.ajax({
				url: '/order/doconfirm',
				type: 'GET',
				dataType: 'JSON',
				cache: false,
				data: {
					goods_ids: gids.join(',')
				},
				success: function(res){
                    var json=JSON.parse(res);
					if(json && json.code == 1){
						//todo: modify the url
						location.href = '/order/pay?id='+json.data;
					} else {
						utils.showError(res.msg || '支付出错，请稍后再试试');
					}
				},
				error: function(res){
					utils.showError(res.msg || '支付出错，请稍后再试试');
				}
			});
		});
	};

	utils.getUrlParam();
	bindDOM();

	$('.J_selectDay.active').trigger(touchType);

})();