<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

	






    $_GET['是否受理'] = "未受理";


	$filetablename		=	'wu_usercomplaints';
	$parse_filename		=	'wu_usercomplaints';
	require_once('include.inc.php');
	?>