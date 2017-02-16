<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	
	$SYSTEM_ADD_SQL=" and tablename='".$_GET['tablename']."' and keyfield='".$_GET['keyfield']."' and keyvalue='".$_GET['keyvalue']."'";
	//print $SYSTEM_PRINT_SQL=1;
	$filetablename		=	'modifyrecord';
	$parse_filename		=	'modifyrecord';
	require_once('include.inc.php');
	?>