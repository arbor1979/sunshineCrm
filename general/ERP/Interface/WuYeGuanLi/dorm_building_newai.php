<?php
//ini_set("extension","");
$inis = ini_get("extension");

//print_r($inis);
require_once('lib.inc.php');

//######################�������-Ȩ�޽��鲿��##########################

require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");//
CheckSystemPrivate("���ڹ���-����ά��-¥������");
//######################�������-Ȩ�޽��鲿��##########################

$filetablename='dorm_building';
require_once('include.inc.php');


?>