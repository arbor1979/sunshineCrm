<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = "1";
validateMenuPriv("���ֶһ�");

$customerid=$_GET['customerid'];
if($customerid!='' && $_GET['action']=='add_default')
{
	$ADDINIT=array("customid"=>$customerid);
}

if($_GET['action']=="add_default_data"){
	global $db;
	$sql = "select integral from customer where ROWID='".$_POST[customid]."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$integral = $rs_a[0][integral];
	if($integral<$_POST['integral']){
		print "<script language=javascript>alert('���ֲ��������ܶһ���');window.history.back(-1);</script>";
		exit;
	}
	if(intval($_POST['exchangenum'])>intval($_POST['integral'])){
		print "<script language=javascript>alert('�һ���ֵ�Ľ��ܴ��ڻ��֣�');window.history.back(-1);</script>";
		exit;
	}
	
	if(intval($_POST[exchangenum]) <= 0){
		print "<script language=javascript>alert('�һ���ֵ�������0��');window.history.back(-1);</script>";
		exit;
	}
	if(intval($_POST[integral]) <= 0){
		print "<script language=javascript>alert('�һ����ֱ������0��');window.history.back(-1);</script>";
		exit;
	}
	try {

		// ��������
		$db->StartTrans();
		//$db->debug=1;
		$CaiWu =new CaiWu($db);
		$Store =new Store($db);
		$CaiWu->exchangeJifen($_POST);
		$db->CompleteTrans();
		page_css("���ֶһ�");
		if ($db->HasFailedTrans()){
			throw  new Exception($db->ErrorMsg());
		
		}
		else
		{
			
			$return=FormPageAction("action","init_default");
			print_infor("�һ��ɹ���",'trip',"location='?$return'","?$return",1);
		

		}
	}
	catch (Exception $e)
	{
		print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;
	
}

if($_GET['action']=="delete_array"){
	global $db;

	$db->StartTrans();
	//$db->debug=1;
	$CaiWu =new CaiWu($db);
	$Store =new Store($db);

	$delete_array = array();
	$delete_array = explode(',', trim($_GET[selectid]));
	foreach ($delete_array as $id){

		$CaiWu->cancelExchangeJifen($id);
	}
	$db->CompleteTrans();
	if ($db->HasFailedTrans()){
		print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		exit;
	}
	
	page_css("ɾ���ɹ�");
	$return=FormPageAction("action","init_default");
	print_infor("ɾ���ɹ���",'trip',"location='?$return'","?$return",1);
	exit;
	
}

//���ݱ�ģ���ļ�,��ӦModelĿ¼�����exchange_newai.ini�ļ�
//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
addShortCutByDate("createtime","�һ�ʱ��");
$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"customid");
$limitEditDelCust='customid';
$filetablename		=	'exchange';
$parse_filename		=	'exchange';
require_once('include.inc.php');
?>