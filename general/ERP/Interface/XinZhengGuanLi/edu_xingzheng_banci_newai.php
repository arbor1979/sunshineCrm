<?php
	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");
	
	CheckSystemPrivate("人力资源-行政考勤-班次");
	$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
	if($_GET['学期']=="") $_GET['学期'] = $当前学期;

	session_register("是否执行特定函数");
	if($_SESSION['是否执行特定函数']=="")			{
		$_SESSION['是否执行特定函数'] = 0;
	}
	if($_SESSION['是否执行特定函数']=="1")			{
		过滤行政考勤非法数据();
		$_SESSION['是否执行特定函数'] = 0;
	}
	//print_R($_SESSION);

	if($_GET['action']=='edit_default_data')		{
		$_SESSION['是否执行特定函数'] = "1";
		//exit;
	}
	if($_GET['action']=='delete_array')				{
		$_SESSION['是否执行特定函数'] = "1";
	}


	$filetablename='edu_xingzheng_banci';
	require_once('include.inc.php');


	if($_GET['action']==''||$_GET['action']=='init_default')		{
		require_once('../Help/module_xingzhengkaoqin_banci.php');
		//过滤非法数据
		//定时执行函数("过滤行政考勤非法数据",30);
		//过滤行政考勤非法数据();
	}


	function 过滤行政考勤非法数据()		{
		global $db,$当前学期;
		$sql = "delete from edu_xingzheng_kaoqinmingxi where 班次 not in (select 班次名称 from edu_xingzheng_banci) and 学期='$当前学期'";
		$db->Execute($sql);
		//print $sql."<BR>";
		$sql = "delete from edu_xingzheng_paiban where 班次名称 not in (select 班次名称 from edu_xingzheng_banci) and 学期名称='$当前学期'";
		$db->Execute($sql);
		//print $sql."<BR>";
	}
	?>