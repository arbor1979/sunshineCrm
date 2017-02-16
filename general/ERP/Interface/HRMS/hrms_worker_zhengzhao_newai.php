<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");

	CheckSystemPrivate("人力资源-人事管理-证照");




	$filetablename='hrms_worker_zhengzhao';

	require_once('include.inc.php');

	?>