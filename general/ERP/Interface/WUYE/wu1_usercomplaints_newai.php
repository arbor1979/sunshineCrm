<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

    
    

	if($_GET['action']=="add_default_data")		{
	
		//print_r($_POST);
		$Ͷ����� = $_POST['Ͷ�����'];
		$��Ԫ��� = $_POST['��Ԫ���'];
		$Ͷ����   = $_POST['Ͷ����'];
        

        $sql = "delete from wu_usercomplaints where Ͷ�����='$Ͷ�����' and ��Ԫ���='$��Ԫ���' and Ͷ����='$Ͷ����' and �Ƿ�����='δ����'";

		$db->Execute($sql);

	} 
    
    
	$_GET['�Ƿ�����'] = "������";
	$_GET['�Ƿ���'] = "��";
	
	

	$filetablename		=	'wu_usercomplaints';
	$parse_filename		=	'wu1_usercomplaints';
	require_once('include.inc.php');

	?>