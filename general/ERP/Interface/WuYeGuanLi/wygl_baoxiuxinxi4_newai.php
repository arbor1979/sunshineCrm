<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP="1";
	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-公物维修-用料登记");

	addShortCutByDate("报修时间");





	$_GET['维修状态'] = "是";


	$filetablename='wygl_baoxiuxinxi';
	$parse_filename = 'wygl_baoxiuxinxi4';

	require_once('include.inc.php');

	?>