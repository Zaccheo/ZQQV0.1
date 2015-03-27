<?php

	/**
	 *describe 批量添加球场预约信息
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *注意mysql的dayofweek(日期),返回:星期日=1，星期一=2....星期六=7
	 */

	require_once('./Response.php');
	require_once('./DB.php');
// $param='{"sDate":"2015-01-26","eDate":"2015-04-05","ptcId":"1",
//     "dates2BeAdded":["2015-01-26","2015-01-27","2015-01-28","2015-01-29",
//     "2015-01-30","2015-02-02","2015-02-03","2015-02-04",
//     "2015-02-05","2015-02-06","2015-02-09","2015-02-10","2015-02-11",
//     "2015-02-12","2015-02-13","2015-02-16","2015-02-17","2015-02-18","2015-02-19",
//     "2015-02-20","2015-02-23","2015-02-24","2015-02-25","2015-02-26","2015-02-27",
//     "2015-03-02","2015-03-03","2015-03-04","2015-03-05","2015-03-06","2015-03-09",
//     "2015-03-10","2015-03-11","2015-03-12","2015-03-13","2015-03-16","2015-03-17",
//     "2015-03-18","2015-03-19","2015-03-20","2015-03-23","2015-03-24","2015-03-25",
//     "2015-03-26","2015-03-27","2015-03-30","2015-03-31","2015-04-01","2015-04-02","2015-04-03"],"pitchInfo":[{"startTime":"18:00","endTime":"19:30","charge":"360","credits":"360"},{"startTime":"20:00","endTime":"21:30","charge":"360","credits":"360"}]}';
	$param = isset($_POST['param']) ? $_POST['param'] : null;//
	if (empty($param)){
	    echo Response::show(300,"参数为空！",array(),null);
	}
	
//{"sDate":"2015-01-26","eDate":"2015-04-05","ptcId":"1",
//"dates2BeAdded":["2015-1-26","2015-1-27","2015-1-28","2015-1-29","2015-1-30","2015-2-2","2015-2-3","2015-2-4","2015-2-5","2015-2-6","2015-2-9","2015-2-10","2015-2-11","2015-2-12","2015-2-13","2015-2-16","2015-2-17","2015-2-18","2015-2-19","2015-2-20","2015-2-23","2015-2-24","2015-2-25","2015-2-26","2015-2-27","2015-3-2","2015-3-3","2015-3-4","2015-3-5","2015-3-6","2015-3-9","2015-3-10","2015-3-11","2015-3-12","2015-3-13","2015-3-16","2015-3-17","2015-3-18","2015-3-19","2015-3-20","2015-3-23","2015-3-24","2015-3-25","2015-3-26","2015-3-27","2015-3-30","2015-3-31","2015-4-1","2015-4-2","2015-4-3"],
//"pitchInfo":[{"startTime":"18:00","endTime":"19:30","charge":"360","credits":"360"}]}
	$json = json_decode($param);
	
	$sDate = $json->sDate;
	$eDate = $json->eDate;
	$ptcId = $json->ptcId;//球场信息ID
	$dates2BeAdded = $json->dates2BeAdded;
	$pitchInfo = $json->pitchInfo;//球场预约定价信息列表
	
    $connect = Db::getInstance()->connect();
	date_default_timezone_set('PRC');
	$temp = getDates2BeOperated($connect,$dates2BeAdded,$ptcId);//筛选出需要操作的日期
	//echo convert($temp);
	//删除原有的数据
	$flag = false;
	if (delete($connect,$temp,$ptcId)==true){
        //重组传入的数据参数，将开始时间和结束时间按照场分数数拆开
        $pitchInfoProcess = rebuildPitchInfo($pitchInfo);
		$flag = insert($connect,$temp,$ptcId,$pitchInfoProcess);
	}
	if ($flag==true){
		echo Response::show(200,"添加成功！",array(),null);
	}else{
		echo Response::show(201,"添加失败",array(),null);
	}
		
