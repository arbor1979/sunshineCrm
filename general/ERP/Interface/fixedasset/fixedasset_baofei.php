<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("���ڹ���-�̶��ʲ�-�ѱ����ʲ�");

	$common_html=returnsystemlang('common_html');


	$_GET['����״̬'] = "�ʲ��ѱ���";//�ʲ��ѱ���

	$filetablename='fixedasset';
	$parse_filename = "fixedassetbaofeilist";
	require_once('include.inc.php');


	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >

	ע�⣺<BR>
	&nbsp;&nbsp;�ٴ˲�����ʾ�����ѱ��Ϲ̶��ʲ�������������Ϣ,���Ǳ���ʱ������״̬��Ϣ��<BR>
	&nbsp;&nbsp;�ڱ���ʱ������״̬��Ϣ����'�̶��ʲ�������ϸ'�˵����в�ѯ��
	</font></td></table>";
		print $PrintText;
	}

?>