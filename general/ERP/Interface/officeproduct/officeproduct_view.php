<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-办公用品-办公用品查阅");


	$_GET['action']=checkreadaction('init_customer');

	$filetablename='officeproduct';
	require_once('include.inc.php');
	
 ?>