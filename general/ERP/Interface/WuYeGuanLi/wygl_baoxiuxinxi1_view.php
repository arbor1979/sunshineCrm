<?php
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();
$_GET['action']=checkreadaction('init_customer');


$filetablename='wygl_baoxiuxinxi';
$parse_filename = 'wygl_baoxiuxinxi1';
require_once('include.inc.php');
?>