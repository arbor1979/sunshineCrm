<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	/*
	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);//exit;
		global $db;
		$������� = (int)$_POST['�������'];$�̲ı�� = $_POST['�̲ı��'];
		$sql = "update edu_jiaocai set ���п��=���п��+$������� where �̲ı��='".$�̲ı��."'";
		$rs = $db->Execute($sql);//print $sql;exit;
		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");
		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");
		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
	}
	*/

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����wu_wpgsetmanagement_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'wu_wpgsetmanagement';
	$parse_filename		=	'wu_wpgsetmanagement';
	require_once('include.inc.php');


	

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
			$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			˵����<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;1 ��ҳ������ˮ���硢������̯ˮ����̯��ѵĽɷѹ����Լ����ü۸�<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;2 ���÷������ƺ����Ӧ�ĵ��ۣ��շѹ����Լ�˵����<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;3 ��ҳ��Ĺ������ݽ���ˮ����շ���ϸҳ�����Ӧ���Լ����㡣<BR>
			</font></td></table>";
			print $PrintText;
		}
	?>