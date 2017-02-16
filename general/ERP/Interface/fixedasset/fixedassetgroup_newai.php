<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-固定资产-分类设置");
$filetablename='fixedassetgroup';
require_once('include.inc.php');
?>