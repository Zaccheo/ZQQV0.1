<?php

/**
*describe 数据库连接操作类
*author 杨志乾
*corporate 四川誉合誉科技有限公司
*version 1.0
*date 2014-12-28
*
*/

class Db {
	static private $_instance;
	static private $_connectSource;
	private $_dbConfig = array(
		// 'host' => '127.0.0.1',
		// 'user' => 'root',
		// 'password' => '',
		// 'database' => 'zqq',
		'host' => 'sql.w108.vhostgo.com',
		'user' => 'mysqladmin',
		'password' => 'q1w2e3r4t5y6',
		'database' => 'mysqladmin',
	);

	private function __construct() {
	}

	static public function getInstance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function connect() {
		if(!self::$_connectSource) {
			self::$_connectSource = @mysql_connect($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['password']);	

			if(!self::$_connectSource) {
				throw new Exception('mysql connect error ' . mysql_error());
			}
			
			mysql_select_db($this->_dbConfig['database'], self::$_connectSource);
			mysql_query("set names UTF8", self::$_connectSource);
		}
		return self::$_connectSource;
	}
}
