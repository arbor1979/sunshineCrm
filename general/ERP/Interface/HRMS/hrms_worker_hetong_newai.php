<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");

	CheckSystemPrivate("������Դ-���¹���-��ͬ");

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
	if($_GET['action']=="add_default_data")		{

		//print_R($_GET);print_R($_POST);//exit;

		global $db;

		$���� = $_POST['����'];
		$ǩ��ʱ�� = $_POST['ǩ��ʱ��'];
		$����ʱ�� = $_POST['����ʱ��'];

		//$�̲ı�� = $_POST['�̲ı��'];

		$sql = "update hrms_file set ���κ�ͬǩ��='".$ǩ��ʱ��."',���κ�ͬ��ֹ����='".$����ʱ��."' where ����='".$����."'";

		$rs = $db->Execute($sql);


	//	$sql = "update hrms_work_hetong set ��������='".$����ʱ��-$ǩ��ʱ��."' where ����='".$����."'";

	//	$rs = $db->Execute($sql);

		//print $sql;exit;





	}





	$filetablename='hrms_worker_hetong';

	require_once('include.inc.php');

	?>