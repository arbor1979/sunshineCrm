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

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����wu_materialsequipment_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�

    $_GET['���������'] = "�ڿ�";

	$filetablename		=	'wu_materialsequipment';
	$parse_filename		=	'wu_materialsequipment';
	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		˵����<BR>
		&nbsp;&nbsp;1 ֻ���޸ĳ�ʼ���б��еĳ����������Ϣ��<BR>
		&nbsp;&nbsp;2 Ȼ�󵽶�Ӧ�ķ�������У�������Ӧ�����á�<BR>
		</font></td></table>";
		print $PrintText;
	}
	?>