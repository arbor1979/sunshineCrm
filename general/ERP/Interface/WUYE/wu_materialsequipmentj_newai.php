<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	if($_GET['action']=="add_default_data")		{
	//print_R($_GET);
		//echo "<br>";
		//print_R($_POST);

		$���ʱ�� = $_POST['���ʱ��'];
		$�������� = $_POST['��������'];
		$�������� = $_POST['����'];
		$��������� = "�ڿ�";
		$sql = "select * from wu_materialsequipment where ���ʱ��='$���ʱ��'and ��������='$��������' and ���������='$���������'";
		$result = $db->Execute($sql);
		$rs_a = $result->GetArray();

		$���� = $rs_a[0]['����'];

		$num = $����-$��������;
		$upd = "update wu_materialsequipment set ����='$num' where ���ʱ��='$���ʱ��'and ��������='$��������' and ���������='$���������'";

		$db->Execute($upd);
	}

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����wu_materialsequipment_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�

    
    if($_GET['���������'] = "����"){

	$filetablename		=	'wu_materialsequipment';
	$parse_filename		=	'wu_materialsequipmentj';
	require_once('include.inc.php');

	}
	?>