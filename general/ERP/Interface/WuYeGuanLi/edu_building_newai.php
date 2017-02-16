<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//######################教育组件-权限较验部分##########################

require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
CheckSystemPrivate("后勤管理-公物维修-楼房设置");
//######################教育组件-权限较验部分##########################

$filetablename='edu_building';
require_once('include.inc.php');

?>