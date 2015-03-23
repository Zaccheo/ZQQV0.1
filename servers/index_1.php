<?php

	require_once('./Response.php');
	require_once('./DB.php');

	$sql = "select * from `zqq_users_info`";
	$connect = Db::getInstance()->connect();
	$result = mysql_query($sql, $connect);
	echo Response::show(200, 'SUCCESS', mysql_fetch_array($result), null);

