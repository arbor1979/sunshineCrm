<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();

	$common_html=returnsystemlang('common_html');

	if($_GET['action']=="")		{
		$sql = "update fixedasset set ����״̬='����δ����' where ����״̬=''";
		$db->Execute($sql);
		$sql = "update fixedasset set ���=����*����";
		$db->Execute($sql);
	}




	//###########################################
	//����ֲ��Ź���Ȩ�޲���
	//###########################################
	//��У���鿴Ȩ�޽������ⶨ��
	//print_R($_GET);
	if($_GET['ָ����Ա']!="")			{
		$ָ����Ա���� = returntablefield("user","USER_ID",$_GET['ָ����Ա'],"USER_NAME");
		$_GET['ʹ����Ա'] = $ָ����Ա����;
	}
	else	{
		$_GET['ʹ����Ա'] = $_SESSION['LOGIN_USER_NAME'];
	}

	$_GET['����״̬'] = "����δ����,�����ѷ���,�ʲ��ѷ���,�ʲ��ѹ黹";	//,�ʲ��ѱ���
	//print_R($_GET);
	$filetablename='fixedasset';
	$parse_filename = 'fixedasset_my';
	require_once('include.inc.php');


require_once('../Help/module_fixxedasset.php');

?>