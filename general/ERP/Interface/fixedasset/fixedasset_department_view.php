<?php
	require_once("lib.inc.php");
	
	$GLOBAL_SESSION=returnsession();

	$common_html=returnsystemlang('common_html');



	$_GET['所属部门'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");

	$_GET['所属状态'] = "购置未分配,购置已分配,资产已分配,资产已归还";

	$_GET['action']=checkreadaction('init_customer');

	$filetablename='fixedasset';
	$parse_filename = 'fixedasset_department';

	print "<script>name = \"win\";</script><div align=left >&nbsp;<a href=\"#\" onClick=\"history.goback();\" target=win>点击查看部门所属资产列表</a></div>";
	require_once('include.inc.php');

 ?>