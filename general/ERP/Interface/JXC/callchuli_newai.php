<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	
	if($_GET['action']=="edit_default_data")		{
		if($_POST['ifchuli']=='是')
			$_POST['chulitime']=date("Y-m-d H:i:s");
		else
			$_POST['chulitime']='';
		
	}
	if($_GET['action']=="newchance")		{
		$customerid=returntablefield("callchuli", "id", $_GET["id"], "customerid");
		print "<script>location.href='crm_chance_newai.php?action=add_default&customerid=".$customerid."';</script>";
		exit;
	
	}
	
	addShortCutByDate("createtime","创建时间");
	$SYSTEM_ADD_SQL=getRoleByUser($SYSTEM_ADD_SQL,"createman"); 
	$limitEditDelUser='createman';
	//数据表模型文件,对应Model目录下面的callchuli_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'callchuli';
	$parse_filename		=	'callchuli';
	require_once('include.inc.php');
	?>