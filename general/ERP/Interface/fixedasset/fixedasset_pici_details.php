<?php
	require_once("lib.inc.php");
	
	$GLOBAL_SESSION=returnsession();

	$common_html=returnsystemlang('common_html');
	$_GET['action']=checkreadaction('init_customer');
	
	if($_GET['action']=="")		{
		$sql = "update fixedasset set ����״̬='����δ����' where ����״̬=''";
		$db->Execute($sql);
		$sql = "update fixedasset set ���=����*����";
		$db->Execute($sql);
	}

	$_GET['����״̬'] = "����δ����,�����ѷ���,�ʲ��ѷ���,�ʲ��ѹ黹";//�ʲ��ѱ���
	$_GET['searchfield'] = '�ʲ�����';
	$_GET['searchvalue'] = $_GET['�ʲ�����'];
	$_GET['action'] = 'init_customer_search';
	
	

	//$NEWAIINIT_VALUE_SYSTEM = "select `���`,`�ʲ����`,`�ʲ�����`,`�ʲ�����`,`����ͺ�`,`����״̬`,`��λ`,`����`,`����`,`���`,`��Ʊ����`,`��������`,`ʹ����Ա`,`��������`,`�ʲ����`,`ƾ֤����`,`��ŵص�`,`��ע`,`������`,`����ʱ��` from fixedasset where (`����״̬`='����δ����' or `����״̬`='�����ѷ���' or `����״̬`='�ʲ��ѷ���' or `����״̬`='�ʲ��ѹ黹') order by ��� desc";
	//$NEWAIINIT_VALUE_SYSTEM_NUM = "select count(`���`) as num from fixedasset where (`����״̬`='����δ����' or `����״̬`='�����ѷ���' or `����״̬`='�ʲ��ѷ���' or `����״̬`='�ʲ��ѹ黹')";
	//print_R($_GET);

	$filetablename='fixedasset';
	$parse_filename = "fixedasset_pici_details";
	
	//$_GET['action']  = 'init_customer';
	require_once('include.inc.php');
	print "<BR>";
	print_close();
?>