<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();

	require_once("systemprivateinc.php");
if($_GET['action']=="add_default_data" || $_GET['action']=="add_default")
	validateMenuPriv("�칫��Ʒ�嵥");
else
	validateMenuPriv("����¼");


if($_GET['action']=="add_default_data")		{
	page_css();
	$�칫��Ʒ��� = $_POST['�칫��Ʒ���'];
	$���ֿ� = $_POST['���ֿ�'];
	$sql = "update officeproduct set ����=����+".$_POST['�������'].",�ϼƽ��=round(����*����,2) where �칫��Ʒ���='$�칫��Ʒ���' and ��ŵص�='$���ֿ�'";
	$db->Execute($sql);
	
}


$filetablename='officeproductin';
require_once('include.inc.php');
?>