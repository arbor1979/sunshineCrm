<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("����ƻ�");
	
	if($_GET['action']=="edit_fukuan")		{
		print "<script>location='fukuanplan_do.php?id=".$_GET['id']."&url=".$_SERVER["PHP_SELF"]."'</script>";
		exit;
		
	}
	addShortCutByDate("createtime","����ʱ��");
	$filetablename		=	'fukuanplan';
	$parse_filename		=	'fukuanplan';
	require_once('include.inc.php');
	?>