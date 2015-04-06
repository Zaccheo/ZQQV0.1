<?php

	/**
	 *describe 工具类
	 *author 杨志乾
	 *corporate 誉合誉科技有限公司
	 *version 1.0
	 *date 2014-12-28
	 *
	 */
	
class Util{

	public function getMillisecond(){

		$time = explode(" ", microtime());  
		$time = $time[1].($time[0]*1000);  
		$time2 = explode (".",$time);  
		$time = $time2 [0];
		return $time;
	}


	//获取日期的星期数
	public function getWeekDay(&$date){
		$weekarray=array("日","一","二","三","四","五","六");
 		return "星期".$weekarray[date("w",date('Y-m-d',strtotime($date)))];
	}



	public static function arrayRecursive(&$array, $function, $apply_to_keys_also = false){
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                self::arrayRecursive($array[$key], $function, $apply_to_keys_also);
            } else {
                $array[$key] = $function($value);
            }
     
            if ($apply_to_keys_also && is_string($key)) {
                $new_key = $function($key);
                if ($new_key != $key) {
                    $array[$new_key] = $array[$key];
                    unset($array[$key]);
                }
            }
        }
        $recursive_counter--;
    }

    /**************************************************************
     *
     *    将数组转换为JSON字符串（兼容中文）
     *    @param  array   $array      要转换的数组
     *    @return string      转换得到的json字符串
     *    @access public
     *
     *************************************************************/
    public static function JSON($array) {
        self::arrayRecursive($array, 'urlencode', true);
        $json = json_encode($array);
        return urldecode($json);
    }

    /**************************************************************
     *
     *    自动客服，发送推送消息给用户
     *    @param  $openId  $event  $content     
     *      当event是comment时，content传入str，当event是
     *    @return string      转换得到的json字符串
     *    @access public
     *
     *************************************************************/
    public static function SendPushMsg($openId,$event,$content){
        $post_data = array();
        $post_data['openId'] = $openId;
        $post_data['event'] = $event;
        if($event == "record" && is_array($content)){
            $post_data['content'] = self::JSON($content);
        }else{
            $post_data['content'] = $content;
        }
        //$ch = curl_init('http://www.xishuma.com/fb55/lanewechat/push/pushMsg.php');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.xishuma.com/fb55/lanewechat/push.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
    }

    /*
    *
    *构建星星，实心和空心，代表实力对比
    *
    */
    public static function buildForceStar($forces){
        $stars = "";
        for ($i = 0;$i < round($forces); $i++) {
            $stars .= "★";
        }
        for($j = 0; $j < (5 - round($forces)); $j++){
            $stars .= "☆";
        }
        return $stars;
    }
}