<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("���۵���ѯ");
	if($_GET['action']=='')
	{
		print "<script language=\"javascript\" src=\"../LODOP60/LodopFuncs_new.js\"></script><script>LODOP=getLodop();</script>";
	}
	if($_GET['action']=="printXiaoPiao")	
	{
		print "<script>location='sellonemain_newai.php?action=printXiaoPiao&billid=".$_GET['billid']."'</script>";
		exit;
	}
	
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

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����v_sellone_search_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'v_sellone_search';
	$parse_filename		=	'v_sellone_search';
	$realtablename="sellplanmain";
	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"supplyid");
	$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"user_id");
	//if($_SESSION['LOGIN_USER_PRIV']=='3')
	//    $SYSTEM_ADD_SQL=$SYSTEM_ADD_SQL." and totalmoney<1500 and supplyid in (select ROWID from customer where state=16)";
	
	$limitEditDelCust='supplyid';
	

	addShortCutByDate("createtime","�Ƶ�ʱ��","����");
	require_once('include.inc.php');
	print "<iframe name='hideframe' width=0 height=0 border=0 src=''/>";
	?>