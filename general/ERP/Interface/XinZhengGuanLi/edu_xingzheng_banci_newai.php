<?php
	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");
	
	CheckSystemPrivate("������Դ-��������-���");
	$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
	if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;

	session_register("�Ƿ�ִ���ض�����");
	if($_SESSION['�Ƿ�ִ���ض�����']=="")			{
		$_SESSION['�Ƿ�ִ���ض�����'] = 0;
	}
	if($_SESSION['�Ƿ�ִ���ض�����']=="1")			{
		�����������ڷǷ�����();
		$_SESSION['�Ƿ�ִ���ض�����'] = 0;
	}
	//print_R($_SESSION);

	if($_GET['action']=='edit_default_data')		{
		$_SESSION['�Ƿ�ִ���ض�����'] = "1";
		//exit;
	}
	if($_GET['action']=='delete_array')				{
		$_SESSION['�Ƿ�ִ���ض�����'] = "1";
	}


	$filetablename='edu_xingzheng_banci';
	require_once('include.inc.php');


	if($_GET['action']==''||$_GET['action']=='init_default')		{
		require_once('../Help/module_xingzhengkaoqin_banci.php');
		//���˷Ƿ�����
		//��ʱִ�к���("�����������ڷǷ�����",30);
		//�����������ڷǷ�����();
	}


	function �����������ڷǷ�����()		{
		global $db,$��ǰѧ��;
		$sql = "delete from edu_xingzheng_kaoqinmingxi where ��� not in (select ������� from edu_xingzheng_banci) and ѧ��='$��ǰѧ��'";
		$db->Execute($sql);
		//print $sql."<BR>";
		$sql = "delete from edu_xingzheng_paiban where ������� not in (select ������� from edu_xingzheng_banci) and ѧ������='$��ǰѧ��'";
		$db->Execute($sql);
		//print $sql."<BR>";
	}
	?>