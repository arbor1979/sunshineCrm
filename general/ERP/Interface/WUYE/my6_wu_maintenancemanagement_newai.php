<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	

	if($_GET['action']=="edit_default_data")		{
          $编号 = $_POST['编号'];
		  $sql = "update wu_maintenancemanagement set 是否评价 = '是' where 编号='$编号'";
		  $db->Execute($sql);	
	}


    $_GET['是否评价'] = "是";
	

	$filetablename		=   'wu_maintenancemanagement';
	$parse_filename		=	'my6_wu_maintenancemanagement';
	require_once('include.inc.php');
	?>