<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();



	//$_GET['����״̬'] = "�ʲ��ѱ���";//�ʲ��ѱ���

	$_GET['������'] = $_SESSION['LOGIN_USER_NAME'];
	//��У���鿴Ȩ�޽������ⶨ��
	if($_GET['ָ����Ա']!="")			{
		$ָ����Ա���� = returntablefield("user","USER_ID",$_GET['ָ����Ա'],"USER_NAME");
		$_GET['������'] = $ָ����Ա����;
	}
	else	{
		$_GET['������'] = $_SESSION['LOGIN_USER_NAME'];
	}
	$filetablename='fixedassetout';
	$parse_filename = "my_fixedassetout";

require_once('include.inc.php');

require_once('../Help/module_fixxedasset.php');

?>