<?php
	require_once("lib.inc.php");
	
	$GLOBAL_SESSION=returnsession();

	$common_html=returnsystemlang('common_html');
	

	$_GET['����״̬'] = "�ʲ��ѱ���";//�ʲ��ѱ���

	$_GET['ʹ����Ա'] = $_SESSION['LOGIN_USER_NAME'];
	//��У���鿴Ȩ�޽������ⶨ��
	if($_GET['ָ����Ա']!="")			{
		$ָ����Ա���� = returntablefield("user","USER_ID",$_GET['ָ����Ա'],"USER_NAME");
		$_GET['ʹ����Ա'] = $ָ����Ա����;
	}
	else	{
		$_GET['ʹ����Ա'] = $_SESSION['LOGIN_USER_NAME'];
	}

	$filetablename='fixedasset';
	$parse_filename = "my_fixedassetbaofeilist";
	require_once('include.inc.php');

?>