<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//######################�������-Ȩ�޽��鲿��##########################

require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
CheckSystemPrivate("���ڹ���-����ά��-¥������");
//######################�������-Ȩ�޽��鲿��##########################

$filetablename='edu_building';
require_once('include.inc.php');

?>