<?php
	require_once("lib.inc.php");
	
	$GLOBAL_SESSION=returnsession();

	$common_html=returnsystemlang('common_html');
	$_GET['action']=checkreadaction('init_customer');
	
	if($_GET['action']=="")		{
		$sql = "update fixedasset set 所属状态='购置未分配' where 所属状态=''";
		$db->Execute($sql);
		$sql = "update fixedasset set 金额=单价*数量";
		$db->Execute($sql);
	}

	$_GET['所属状态'] = "购置未分配,购置已分配,资产已分配,资产已归还";//资产已报废
	$_GET['searchfield'] = '资产批次';
	$_GET['searchvalue'] = $_GET['资产批次'];
	$_GET['action'] = 'init_customer_search';
	
	

	//$NEWAIINIT_VALUE_SYSTEM = "select `编号`,`资产编号`,`资产名称`,`资产批次`,`规格型号`,`所属状态`,`单位`,`数量`,`单价`,`金额`,`发票号码`,`所属部门`,`使用人员`,`购买日期`,`资产类别`,`凭证号码`,`存放地点`,`备注`,`创建人`,`创建时间` from fixedasset where (`所属状态`='购置未分配' or `所属状态`='购置已分配' or `所属状态`='资产已分配' or `所属状态`='资产已归还') order by 编号 desc";
	//$NEWAIINIT_VALUE_SYSTEM_NUM = "select count(`编号`) as num from fixedasset where (`所属状态`='购置未分配' or `所属状态`='购置已分配' or `所属状态`='资产已分配' or `所属状态`='资产已归还')";
	//print_R($_GET);

	$filetablename='fixedasset';
	$parse_filename = "fixedasset_pici_details";
	
	//$_GET['action']  = 'init_customer';
	require_once('include.inc.php');
	print "<BR>";
	print_close();
?>