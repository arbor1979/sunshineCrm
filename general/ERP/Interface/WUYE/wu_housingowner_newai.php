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

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����wu_housingowner_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�


	$filetablename		=	'wu_housingowner';
	$parse_filename		=	'wu_housingowner';
	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		˵����<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;1 ���Ƚ��ͻ��������ơ�<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;2 �������ʹ���˸��ͻ���ͬ��������Ӧ������ʹ���ˣ���������ʹ���˹���ҳ�档<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;3 ����˷����Ѿ��Ǽ���ʹ���ˣ���˵�Ԫû��'����ʹ����'ģ�顣<BR>
		</font></td></table>";
		print $PrintText;
	}

	?>