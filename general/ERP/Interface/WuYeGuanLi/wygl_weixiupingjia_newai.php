<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP="1";
	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-公物维修-服务评价");

	addShortCutByDate("报修时间");




	$_GET['是否评价'] = "是";

	$filetablename='wygl_weixiupingjia';

	require_once('include.inc.php');

	?>