function delete($connect,$dates2BeAdded,$ptcId){
    $tmp = convert($dates2BeAdded);
    $query = "delete from `zqq_pitchs_order_info` where pitchInfoID=".$ptcId." and orderStatus=0 and zDate in(".$tmp.")";
    return mysql_query($query,$connect);
} 

//创建球场定价信息
function insert($connect,$dates2BeAdded,$ptcId,$pitchInfo){
    $addptch = "insert into `zqq_pitchs_order_info` (zDate,startTime,endTime,charge,credits,pitchInfoID) values ";
    // $count1 = ;
    // $count2 = 
    //echo Response::show(200,"测试！",$pitchInfo,null);;

    for ($i=0;$i<count($dates2BeAdded);$i++){
        for($j=0;$j<count($pitchInfo);$j++){
            if($i > 0 || $j > 0){
                $addptch .= ",";
            }
            $addptch .= '("'.$dates2BeAdded[$i].'","'.$pitchInfo[$j]['startTime'].'","'.$pitchInfo[$j]['endTime'].'",'.$pitchInfo[$j]['charge'].','.$pitchInfo[$j]['credits'].','.$ptcId.')';
        }
    }
    if(mysql_query($addptch,$connect)==false){
        return false;
    }
    return true;
}
//筛选出已有场次预约的日期.
function getDatesDoNot2BeOperated($connect,$dates2BeAdded,$ptcId){
    $tmp = convert($dates2BeAdded);
    $selectSQL = "select distinct zDate from `zqq_pitchs_order_info` where pitchInfoID=".$ptcId." and orderStatus<>0 and zDate in(".$tmp.")";
    $result = mysql_query($selectSQL,$connect);
    $results = array();
    while ($row = mysql_fetch_assoc($result)) {
        //组装查询到的列
        $results[] = $row;
    }
    return $results;
}
function getDates2BeOperated($connect,$dates2BeAdded,$ptcId){
    $temp = getDatesDoNot2BeOperated($connect,$dates2BeAdded,$ptcId);
    $count = count($temp);
    for ($i=0;$i<$count;$i++){
        array_splice($dates2BeAdded,array_search($temp[$i]['zDate'], $dates2BeAdded),1);
    }
    return $dates2BeAdded;
}
//将数组转换成字符串"'2015-01-26','2015-01-27'"
function convert($dates2BeAdded){
    $tmp = "";
    $count = count($dates2BeAdded);
    for ($i=0;$i<$count;$i++){
        $tmp .= "'".$dates2BeAdded[$i]."'";
        if ($i<$count-1){
            $tmp .= ",";
        }
    }
    return $tmp;
}


//重组一次传入的球场信息，将数据处理拆开成按场次的数据包
function rebuildPitchInfo($pitchInfo){
    $rePitchInfo = array();
    foreach ($pitchInfo as $value) {
        $stime = $value->startTime;
        $etime = $value->endTime;
        $otime = $value->oneTime;
        $stime = explode(":",$stime);//开始时间
        $etime = explode(":",$etime);//结束时间
        $shour = $stime[0];
        $smin = $stime[1];
        $ehour = $etime[0];
        $emin = $etime[1];

        $differHour = abs($shour-$ehour);
        $differMin = abs($smin-$emin);
        $differ = $differHour*60 + $differMin;
        $lenth = $differ/$otime;//一天时间设置起始场次
        $stidx = $value->startTime;
        for($i=0;$i<$lenth;$i++){
            $rpi = array();
            $rpi['startTime']=$stidx;
            $rpi['endTime']=timeCalcul($stidx,$otime);
            $rpi['charge'] = $value->charge;
            $rpi['credits'] = $value->credits;
            $rePitchInfo[] = $rpi;
            $stidx = timeCalcul($stidx,$otime);
        }
    }
    return $rePitchInfo;
}

//时间计算，增加进位
function timeCalcul($time,$submin){
    //submin转换为小时制
    $stime = explode(":",$time);//开始时间
    $hour = $stime[0]+floor($submin/60);//小时
    $min = $stime[1]+$submin%60;//分钟
    if($min>=60){
        $hour = $hour+1;
        $min = $min-60;
    }
    return substr(strval($hour+100),1,2).":".substr(strval($min+100),1,2);
}