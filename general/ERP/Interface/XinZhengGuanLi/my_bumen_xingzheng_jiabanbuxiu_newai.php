<?php

	require_once('lib.inc.php');//



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	//CheckSystemPrivate("������Դ-��������-���ż�����");



	$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
	if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;




	//��ι��˲���,����ֶα�����Ϊ���ط�������--��ʼ
	$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
	$sql = "select ������� from edu_xingzheng_banci where ��ι���һ='$LOGIN_USER_NAME' or ��ι����='$LOGIN_USER_NAME'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$������� = array();
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$Element = $rs_a[$i];
		$�������[]  = $Element['�������'];
	}
	$�������TEXT = join(',',$�������);
	if($�������TEXT=="")		{
		//$�������TEXT = "û��������İ����Ϣ";
		//$_GET['ԭ���'] = $�������TEXT;
	}
	else	{
		$_GET['ԭ���'] = $�������TEXT;
	}
	//��ι��˲���,����ֶα�����Ϊ���ط�������--����

	//###########################################
	//����ֲ��Ź���Ȩ�޲���-��ʼ
	//###########################################
	$SCRIPT_NAME	= "edu_xingzhengkaoqin_newai.php";
	$LOGIN_USER_ID		= $_SESSION['LOGIN_USER_ID'];
	$sql = "select * from systemprivateinc where `FILE`='$SCRIPT_NAME' and (USER_ID like '%,".$LOGIN_USER_ID.",%' or USER_ID like '".$LOGIN_USER_ID.",%')";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$MODULE_ARRAY = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$MODULE_ARRAY[] = $rs_a[$i]['MODULE'];
	}
	$MODULE_TEXT = join(',',$MODULE_ARRAY);
	//if($MODULE_TEXT=="")  $MODULE_TEXT = "δָ��������Ϣ";
	//if($_GET['action']==""||$_GET['action']=="init_default")

	if($MODULE_TEXT==""&&$�������TEXT!="")		{
		//$�������TEXT = "û��������İ����Ϣ";
		//$_GET['ԭ���'] = $�������TEXT;
	}
	elseif($MODULE_TEXT==""&&$�������TEXT=="")		{
		$_GET['����'] = "û��������İ�λ�����Ϣ";
	}
	else	{
		$_GET['����'] = $MODULE_TEXT;
	}
	//$SYSTEM_PRINT_SQL = 1;
	//###########################################
	//����ֲ��Ź���Ȩ�޲���-����
	//###########################################


	$filetablename='edu_xingzheng_jiabanbuxiu';
	$parse_filename = 'my_bumen_xingzheng_jiabanbuxiu';



	require_once('include.inc.php');

	?>