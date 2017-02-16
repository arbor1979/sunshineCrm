<?php
	require_once('lib.inc.php');
	
	$GLOBAL_SESSION=returnsession();


	$_GET['action']=checkreadaction('init_customer');

	$_GET['维修状态'] = "是";
	$SYSTEM_ADD_SQL = " and 用料登记!=''";

	$filetablename='wygl_baoxiuxinxi';
	$parse_filename = 'wygl_baoxiuxinxi5';
	require_once('include.inc.php');
	 ?>