<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	

	if($_GET['action']=="edit_default_data")		{
          $��� = $_POST['���'];
		  $sql = "update wu_maintenancemanagement set �Ƿ����� = '��' where ���='$���'";
		  $db->Execute($sql);	
	}


    $_GET['�Ƿ�����'] = "��";
	

	$filetablename		=   'wu_maintenancemanagement';
	$parse_filename		=	'my6_wu_maintenancemanagement';
	require_once('include.inc.php');
	?>