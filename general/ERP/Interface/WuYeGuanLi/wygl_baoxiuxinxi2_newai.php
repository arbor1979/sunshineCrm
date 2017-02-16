<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP="1";
	require_once("systemprivateinc.php");

	//CheckSystemPrivate("后勤管理-公物维修-报修受理");

	addShortCutByDate("报修时间");

	$filetablename='wygl_baoxiuxinxi';
	$parse_filename = 'wygl_baoxiuxinxi2';

	require_once('include.inc.php');

	?>