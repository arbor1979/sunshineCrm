<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$customerid = $_GET["customerid"];

header ("content-type: text/xml");
$doc=new DOMDocument("1.0","GBK"); #声明文档类型
$doc->formatOutput=true;               #设置可以输出操作
#声明根节点，最好一个XML文件有个跟节点
$root=$doc->createElement("root");    #创建节点对象实体
$root=$doc->appendChild($root);      #把节点添加进来

$integral=returntablefield("customer", "rowid", $customerid, "integral");
$integralNode=$doc->createElement("integral");
$integralNode=$root->appendChild($integralNode);  
$integralNode->appendChild($doc->createTextNode(intval($integral)));

global $db;
$sql = "select sum(integral) as sum from exchange where customid='$customerid'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();

$sumnod=$doc->createElement("sumnod");    #创建节点对象实体
$sumnod=$root->appendChild($sumnod);      #把节点添加进来
$sumnod->appendChild($doc->createTextNode(intval($rs_a[0][sum])));

echo $doc->saveXML();

?>
