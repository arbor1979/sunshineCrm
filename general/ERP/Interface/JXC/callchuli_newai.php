<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	
	if($_GET['action']=="edit_default_data")		{
		if($_POST['ifchuli']=='��')
			$_POST['chulitime']=date("Y-m-d H:i:s");
		else
			$_POST['chulitime']='';
		
	}
	if($_GET['action']=="newchance")		{
		$customerid=returntablefield("callchuli", "id", $_GET["id"], "customerid");
		print "<script>location.href='crm_chance_newai.php?action=add_default&customerid=".$customerid."';</script>";
		exit;
	
	}
	
	addShortCutByDate("createtime","����ʱ��");
	$SYSTEM_ADD_SQL=getRoleByUser($SYSTEM_ADD_SQL,"createman"); 
	$limitEditDelUser='createman';
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����callchuli_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'callchuli';
	$parse_filename		=	'callchuli';
	require_once('include.inc.php');
	?>