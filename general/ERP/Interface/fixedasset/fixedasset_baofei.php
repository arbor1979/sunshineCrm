<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-固定资产-已报废资产");

	$common_html=returnsystemlang('common_html');


	$_GET['所属状态'] = "资产已报废";//资产已报废

	$filetablename='fixedasset';
	$parse_filename = "fixedassetbaofeilist";
	require_once('include.inc.php');


	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >

	注意：<BR>
	&nbsp;&nbsp;①此部分显示的是已报废固定资产的所有属性信息,不是报废时产生的状态信息。<BR>
	&nbsp;&nbsp;②报废时产生的状态信息请在'固定资产报废明细'菜单进行查询。
	</font></td></table>";
		print $PrintText;
	}

?>