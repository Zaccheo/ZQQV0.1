<?php
	require_once('jssdk.php');
	
	$jssdk = new JSSDK("wx1d7118856baf94c5", "67a7586f1701e8734c2bd2886e1bc075");
	$signPackage = $jssdk->GetSignPackage();

	$wxconArr = array();
	$wxconArr['appId'] = $signPackage["appId"];
	$wxconArr['timestamp'] = $signPackage["timestamp"];
	$wxconArr['nonceStr'] = $signPackage["nonceStr"];
	$wxconArr['signature'] = $signPackage["signature"];

	$wxconJson = json_encode($wxconArr);
?>