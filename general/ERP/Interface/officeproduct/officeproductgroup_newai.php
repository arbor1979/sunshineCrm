<?php
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();

	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-办公用品-分类设置");
$filetablename='officeproductgroup';
require_once('include.inc.php');
?>