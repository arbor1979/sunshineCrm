<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();

	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-办公用品-操作明细");



$_GET['出库性质'] = "领用";


$filetablename='officeproductout';
$parse_filename = 'officeproductlingyong';
require_once('include.inc.php');
?>