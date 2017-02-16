<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("需求与方案");
	$customerid=$_GET['customerid'];
	if($customerid!='' && $_GET['action']=='add_default')
	{
		$ADDINIT=array("customerid"=>$customerid);
	}

	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"customerid");
	$limitEditDelCust='customerid';
	//数据表模型文件,对应Model目录下面的customer_xuqiu_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	addShortCutByDate("createtime","创建时间");
	$filetablename		=	'customer_xuqiu';
	$parse_filename		=	'customer_xuqiu';
	require_once('include.inc.php');
	?>