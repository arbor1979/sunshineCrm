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
validateMenuPriv("���ۺ�ͬ");
	if($_GET['action']=="add_default_data")
	{
		$_POST['billtype']=1;
	}
	
	if($_GET['action']=="begindo")
	{
		$billid=$_GET['billid'];
		$sql="update sellplanmain set user_flag=1 where billid=$billid";
		$db->Execute($sql);
	}
	if($_GET['action']=="jiaofuplan")
	{
		$billid=$_GET['billid'];
		print "<script>location.href='sellcontract_plan_newai.php?action=add_default&billid=$billid';</script>";
		exit;
	}
	//ɾ����ͬ
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	try 
	{
		//��������
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
			print_infor("��ͬ�ѳ���",'trip',"location='?$return'","?$return",0);
		}
    	
	}
	catch(Exception $e)
	{
		print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;	
}
	$realtablename="sellplanmain";
	
addShortCutByDate("plandate","��Ч����ʼ","�������");
$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"supplyid");
$limitEditDelCust='supplyid';
$filetablename = "v_sellcontract";
$parse_filename	="sellcontract";
require_once( "include.inc.php" );
systemhelpcontent( "���ۺ�ͬ", "100%" );

?>
