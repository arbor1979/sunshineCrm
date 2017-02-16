<?php

	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();

	require_once("systemprivateinc.php");
	$SYSTEM_PRIV_STOP="1";
	CheckSystemPrivate("后勤管理-公物维修-报修信息");


	addShortCutByDate("报修时间");

	$filetablename='wygl_baoxiuxinxi';
	$parse_filename = 'wygl_baoxiuxinxi1';

	require_once('include.inc.php');

	?>