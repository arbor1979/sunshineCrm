<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP="1";
	require_once("systemprivateinc.php");

	CheckSystemPrivate("���ڹ���-����ά��-���ý���");

	addShortCutByDate("����ʱ��");


	$_GET['ά��״̬'] = "��";
	$SYSTEM_ADD_SQL = " and ���ϵǼ�!=''";


	$filetablename='wygl_baoxiuxinxi';
	$parse_filename = 'wygl_baoxiuxinxi5';

	require_once('include.inc.php');

	?>