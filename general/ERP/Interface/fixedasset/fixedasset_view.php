<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();

	$common_html=returnsystemlang('common_html');


	$_GET['action']=checkreadaction('init_customer');

	if($_GET['����״̬']=="")		$_GET['����״̬'] = "����δ����,�����ѷ���,�ʲ��ѷ���,�ʲ��ѹ黹";


	//$SYSTEM_PRINT_SQL = 1;

	$filetablename='fixedasset';
	require_once('include.inc.php');

 ?>