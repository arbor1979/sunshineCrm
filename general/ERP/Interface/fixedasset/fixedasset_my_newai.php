<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();

	$common_html=returnsystemlang('common_html');

	if($_GET['action']=="")		{
		$sql = "update fixedasset set 所属状态='购置未分配' where 所属状态=''";
		$db->Execute($sql);
		$sql = "update fixedasset set 金额=单价*数量";
		$db->Execute($sql);
	}




	//###########################################
	//较验分部门管理权限部分
	//###########################################
	//对校长查看权限进行特殊定义
	//print_R($_GET);
	if($_GET['指定人员']!="")			{
		$指定人员姓名 = returntablefield("user","USER_ID",$_GET['指定人员'],"USER_NAME");
		$_GET['使用人员'] = $指定人员姓名;
	}
	else	{
		$_GET['使用人员'] = $_SESSION['LOGIN_USER_NAME'];
	}

	$_GET['所属状态'] = "购置未分配,购置已分配,资产已分配,资产已归还";	//,资产已报废
	//print_R($_GET);
	$filetablename='fixedasset';
	$parse_filename = 'fixedasset_my';
	require_once('include.inc.php');


require_once('../Help/module_fixxedasset.php');

?>