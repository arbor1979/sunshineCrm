<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("���ڹ���-�̶��ʲ�-������ϸ");



if($_GET['action']=="add_default_data")		{
	page_css('����');
	$�ʲ���� = $_POST['�ʲ����'];
	$�ʲ����� = $_POST['�ʲ�����'];
	$������ = $_POST['������'];
	if($_POST['��׼��']!=""&&$_POST['������']!="")	{
		$_POST['����'] = returntablefield("fixedasset","�ʲ����",$�ʲ����,"����");
		$_POST['����'] = returntablefield("fixedasset","�ʲ����",$�ʲ����,"����");
		$_POST['���'] = returntablefield("fixedasset","�ʲ����",$�ʲ����,"���");
		$sql = "update fixedasset set ʹ����Ա='$������',����״̬='�ʲ��ѷ���' where �ʲ����='$�ʲ����'";
		$db->Execute($sql);
	}
	else			{
		$SYSTEM_SECOND = 1;
		print_infor("��׼�˻������Ϊ��,���Ĳ���û��ִ�гɹ�!",$infor='�ò����°汾û�б�ʹ��',$return="location='fixedasset_newai.php'",$indexto='fixedasset_newai.php');
		exit;
	}
}


$filetablename='fixedassetout';
require_once('include.inc.php');
?>