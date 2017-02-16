<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();


$_GET['action']=checkreadaction('init_customer');


$filetablename='officeproducttiaoku';
require_once('include.inc.php');
 ?>