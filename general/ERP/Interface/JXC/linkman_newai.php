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
	
		validateMenuPriv("�ͻ���ϵ��");
$customerid=$_GET['customerid'];
if($customerid!='' && $_GET['action']=='add_default')
{
	$ADDINIT=array("customerid"=>$customerid);
}
if($_GET['action']=='add_default_data' || $_GET['action']=='edit_default_data')
{
	
	$_POST['linkmanpy'] = ����תƴ������ĸ($_POST['linkmanname']);


	if($_POST['birthday'] !=""){   //���ղ�Ϊ�գ����ɿͻ�������
			    global $db;
				$type="�ͻ�����";
				$linkmanid = $_REQUEST['ROWID'];
				$customerid = $_POST['customerid'];
				$date=$_POST['birthday'];
				$createtime=date('Y-m-d H:i:s');
				$createman=$_SESSION['LOGIN_USER_ID'];
				$sql="select count(*) as num from crm_remember where mem_type='�ͻ�����' and linkmanid=".$linkmanid;
				$rs = $db->Execute($sql);
				$rs_a = $rs->GetArray();
				$maxid=returnAutoIncrement("id","crm_remember");
				if($rs_a[0][num]=='0' ) {
					$sql="insert into crm_remember(id,mem_type,linkmanid,customerid,mem_date,createtime,operman) values($maxid,'".$type."','".$linkmanid."','".$customerid."','".$date."','".$createtime."','".$createman."')";
					$db->Execute($sql);
				}
				else{
				    $sql="update crm_remember set mem_date='".$date."',operman='".$createman."' where mem_type='�ͻ�����' and linkmanid=".$linkmanid;
				    $db->Execute($sql);
				}
	}

}
if($_GET['action']=='operation_sendsms')
{
	validateMenuPriv("�ֻ�����");
	$selectid=$_GET['selectid'];
	print "<script>location='sms_sendlist_newai.php?action=add_default&sendlist=".$selectid."&fromsrc=customer';</script>";
	exit;
	
}
if($_GET['action']=='operation_sendemail')
{
	validateMenuPriv("�����ʼ�");
	$selectid=$_GET['selectid'];
	print "<script>location='../CRM/email_newai.php?action=add_default&sendlist=".$selectid."&fromsrc=customer';</script>";
	exit;
	
}
if($_GET['action']=='operation_printKuaiDi')
{
	
	$selectid=$_GET['selectid'];
	print "<script>
	location.href='../CRM/printKuaiDi.php?CustOrSupply=customer&linkmanlist=$selectid',null,'height=600,width=855,status=1,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes';
	</script>";
	exit;
	
}
$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"customerid");

$limitEditDelCust='customerid';
$filetablename = "linkman";
require_once( "include.inc.php" );
?>
