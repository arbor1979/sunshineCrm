<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("���ڹ���-�̶��ʲ�-������ϸ");



if($_GET['action']=="add_default_data")		{
	page_css('����');
	$�ʲ���� = $_POST['�ʲ����'];
	$�ʲ����� = $_POST['�ʲ�����'];
	$���������� = $_POST['����������'];
	if($_POST['��׼��']!=""&&$_POST['����������']!="")	{
		$_POST['����'] = returntablefield("fixedasset","�ʲ����",$�ʲ����,"����");
		$_POST['����'] = returntablefield("fixedasset","�ʲ����",$�ʲ����,"����");
		$_POST['���'] = returntablefield("fixedasset","�ʲ����",$�ʲ����,"���");
		$sql = "update fixedasset set ʹ����Ա='$����������',����״̬='�ʲ��ѱ���' where �ʲ����='$�ʲ����'";
		$db->Execute($sql);
		//print $sql;
	}
	else			{
		$SYSTEM_SECOND = 1;
		print_infor("��׼�˻������Ϊ��,���Ĳ���û��ִ�гɹ�!",$infor='�ò����°汾û�б�ʹ��',$return="location='fixedasset_newai.php'",$indexto='fixedasset_newai.php');
		exit;
	}
}

	//$_GET['action']=="init_default"||$_GET['action']==""
	if(0)		{
		//$sql = "update fixedasset set ����״̬='�����ѷ���' where ����״̬='�ʲ��ѱ���'";
		//$db->Execute($sql);
		$sql = "select * from fixedassetbaofei";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)		{
			$�ʲ���� = $rs_a[$i]['�ʲ����'];
			$��� = $rs_a[$i]['���'];
			$���� = returntablefield("fixedasset","�ʲ����",$�ʲ����,"����");
			$���� = returntablefield("fixedasset","�ʲ����",$�ʲ����,"����");
			$��� = $����*$����;
			$sql = "update fixedassetbaofei set ���='$���',����='$����',����='$����' where ���='$���'";
			$db->Execute($sql);
			//print $sql."<BR>";;
			$sql = "update fixedasset set ����״̬='�ʲ��ѱ���' where �ʲ����='$�ʲ����'";
			$db->Execute($sql);
			//print $sql."<BR>";;
		}
	}



	//exit;

	$filetablename='fixedassetbaofei';

	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >

	ע�⣺<BR>
	&nbsp;&nbsp;�ٴ˲���ֻ�Ǽ�¼�ʲ����б���ʱ������״̬��Ϣ��<BR>
	&nbsp;&nbsp;��������ڹ̶��ʲ������ֱ���޸Ĺ̶��ʲ���״̬��ϢΪ����״̬ʱ�򲻻��������Ϣ��
	</font></td></table>";
		print $PrintText;
	}
	?>