<?php

	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();

	require_once("systemprivateinc.php");
	$SYSTEM_PRIV_STOP="1";
	CheckSystemPrivate("���ڹ���-����ά��-������Ϣ");


	addShortCutByDate("����ʱ��");

	$filetablename='wygl_baoxiuxinxi';
	$parse_filename = 'wygl_baoxiuxinxi1';

	require_once('include.inc.php');

	?>