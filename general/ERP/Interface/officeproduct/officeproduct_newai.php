<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");
	validateMenuPriv("�칫��Ʒ�嵥");
	
	
	$productInfo=returntablefield("officeproduct", "���", $_GET['���'], "�칫��Ʒ���,�칫��Ʒ����,��ŵص�");
	$�칫��Ʒ���=$productInfo['�칫��Ʒ���'];
	$�칫��Ʒ����=$productInfo['�칫��Ʒ����'];
	$�ֿ�=$productInfo['��ŵص�'];
	if($_GET['action']=="ruku")		{
		
		print "<script>location.href='officeproductin_newai.php?".base64_encode("action=add_default&�칫��Ʒ���=$�칫��Ʒ���&�칫��Ʒ���_disabled=disabled&�칫��Ʒ����=$�칫��Ʒ����&�칫��Ʒ����_disabled=disabled&���ֿ�=$�ֿ�&���ֿ�_disabled=disabled")."';</script>";
		exit;
	}
	if($_GET['action']=="jieyong")		{

		print "<script>location.href='officeproductout_newai.php?".base64_encode("action=add_default&�칫��Ʒ���=$�칫��Ʒ���&�칫��Ʒ���_disabled=disabled&�칫��Ʒ����=$�칫��Ʒ����&�칫��Ʒ����_disabled=disabled&����ֿ�=$�ֿ�&����ֿ�_disabled=disabled")."';</script>";
		exit;
	}
	if($_GET['action']=="diaobo")		{

		print "<script>location.href='officeproducttiaoku_newai.php?".base64_encode("action=add_default&�칫��Ʒ���=$�칫��Ʒ���&�칫��Ʒ���_disabled=disabled&�칫��Ʒ����=$�칫��Ʒ����&�칫��Ʒ����_disabled=disabled&�����ֿ�=$�ֿ�&�����ֿ�_disabled=disabled")."';</script>";
		exit;
	}
	if($_GET['action']=="baofei")		{

		print "<script>location.href='officeproductbaofei_newai.php?".base64_encode("action=add_default&�칫��Ʒ���=$�칫��Ʒ���&�칫��Ʒ���_disabled=disabled&�칫��Ʒ����=$�칫��Ʒ����&�칫��Ʒ����_disabled=disabled&�����ֿ�=$�ֿ�&�����ֿ�_disabled=disabled")."';</script>";
		exit;
	}
	if($_GET['action']=="add_default")
	{
		$sql="select * from officeproductcangku";
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
		$userlist='';
		foreach ($rs_a as $row)
		{
			$userlist=$userlist.$row['�ֿ⸺����'];
		}
		$userArray=explode(",", $userlist);
		if(!in_array($_SESSION['LOGIN_USER_ID'],$userArray))
		{
			print "<script language=javascript>alert('ֻ�вֿ⸺������Ȩ���½������ڡ��ֿ����á������òֿ⸺����');window.history.go(-1);</script>";
			exit;	
		}
	}
	if($_GET['action']=="add_default_data")		{
		$id=returntablefield("officeproduct", "�칫��Ʒ���", $_POST["�칫��Ʒ���"], "�칫��Ʒ���","��ŵص�",$_POST["��ŵص�"]);
		if($id!='')
		{
			print "<script language=javascript>alert('�˲ֿ��Ѵ��ڴ˱�ŵİ칫��Ʒ�����ܱ���');window.history.back(-1);</script>";
			exit;	
		}
	}




$filetablename='officeproduct';
require_once('include.inc.php');
?>