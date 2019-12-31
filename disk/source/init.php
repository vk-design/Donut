<?php
	session_start();
	require_once get_template_directory() . '/disk/source/config.php';
	require_once get_template_directory() . '/disk/class/upyun.class.php';
	$upyun = new UpYun(UPYUN_BUCKETNAME,UPYUN_USERNAME,UPYUN_PASSWORD);
