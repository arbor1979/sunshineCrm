<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("人力资源-干部测评-设置我的自评");


	$_GET['被评人员'] = $_SESSION['LOGIN_USER_NAME'];


	$filetablename='edu_zhongcengrenyuan';
	$parse_filename = 'edu_zhongcengmyziping';

	require_once('include.inc.php');

	?>