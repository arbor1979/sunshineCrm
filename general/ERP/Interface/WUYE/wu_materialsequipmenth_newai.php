<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();


	
	    if($_GET['action']=="add_default_data")		{
    
		$���ʱ�� = $_POST['���ʱ��'];
		$��Ʒ���� = $_POST['��Ʒ����'];
		$�������� = $_POST['��������'];
		$�黹���� = $_POST['����'];
		$��������� = "�ڿ�";
		$sql = "select * from wu_materialsequipment where ���ʱ��='$���ʱ��'and ��������='$��������' and ���������='$���������'";
		$result = $db->Execute($sql);
		$rs_a = $result->GetArray();

		$���� = $rs_a[0]['����'];

		$num = $����+$�黹����;
		$upd = "update wu_materialsequipment set ����='$num' where ���ʱ��='$���ʱ��'and ��������='$��������' and ���������='$���������'";

		$db->Execute($upd);

        $del_sql = "delete from wu_materialsequipment where ���ʱ��='$���ʱ��' and ��Ʒ����='$��Ʒ����' and ��������='$��������' and ���������='����'";
        $db->Execute($del_sql);

	    }


	
    $_GET['���������'] = "�黹";

	$filetablename		=	'wu_materialsequipment';
	$parse_filename		=	'wu_materialsequipmenth';
	require_once('include.inc.php');
	?>