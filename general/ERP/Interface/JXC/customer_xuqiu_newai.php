<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("�����뷽��");
	$customerid=$_GET['customerid'];
	if($customerid!='' && $_GET['action']=='add_default')
	{
		$ADDINIT=array("customerid"=>$customerid);
	}

	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"customerid");
	$limitEditDelCust='customerid';
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����customer_xuqiu_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	addShortCutByDate("createtime","����ʱ��");
	$filetablename		=	'customer_xuqiu';
	$parse_filename		=	'customer_xuqiu';
	require_once('include.inc.php');
	?>