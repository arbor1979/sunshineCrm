<?php
	require_once('lib.inc.php');
	
	$GLOBAL_SESSION=returnsession();


	$_GET['action']=checkreadaction('init_customer');

	$_GET['ά��״̬'] = "��";
	$SYSTEM_ADD_SQL = " and ���ϵǼ�!=''";

	$filetablename='wygl_baoxiuxinxi';
	$parse_filename = 'wygl_baoxiuxinxi5';
	require_once('include.inc.php');
	 ?>