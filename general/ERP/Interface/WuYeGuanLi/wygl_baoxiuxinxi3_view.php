<?php
	require_once('lib.inc.php');
	
	$GLOBAL_SESSION=returnsession();
	$_GET['action']=checkreadaction('init_customer');


	$_GET['是否受理'] = "是";

	$filetablename='wygl_baoxiuxinxi';
	$parse_filename = 'wygl_baoxiuxinxi3';
	require_once('include.inc.php');
	 ?>