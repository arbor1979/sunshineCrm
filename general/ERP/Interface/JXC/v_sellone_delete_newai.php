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

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����v_sellone_delete_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	if($_GET['��ǰ������ʽ']=='')
	{
		$_GET['��ǰ������ʽ']='����';
		$_GET['��ʼʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
		$_GET['����ʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"user_id");
	addShortCutByDate("createtime","�Ƶ�ʱ��");
	$filetablename		=	'v_sellone_delete';
	$parse_filename		=	'v_sellone_delete';
	require_once('include.inc.php');
	?>