<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	/*
	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);//exit;
		global $db;
		$������� = (int)$_POST['�������'];$�̲ı�� = $_POST['�̲ı��'];
		$sql = "update edu_jiaocai set ���п��=���п��+$������� where �̲ı��='".$�̲ı��."'";
		$rs = $db->Execute($sql);//print $sql;exit;
		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");
		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");
		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
	}
	*/

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����edu_shixunguanli_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�

    if($_GET['action']=='init_default'){
		$DEPT_ID = $_GET['DEPT_ID'];
        $sql = "select DEPT_NAME from department where DEPT_ID='$DEPT_ID'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$DEPT_NAME = $rs_a[0]['DEPT_NAME'];;
		$SYSTEM_ADD_SQL = " and ��������='$DEPT_NAME'";
	}
	

	$filetablename		=	'edu_shixunguanli';
	$parse_filename		=	'edu_shixunguanli';
	require_once('include.inc.php');
	
	?>