<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("������Դ-�ɲ�����-�鿴�ҵĲ���");


	$������Ա = $_SESSION['LOGIN_USER_NAME'];


	$�������� = returntablefield("edu_zhongcengceping","�Ƿ���Ч",1,"��������");
	$����������Ա = returntablefield("edu_zhongcengceping","��������",$��������,"����������Ա");
	$����������ԱArray = explode(',',$����������Ա);

	page_css("�в����");

	//�����Ƿ���Բ������
	if(!in_array($������Ա,$����������ԱArray))		{
		print_infor("��û���ڿ��Բ����������Ա֮��!",'',"location='?'");
		exit;
	}

	$_GET['������'] = $������Ա;
	/*
	if($_GET['action']=="add_default_data")		{

		//print_R($_GET);print_R($_POST);//exit;

		global $db;

		$������� = (int)$_POST['�������'];

		$�̲ı�� = $_POST['�̲ı��'];

		$sql = "update edu_jiaocai set ���п��=���п��+$������� where �̲ı��='".$�̲ı��."'";

		$rs = $db->Execute($sql);

		//print $sql;exit;

		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");

		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");

		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>
";

	}

	*/






	$filetablename='edu_zhongcengmingxi';
	$parse_filename='edu_zhongcengviewceping';

	require_once('include.inc.php');

	?>