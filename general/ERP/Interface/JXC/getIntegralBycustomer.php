<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$customerid = $_GET["customerid"];

header ("content-type: text/xml");
$doc=new DOMDocument("1.0","GBK"); #�����ĵ�����
$doc->formatOutput=true;               #���ÿ����������
#�������ڵ㣬���һ��XML�ļ��и����ڵ�
$root=$doc->createElement("root");    #�����ڵ����ʵ��
$root=$doc->appendChild($root);      #�ѽڵ���ӽ���

$integral=returntablefield("customer", "rowid", $customerid, "integral");
$integralNode=$doc->createElement("integral");
$integralNode=$root->appendChild($integralNode);  
$integralNode->appendChild($doc->createTextNode(intval($integral)));

global $db;
$sql = "select sum(integral) as sum from exchange where customid='$customerid'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();

$sumnod=$doc->createElement("sumnod");    #�����ڵ����ʵ��
$sumnod=$root->appendChild($sumnod);      #�ѽڵ���ӽ���
$sumnod->appendChild($doc->createTextNode(intval($rs_a[0][sum])));

echo $doc->saveXML();

?>
