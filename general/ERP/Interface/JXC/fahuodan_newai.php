<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = "1";
validateMenuPriv("������");

if($_GET['action']=="edit_default2")
{
	print "<script>location='fahuodan_queren.php?billid=".$_GET['billid']."&url=".$_SERVER["PHP_SELF"]."'</script>";
	exit;
}
//ȷ�Ϸ���
if($_GET['action']=="edit_default2_data")
{
	//print_r($_SESSION);exit;
	$Store=new Store($db);
	$CaiWu=new CaiWu($db);
	$db->StartTrans();

	$return=$_POST['url'];
	$yunfei=floatvalue($_POST['yunfei']);
	$jiesuantype=floatvalue($_POST['jiesuantype']);
	$fahuoinfo=returntablefield("fahuodan", "billid",$_POST['billid'], "outtype,customerid");
	$outtype=$fahuoinfo['outtype'];
	$customerid=$fahuoinfo['customerid'];
	
	if($outtype=="���۳���")	
		$supplyname=returntablefield("customer", "rowid", $customerid, "supplyname");
	else if($outtype=='��������')
		$supplyname=returntablefield("supply", "rowid", $customerid, "supplyname");

	//�ȸ��˷����ɷ���
	if($yunfei!=0 && $jiesuantype==1)
	{
		$CaiWu->insertFeiYongAccount(6,$yunfei,1,$_SESSION['LOGIN_USER_ID'],-1,'','��������'.$_POST['billid']."(".$supplyname.")");
	}
	
	//ȷ�Ϸ���
	$dingdanid=$Store->confirmFaHuo($_POST['billid'],$_POST['fahuodan'],$_POST['shouhuoren'],$_POST['address'],$_POST['tel'],
	$_POST['mailcode'],$_POST['fahuotype'],floatvalue($_POST['package']),floatvalue($_POST['weight']),$yunfei,$_POST['jiesuantype'],$_POST['beizhu']);
	

	//�Ƿ�������ִ���
	if ($db->HasFailedTrans())
	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
	else
	{
		if($_POST[duanxintongzhi] == 'yes'){
			//���ͻ�������ʾ����
			$sql="select a.package,a.weight,b.name as fahuotype,a.tel FROM fahuodan a left join fahuotype b on a.fahuotype=b.id  WHERE a.billid=".trim($_POST['billid']);
			$rs=$db->Execute($sql);
			$rs_a = $rs->GetArray();
			$yunfei = $jiesuantype==2?$yunfei.'Ԫ':'0Ԫ(����)';
			$message = "���������ѡ�".$_SESSION[UNIT_NAME].date("Y-m-d H:i:s")."���㵥λ����".$rs_a[0][package]."��,�����ˣ�".$_SESSION[LOGIN_USER_NAME].',������˾:'.$rs_a[0][fahuotype];
			//$sql = 'INSERT INTO sms_sendlist(msg,nowtime,destcount,userid,destid,result) VALUES("'.$message.'",now(),1,"'.$_SESSION[LOGIN_USER_ID].'","'.$rs_a[0][tel].'","����")';
			//$rs=$db->Execute($sql);
			
			print "\n<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>\n";
			print "<script type=\"text/javascript\" language=\"javascript\">
			$.post('../Framework/sms_getContents.php?action=send', {
			    mobiles:'".$rs_a[0][tel]."',
			    msg:'".cutStr($message,70)."'
			}, function(data) {	
			});
		</script>";		
		}
		page_css("ȷ�Ϸ���");
		if($return=='')
		{
			$return=FormPageAction("action","init_default");

		}
		print_infor("������ȷ�ϳɹ�",'trip',"location='?$return'","?$return",0);
			
	}
	$db->CompleteTrans();
	exit;
}
//��������
if($_GET['action']=="chexiao")
{

	$Store=new Store($db);
	$CaiWu=new CaiWu($db);
	$db->StartTrans();
	$fahuoinfo=returntablefield("fahuodan", "billid", $_GET['billid'], "yunfei,jiesuantype,dingdanbillid,outtype,customerid");

	$yunfei=$fahuoinfo['yunfei'];
	$jiesuantype=$fahuoinfo['jiesuantype'];
	$dingdanbillid=$fahuoinfo['dingdanbillid'];
	$outtype=$fahuoinfo['outtype'];
	$customerid=$fahuoinfo['customerid'];
	
	if($outtype=="���۳���")	
		$supplyname=returntablefield("customer", "rowid", $customerid, "supplyname");
	else if($outtype=='��������')
		$supplyname=returntablefield("supply", "rowid", $customerid, "supplyname");
		
	//�����˷�
	if($yunfei!=0 && $jiesuantype==1)
	{
		$CaiWu->insertFeiYongAccount(6,-$yunfei,1,$_SESSION['LOGIN_USER_ID'],-1,'','������������'.$_GET['billid']."(".$supplyname.")");
	}
	//��������
	$Store->cancelFaHuo($_GET['billid']);



	//�Ƿ�������ִ���
	if ($db->HasFailedTrans())
	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
	else
	{
		page_css("��������");
		$return=FormPageAction("action","init_default");
		print_infor("�����������ɹ�",'trip',"location='?$return'","?$return",0);
	}
	$db->CompleteTrans();
	exit;
}
if($_GET['action']=='printKuaiDi')
{
	
	$selectid=$_GET['billid'];
	print "<script>location.href='../CRM/printKuaiDi.php?CustOrSupply=fahuodan&linkmanlist=$selectid',null,'height=600,width=855,status=1,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes';</script>";
	exit;
	
}
addShortCutByDate("fahuodate","��������");
$filetablename		=	'fahuodan';
$parse_filename		=	'fahuodan';
require_once('include.inc.php');
?>