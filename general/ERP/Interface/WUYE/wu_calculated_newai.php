<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	/*
	if($_GET['action']=="add_default_data")		{



		
	}
	*/

	$filetablename		=	'wu_calculated';
	$parse_filename		=	'wu_calculated';
	require_once('include.inc.php');
	?>