<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("���۵���ϸ");

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

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����v_sellplanmain_detail_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"supplyid");
	if($_GET['��ǰ������ʽ']=='')
	{
		$_GET['��ǰ������ʽ']='����';
		$_GET['��ʼʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
		$_GET['����ʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"user_id");
	if($_SESSION['LOGIN_USER_PRIV']=='3')
	    $SYSTEM_ADD_SQL=$SYSTEM_ADD_SQL." and jine<100 ";
	addShortCutByDate("selltime","����ʱ��");
	$filetablename		=	'v_sellplanmain_detail';
	$parse_filename		=	'v_sellplanmain_detail';
	require_once('include.inc.php');
	?>