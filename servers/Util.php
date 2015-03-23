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
}