<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	

	if($_GET['action']=="add_default_data")		{
    
		$���ʱ�� = $_POST['���ʱ��'];
		$�������� = $_POST['��������'];
		$ά������ = $_POST['����'];
		$��������� = "�ڿ�";
		$sql = "select * from wu_materialsequipment where ���ʱ��='$���ʱ��'and ��������='$��������' and ���������='$���������'";
		$result = $db->Execute($sql);
		$rs_a = $result->GetArray();

		$���� = $rs_a[0]['����'];

		$num = $����-$ά������;
		$upd = "update wu_materialsequipment set ����='$num' where ���ʱ��='$���ʱ��'and ��������='$��������' and ���������='$���������'";

		$db->Execute($upd);


	}
	


    $_GET['���������'] = "ά��";

	$filetablename		=	'wu_materialsequipment';
	$parse_filename		=	'wu_materialsequipmentx';
	require_once('include.inc.php');
	?>