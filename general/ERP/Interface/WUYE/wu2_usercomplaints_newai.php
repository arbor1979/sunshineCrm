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

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����wu_usercomplaints_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
    




	if($_GET['action']=="add_default_data")		{
	
		//print_r($_POST);
		$Ͷ����� = $_POST['Ͷ�����'];
		$��Ԫ��� = $_POST['��Ԫ���'];
		$Ͷ����   = $_POST['Ͷ����'];
        

        $sql = "delete from wu_usercomplaints where Ͷ�����='$Ͷ�����' and ��Ԫ���='$��Ԫ���' and Ͷ����='$Ͷ����' and �Ƿ�����='������'";

		$db->Execute($sql);

	}  

    $_GET['�Ƿ���'] = "��";
	$_GET['�Ƿ�����'] = "������";
	$filetablename		=	'wu_usercomplaints';
	$parse_filename		=	'wu2_usercomplaints';
	require_once('include.inc.php');
	?>