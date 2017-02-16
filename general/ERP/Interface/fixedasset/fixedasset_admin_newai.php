<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-固定资产-资产管理员");

	$common_html=returnsystemlang('common_html');

	//用于定义高级查询转自定义导出字段的部分
	//$SYSTEM_ADVANCE_SEARCH_TO_DEFINE = "1";

	if($_GET['action']==""||$_GET['action']=="init_default")		{
		$sql = "update fixedasset set 所属状态='购置未分配' where 所属状态=''";
		$db->Execute($sql);
		$sql = "update fixedasset set 金额=单价*数量";
		$db->Execute($sql);
	}

	if($_GET['action']=="edit_default_data")		{
		//print_R($_GET);print_R($_SESSION);print_R($_POST);exit;
		$_POST['单价'] = number_format($_POST['单价'], 2, '.', '');
	}

	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);exit;
		$_POST['单价'] = number_format($_POST['单价'], 2, '.', '');
	}

	$_GET['所属状态'] = "购置未分配,购置已分配,资产已分配,资产已归还";//资产已报废

	$filetablename='fixedasset';
	$parse_filename = "fixedasset_admin";
	require_once('include.inc.php');

?>