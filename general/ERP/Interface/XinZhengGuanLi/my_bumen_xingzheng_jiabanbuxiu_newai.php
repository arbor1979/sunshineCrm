<?php

	require_once('lib.inc.php');//



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	//CheckSystemPrivate("人力资源-行政考勤-部门级管理");



	$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
	if($_GET['学期']=="") $_GET['学期'] = $当前学期;




	//班次过滤部分,班次字段必须设为隐藏分组属性--开始
	$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
	$sql = "select 班次名称 from edu_xingzheng_banci where 班次管理一='$LOGIN_USER_NAME' or 班次管理二='$LOGIN_USER_NAME'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$班次名称 = array();
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$Element = $rs_a[$i];
		$班次名称[]  = $Element['班次名称'];
	}
	$班次名称TEXT = join(',',$班次名称);
	if($班次名称TEXT=="")		{
		//$班次名称TEXT = "没有所管理的班次信息";
		//$_GET['原班次'] = $班次名称TEXT;
	}
	else	{
		$_GET['原班次'] = $班次名称TEXT;
	}
	//班次过滤部分,班次字段必须设为隐藏分组属性--结束

	//###########################################
	//较验分部门管理权限部分-开始
	//###########################################
	$SCRIPT_NAME	= "edu_xingzhengkaoqin_newai.php";
	$LOGIN_USER_ID		= $_SESSION['LOGIN_USER_ID'];
	$sql = "select * from systemprivateinc where `FILE`='$SCRIPT_NAME' and (USER_ID like '%,".$LOGIN_USER_ID.",%' or USER_ID like '".$LOGIN_USER_ID.",%')";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$MODULE_ARRAY = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$MODULE_ARRAY[] = $rs_a[$i]['MODULE'];
	}
	$MODULE_TEXT = join(',',$MODULE_ARRAY);
	//if($MODULE_TEXT=="")  $MODULE_TEXT = "未指定部门信息";
	//if($_GET['action']==""||$_GET['action']=="init_default")

	if($MODULE_TEXT==""&&$班次名称TEXT!="")		{
		//$班次名称TEXT = "没有所管理的班次信息";
		//$_GET['原班次'] = $班次名称TEXT;
	}
	elseif($MODULE_TEXT==""&&$班次名称TEXT=="")		{
		$_GET['部门'] = "没有所管理的班次或部门信息";
	}
	else	{
		$_GET['部门'] = $MODULE_TEXT;
	}
	//$SYSTEM_PRINT_SQL = 1;
	//###########################################
	//较验分部门管理权限部分-结束
	//###########################################


	$filetablename='edu_xingzheng_jiabanbuxiu';
	$parse_filename = 'my_bumen_xingzheng_jiabanbuxiu';



	require_once('include.inc.php');

	?>