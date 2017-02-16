<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();

$_GET['action']=checkreadaction('init_customer');

$_GET['出库性质'] = "领用";


$filetablename='officeproductout';
$parse_filename = 'officeproductlingyong';
require_once('include.inc.php');
 ?>