<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("���ڹ���-�̶��ʲ�-�ʲ�����Ա");

	$common_html=returnsystemlang('common_html');

	//���ڶ���߼���ѯת�Զ��嵼���ֶεĲ���
	//$SYSTEM_ADVANCE_SEARCH_TO_DEFINE = "1";

	if($_GET['action']==""||$_GET['action']=="init_default")		{
		$sql = "update fixedasset set ����״̬='����δ����' where ����״̬=''";
		$db->Execute($sql);
		$sql = "update fixedasset set ���=����*����";
		$db->Execute($sql);
	}

	if($_GET['action']=="edit_default_data")		{
		//print_R($_GET);print_R($_SESSION);print_R($_POST);exit;
		$_POST['����'] = number_format($_POST['����'], 2, '.', '');
	}

	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);exit;
		$_POST['����'] = number_format($_POST['����'], 2, '.', '');
	}

	$_GET['����״̬'] = "����δ����,�����ѷ���,�ʲ��ѷ���,�ʲ��ѹ黹";//�ʲ��ѱ���

	$filetablename='fixedasset';
	$parse_filename = "fixedasset_admin";
	require_once('include.inc.php');

?>