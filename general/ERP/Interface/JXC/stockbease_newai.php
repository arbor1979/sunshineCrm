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
	validateMenuPriv("�ֿ����");
if($_GET['action']=="add_default_data")			
{
	$sql = "select * from stock where name='".$_POST['name']."'";
	$rs = $db->Execute($sql);
	$rs_detail = $rs->GetArray();
	if(sizeof($rs_detail)>0)
	{
		print "<script language=javascript>alert('���󣺴���ͬ���ֿ�');window.history.back(-1);</script>";
    	exit;
	}
}	
if($_GET['action']=="edit_default_data")			
{
	$sql = "select * from stock where name='".$_POST['name']."' and rowid<>".$_GET['ROWID'];
	$rs = $db->Execute($sql);
	$rs_detail = $rs->GetArray();
	if(sizeof($rs_detail)>0)
	{
		print "<script language=javascript>alert('���󣺴���ͬ���ֿ�');window.history.back(-1);</script>";
    	exit;
	}
}	
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	try 
	{
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				$cangku=returntablefield("stock","rowid",$selectid[$i],"name");
				$sql = "select * from store where storeid=".$selectid[$i];
				$rs = $db->Execute($sql);
				$rs_detail = $rs->GetArray();
				if(sizeof($rs_detail)>0)
				{
					throw new Exception($cangku." ���п���Ʒ������ɾ����");
				}
				$sql = "select * from buyplanmain where storeid=".$selectid[$i];
				$rs = $db->Execute($sql);
				$rs_detail = $rs->GetArray();
				if(sizeof($rs_detail)>0)
				{
					throw new Exception($cangku." ���ڲɹ���¼������ɾ����");
				}
				$sql = "select * from stockchangemain where outstoreid=".$selectid[$i]." or instoreid=".$selectid[$i];
				$rs = $db->Execute($sql);
				$rs_detail = $rs->GetArray();
				if(sizeof($rs_detail)>0)
				{
					throw new Exception($cangku." ����ת�ּ�¼������ɾ����");
				}
			}
		}
	}
	catch(Exception $e)
	{
		print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
    	exit;
	}
	
}

$filetablename = "stock";
require_once( "include.inc.php" );
systemhelpcontent( "�ֿ����", "100%" );
?>
