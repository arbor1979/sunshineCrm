<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("���ۻ���");
	$customerid=$_GET['customerid'];
	
	if($customerid!='' && $_GET['action']=='add_default')
	{
		$ADDINIT=array("�ͻ�����"=>$customerid);
	}
	if($_GET['action']=='shenqingbaobei')
	{
		print "<script>location='crm_shenqingbaobei.php?billid=".$_GET['���']."'</script>";
		exit;
	}
	if($_GET['action']=="trace")
	{
		$customerinfo=returntablefield("crm_chance", "���", $_GET['���'], "�ͻ�����,��ϵ��");
		$customerid=$customerinfo['�ͻ�����'];
		$linkmanid=$customerinfo['��ϵ��'];
		print "<script>location.href='crm_contact_newai.php?action=add_default&customerid=".$customerid."&linkmanid=$linkmanid&chance=".$_GET['���']."';</script>";
		exit;
	}
	addShortCutByDate("����ʱ��","����ʱ��");
	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"�ͻ�����");
	$limitEditDelCust='�ͻ�����';
	$filetablename		=	'crm_chance';
	$parse_filename		=	'crm_chance';
	require_once('include.inc.php');
	systemhelpContent("���ۻ���˵��",'100%');
	?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>