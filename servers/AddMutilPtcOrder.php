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
    
	$param = isset($_POST['param']) ? $_POST['param'] : null;//
	/*Start testing
	$connect = Db::getInstance()->connect();
	date_default_timezone_set('PRC');
	$s1 = "insert into test(username,sex) values('username1',1)";
	$s2 = "insert into test(username,sex) values('username2',null)";
	$s3 = "insert into test(username,sex) values('username3',3)";
	
	mysql_query("START TRANSACTION;",$connect);
	
	$r1 = mysql_query($s1,$connect);
	$r2 = mysql_query($s2,$connect);
	$r3 = mysql_query($s3,$connect);
	
	if($r1 && $r2 && $r3){
	    mysql_query("COMMIT;",$connect);
	}else{
	    mysql_query("ROLLBACK;",$connect);
	}
	//*///End testing
	//*
	if (empty($param)){
	    echo Response::show(300,"参数为空！",array(),null);
	}
	

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
	$error = null;
	$deleteResult = delete($connect,$temp,$ptcId);
	
	$insertResult = false;
	if ($deleteResult==true){
	    $insertResult = insert($connect,$temp,$ptcId,$pitchInfo);
	}else{
	    $error = mysql_error($connect);
	}
	if ($insertResult==true){
		echo Response::show(200,"添加成功！",array(),null);
	}else{
	    $error = mysql_error($connect);
		echo Response::show(201,"添加失败:".$error,array(),null);
	}
	//*/	
function delete($connect,$dates2BeAdded,$ptcId){
    $tmp = convert($dates2BeAdded);
    $query = "delete from `zqq_pitchs_order_info` where pitchInfoID=".$ptcId." and orderStatus=0 and zDate in(".$tmp.")";
    return mysql_query($query,$connect);
} 

//创建球场定价信息
function insert($connect,$dates2BeAdded,$ptcId,$pitchInfo){
    $addptch = "insert into `zqq_pitchs_order_info` (zDate,startTime,endTime,charge,credits,pitchInfoID,oneTime) values ";
    // $count1 = ;
    // $count2 = 
    //echo Response::show(200,"测试！",$pitchInfo,null);;

    for ($i=0;$i<count($dates2BeAdded);$i++){
        for($j=0;$j<count($pitchInfo);$j++){
            if($i > 0 || $j > 0){
                $addptch .= ",";
            }
            $addptch .= "('".$dates2BeAdded[$i]."','".$pitchInfo[$j]->startTime."','".$pitchInfo[$j]->endTime."',"
                .$pitchInfo[$j]->charge.",".$pitchInfo[$j]->credits.",".$ptcId.",".$pitchInfo[$j]->oneTime.")";
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