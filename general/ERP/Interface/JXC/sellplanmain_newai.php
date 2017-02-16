<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
//	print_r($_GET);exit;
validateMenuPriv("���۶���");

$customerid=$_GET['customerid'];
if($_GET['action']=='view_default')
{
	$billtype=returntablefield("sellplanmain", "billid", $_GET['billid'], "billtype");
	$url="";
	if($billtype=='1')
		$url="sellcontract_newai.php";
	else if($billtype=='3')
		$url="v_sellone_search_newai.php";
	if($url!='')
	{
		print "<script>location='".$url."?".base64_encode("action=view_default&billid=".$_GET['billid'])."'</script>";
		exit;
	}
	
}
if($customerid!='' && $_GET['action']=='add_default')
{
	$ADDINIT=array("supplyid"=>$customerid);
}

if($_GET['action']=="edit_default3")
{
	$billinfo=returntablefield("sellplanmain", "billid", $_GET['billid'], "huikuanjine,kaipiaojine,fahuostate");
	if($billinfo['huikuanjine']!=0 || $billinfo['kaipiaojine']!=0 || $billinfo['fahuostate']!=0)
	{
		print "<script language=javascript>alert('���󣺵���״̬�Ѹı䣬�����ٱ༭��ϸ');window.history.back(-1);</script>";
		exit;
	}
	print "<script>location='DataQuery/productFrame.php?tablename=sellplanmain_detail&deelname=���۶�����ϸ&rowid=".$_GET['billid']."'</script>";
	exit;
}
if($_GET['action']=="edit_default2")
{
	print "<script>location='sellplanmain_chuku.php?".("billid=".$_GET['billid'])."'</script>";
	exit;
}
if($_GET['action']=="edit_default2_data")
{

	$rowid=$_POST['billid'];
	$storeid=$_POST['stock'];
	$allnum=round(floatval($_POST['allnum']),2);
	$allmoney=round(floatval($_POST['allmoney']),2);
	try
	{
		if($storeid==0)
		throw new Exception("��ѡ������ֿ�");
		$Store=new Store($db);
		//��������
		$db->StartTrans();
		$Store->insertDingDanChuKu($rowid,$storeid,$allnum,$allmoney);
			
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans())
		print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else
		{
			page_css("���ɳ��ⵥ");
			$return=FormPageAction("action","init_default");
			print_infor("���ⵥ�����ɣ��ȴ����ȷ��",'trip',"location='?$return'","?$return",0);

		}
		$db->CompleteTrans();
		exit;

	}
	catch (Exception $e)
	{
		print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
		exit;
	}
}
if($_GET['action']=="edit_default4")
{
	$billid=returntablefield("stockoutmain", "dingdanbillid", $_GET['billid'], "billid","state","�ѳ���");

	if($billid<>'')
	{
		print "<script>location='fahuodan_queren.php?billid=".$billid."&url=".$_SERVER["PHP_SELF"]."'</script>";
		exit;
	}
	else
	{
		print "<script language=javascript>alert('����û���ҵ��ɷ����ĳ��ⵥ';window.history.back(-1);</script>";
		exit;
	}

}
if($_GET['action']=="add_default_data")
{
	$_POST['billtype']=2;
	
}

//��������
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	try 
	{
		//��������
		$CaiWu=new CaiWu($db);
	    $db->StartTrans();  
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
					
				$billid=$selectid[$i];
				$sql="delete from sellplanmain where billid=$billid and user_flag=0";
				$db->Execute($sql);
			}

		}
		$db->CompleteTrans();
		//�Ƿ�������ִ���
		page_css("");
		if ($db->HasFailedTrans()) 
			throw new Exception($db->ErrorMsg());
		else 
		{ 
			$return=FormPageAction("action","init_default");
			print_infor("������ɾ��",'trip',"location='?$return'","?$return",0);
		}
    	
	}
	catch(Exception $e)
	{
		print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;	
}

if($_GET['action']=="print_order"){
	
	@$global_config_ini_file = @parse_ini_file(DOCUMENT_ROOT.'general/ERP/Interface/Framework/global_config.ini',true);
	$print_main_field_list = $global_config_ini_file['section']['sell_order_field_config'];
	$print_detail_field_list = $global_config_ini_file['section']['sell_order_detail_field_config'];
	
}
if($_GET['action']=="caiwushenhe")
{
	$billid=$_GET['billid'];
	$sql="update sellplanmain set user_flag=-2 where billid=$billid and user_flag=0";
	$db->Execute($sql);
	page_css("");
	$return=FormPageAction("action","init_default");
	print_infor("������񷢳�����",'trip',"location='?$return'","?$return",0);
	exit;
}
addShortCutByDate("plandate","����ǩ������","�������");
$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"supplyid");
$SYSTEM_ADD_SQL=$SYSTEM_ADD_SQL." and billtype=2 ";
$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"user_id");
$limitEditDelCust='supplyid';
$filetablename		=	'sellplanmain';
$parse_filename		=	'sellplanmain';
require_once('include.inc.php');
systemhelpcontent( "���۶���", "100%" );

?>