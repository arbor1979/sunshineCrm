<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP="1";
	require_once("systemprivateinc.php");

	CheckSystemPrivate("���ڹ���-����ά��-��������");

	addShortCutByDate("����ʱ��");




	$_GET['�Ƿ�����'] = "��";

	$filetablename='wygl_weixiupingjia';

	require_once('include.inc.php');

	?>