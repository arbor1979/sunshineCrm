<?php
/*
 ��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
 ��ϵ��ʽ:0371-69663266;
 ��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
 ��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

 �������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
 ����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
 ��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
 */
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();

//print_r($_GET);exit;
validateMenuPriv("�ͻ�������Ϣ");
if($_GET['action']=="add_default")
	$ADDINIT=array("sysuser"=>$_SESSION['LOGIN_USER_ID']);
if($_GET['action']=="edit_default_data"||$_GET['action']=="add_default_data")		{
	if($_POST['amtagio']<=0 || $_POST['amtagio']>1)
	{
		$_POST['amtagio']=1;
	}
	$rowid=returntablefield("customer","supplyname", $_POST['supplyname'], "ROWID","phone",$_POST['phone']);
	if($rowid!='' && $rowid!=$_GET['ROWID'])
	{
		print "<script language='javascript'>alert('�ͻ����ƺ͵绰�Ѵ���');window.history.back(-1);</script>";
		exit;
	}
	if($_POST['membercard']!='')
	{
		$rowid=returntablefield("customer","membercard", $_POST['membercard'], "ROWID");
		if($rowid!='' && $rowid!=$_GET['ROWID'])
		{
			print "<script language='javascript'>alert('��Ա�����Ѵ���');window.history.back(-1);</script>";
			exit;
		}
	}

	$_POST['calling'] = ����תƴ������ĸ($_POST['supplyname']);
	if(trim($_POST['tuihuorate'])!='')
	{
		$tuihuorate=intval($_POST['tuihuorate']);
		if($tuihuorate<0 || $_POST['tuihuorate']>100)
		{
			print "<script language='javascript'>alert('�˻��ʱ�����0-100֮��');window.history.back(-1);</script>";
			exit;
		}
	}
	
}


if($_GET['action']=="operation_yijiao")	{
	validateMenuPriv("�ͻ��ƽ�");
	$selectid=explode(",",$_GET['selectid']);
	try 
	{
		for($i=0;$i<count($selectid);$i++)
		{
			if($selectid[$i]!='')
			{
				if(!ifHasRoleCust($selectid[$i]))
				{
					$custname=returntablefield("customer","rowid", $selectid[$i], "supplyname");
					throw new Exception("��û��Ȩ���ƽ��ͻ���$custname");
				}
			
			}
		}
		print "<script>location.href='../CRM/inc_crm_tools.php?action=add_yijiao&custlist=".$_GET['selectid']."';</script>";
		exit;
		
	}
	catch (Exception $e)
	{
		print "<script language='javascript'>alert('��������".$e->getMessage()."');window.history.back(-1);</script>";
		exit;
	}
	
	
	
}
if($_GET['action']=="delete_array")
{
	$selectid=explode(",",$_GET['selectid']);
	
	if($_SESSION['LOGIN_USER_PRIV']=='3')
	{
		for($i=0;$i<count($selectid);$i++)
		{
			if($selectid[$i]!='')
			{
				$sql="update customer set datascope=-1 where rowid=".$selectid[$i];
				$db->Execute($sql);
			}
		}
		$return=FormPageAction("action","init_default");
		print_infor("�ͻ�������ɾ��",'trip',"location='?$return'","?$return",0);
		exit;
	}
	for($i=0;$i<count($selectid);$i++)
	{
		if($selectid[$i]!='')
		{
			$billid=returntablefield("sellplanmain", "supplyid", $selectid[$i], "billid");
			if($billid!='')
			{
				$customername=returntablefield("customer", "rowid", $selectid[$i], "supplyname");
				print "<script language='javascript'>alert('".$customername." ���ں�ͬ�����۵���¼������ɾ����ص���');window.history.back(-1);</script>";
				exit;
			}
		

		}
	}

}
if($_GET['action']=="addlinkman")
{
	print "<script>location.href='linkman_newai.php?action=add_default&customerid=".$_GET['ROWID']."';</script>";
	exit;
}
if($_GET['action']=="addcrmvisit")
{
	print "<script>location.href='crm_contact_newai.php?action=add_default&customerid=".$_GET['ROWID']."';</script>";
	exit;
}

$SYSTEM_ADD_SQL=getCustomerRoleByUser($SYSTEM_ADD_SQL,"sysuser");

$limitEditDelUser='sysuser';
addShortCutByDate("createdate","����ʱ��");
//print_r($_SESSION);
//$SYSTEM_ADD_SQL = " and ((sysuser='".$_SESSION['LOGIN_USER_ID']."' and datascope=0) or datascope=1)";
//$SYSTEM_PRINT_SQL=1;
$filetablename = "customer";
require_once( "include.inc.php" );
systemhelpcontent( "�ͻ�����", "100%" );

?>
