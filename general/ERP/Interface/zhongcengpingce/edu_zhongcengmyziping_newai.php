<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("������Դ-�ɲ�����-�����ҵ�����");


	$_GET['������Ա'] = $_SESSION['LOGIN_USER_NAME'];


	$filetablename='edu_zhongcengrenyuan';
	$parse_filename = 'edu_zhongcengmyziping';

	require_once('include.inc.php');

	?>