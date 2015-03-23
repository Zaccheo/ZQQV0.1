<?php
	$filename = "matchDetail.json"; 
	$handle = fopen($filename, "r"); 
	$contents = fread($handle, filesize($filename)); 
	fclose($handle);
	echo json_decode($contents);
?>