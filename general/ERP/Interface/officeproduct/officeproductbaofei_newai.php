<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
if($_GET['action']=="add_default_data" || $_GET['action']=="add_default")
	validateMenuPriv("�칫��Ʒ�嵥");
else
	validateMenuPriv("���ϼ�¼");



if($_GET['action']=="add_default_data")		{
	page_css('�칫��Ʒ');
	$�칫��Ʒ��� = $_POST['�칫��Ʒ���'];
	$�칫��Ʒ���� = $_POST['�칫��Ʒ����'];
	$�����ֿ� = $_POST['�����ֿ�'];
	$�������� =$_POST['��������'];

	$kucun=returntablefield("officeproduct", "�칫��Ʒ���", $�칫��Ʒ���, "����","��ŵص�",$�����ֿ�);
	if($kucun<$��������)
	{
		print "<script language=javascript>alert('�˱�ŵİ칫��Ʒ��治��');window.history.back(-1);</script>";
		exit;	
	}
	
	$sql = "update officeproduct set ����=����-$��������,�ϼƽ��=round(����*����,2) where �칫��Ʒ���='$�칫��Ʒ���' and ��ŵص�='$�����ֿ�'";
	$db->Execute($sql);
	
}



$filetablename='officeproductbaofei';
require_once('include.inc.php');
?>