<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("�ͻ�����");
	
	$customerid=$_GET['customerid'];
	if($customerid!='' && $_GET['action']=='add_default')
	{
		$ADDINIT=array("�ͻ�����"=>$customerid);
	}
	if($_GET['action']=="workplan")		{
		$crm_servInfo=returntablefield("crm_service", "���", $_GET['���'], "������,�ͻ�����,�����Ա");
		$servertype=returntablefield("crm_dict_servicetypes", "���", $crm_servInfo['������'], "����");
		$custName=returntablefield("customer", "rowid", $crm_servInfo['�ͻ�����'], "supplyname");
		$content=urlencode($crm_servInfo['�����Ա']);
		$guanlianurl=urlencode("../JXC/crm_service_newai.php?action=view_default&���=".$_GET['���']);
		$guanlianshiwu="�ͻ�����";
		$guanlianid=$_GET['���'];
		$zhuti="����$servertype-$custName";
		print "<script>location.href='../CRM/workplanmain_newai.php?action=add_default&zhuti=$zhuti&content=".$content."&guanlianshiwu=$guanlianshiwu&guanlianurl=$guanlianurl&guanlianid=$guanlianid';</script>";
		exit;
	}
	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"�ͻ�����");
	$limitEditDelCust='�ͻ�����';
	addShortCutByDate("����ʱ��","����ʱ��");
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����crm_service_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'crm_service';
	$parse_filename		=	'crm_service';
	require_once('include.inc.php');
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