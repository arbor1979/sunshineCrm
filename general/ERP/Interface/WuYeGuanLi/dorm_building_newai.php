<?php
//ini_set("extension","");
$inis = ini_get("extension");

//print_r($inis);
require_once('lib.inc.php');

//######################教育组件-权限较验部分##########################

require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");//
CheckSystemPrivate("后勤管理-公物维修-楼房设置");
//######################教育组件-权限较验部分##########################

$filetablename='dorm_building';
require_once('include.inc.php');


?>