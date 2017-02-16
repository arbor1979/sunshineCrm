<?php
	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");

	CheckSystemPrivate("人力资源-行政考勤-考勤数据");
	$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
	if($_GET['学期']=="") $_GET['学期'] = $当前学期;



	addShortCutByDate("日期");


	if($_GET['人员用户名']!="")			{
		$_GET['人员用户名'] = addslashes($_GET['人员用户名']);
		$SYSTEM_ADD_SQL .= " and 人员用户名='".$_GET['人员用户名']."'";
	}

	$filetablename='edu_xingzheng_kaoqinmingxi';
	require_once('include.inc.php');

	require_once('../Help/module_xingzhengkaoqin_datalist.php');

	?>