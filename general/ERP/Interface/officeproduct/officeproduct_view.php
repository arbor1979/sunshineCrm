<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("���ڹ���-�칫��Ʒ-�칫��Ʒ����");


	$_GET['action']=checkreadaction('init_customer');

	$filetablename='officeproduct';
	require_once('include.inc.php');
	
 ?>