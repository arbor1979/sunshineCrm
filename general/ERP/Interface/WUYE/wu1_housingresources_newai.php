<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

	$_GET['单元状态'] = "空";

	$filetablename		=	'wu_housingresources';
	$parse_filename		=	'wu1_housingresources';
	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		说明：<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;1 如果此房间已售出，则首先完善客户资料。则点击操作管理项下的新增客户进入客户新增页面，然后完善资料保存。<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;2 点击操作管理项下的新增客户进入客户新增页面，然后完善资料保存。<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;3 客户资料完善后，点击操作管理项下的新增房间管理按钮，完善房间具体资料。<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;4 <font color=\"red\">注意：</font>在点击新增房间管理页面里将房间状态改为”非空“。<BR>
		</font></td></table>";
		print $PrintText;
	}
	?>
