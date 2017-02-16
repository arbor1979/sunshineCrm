<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();



$_GET['action']=checkreadaction('init_customer');


$filetablename='officeproductin';
require_once('include.inc.php');
 ?>