<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();

	$common_html=returnsystemlang('common_html');


	$_GET['action']=checkreadaction('init_customer');

	if($_GET['所属状态']=="")		$_GET['所属状态'] = "购置未分配,购置已分配,资产已分配,资产已归还";


	//$SYSTEM_PRINT_SQL = 1;

	$filetablename='fixedasset';
	require_once('include.inc.php');

 ?>