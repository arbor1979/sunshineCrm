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

$isBase64 = isbase64( );
$isBase64 == 1 ? checkbase64( ) : "";
validateMenuPriv("���ⵥ");
if($_GET['action']=="edit_default2")			
{
	$outtype=returntablefield("stockoutmain","billid", $_GET['billid'], "outtype");
	if($outtype=="���۳���")
	{
		print "<script>location='stockoutmain_chuku.php?rowid=".$_GET['billid']."'</script>";
		exit;
	}
	else
	{
		$_GET['action']="savechuku";
		$_GET['rowid']=$_GET['billid'];
	}
}

if($_GET['action']=="savechuku")			
{
	$rowid=$_GET['rowid'];
	try 
	{
		$Store=new Store($db);
		//$db->debug=1;
		 //��������
	    $db->StartTrans();  
	    //ȷ�ϳ���
		$Store->confirmChuKu($rowid);
		$outtype=returntablefield("stockoutmain","billid",$rowid,"outtype");
		if($outtype=="���۳���" || $outtype=="��������")
		{
	    	//����������
	    	$Store->insertFaHuo($rowid);
		}
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			page_css("���ⵥȷ��");
			$return=FormPageAction("action","init_default");
			print_infor("���ⵥ��ȷ��",'trip',"location='?$return'","?$return",0);			
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
//��������
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	try 
	{
		$Store=new Store($db);
		//��������
		//$db->debug=1;
	    $db->StartTrans();  
	    
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				$Store->deleteChuKu($selectid[$i]);				
			}
		}
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			page_css("���ⵥɾ��");
			$return=FormPageAction("action","init_default");
			print_infor("���ⵥ�ѳɹ�ɾ��",'trip',"location='?$return'","?$return",0);
		}
    	$db->CompleteTrans();
		exit;	
	}
	catch(Exception $e)
	{
		print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
    	exit;
	}	
}
if($_GET['action']=="edit_default3")		
{
	print "<script>location='fahuodan_queren.php?billid=".$_GET['billid']."&url=".$_SERVER["PHP_SELF"]."'</script>";
	exit;	
}
if($_GET['action']=="getallcolor")		
{
	global $db;
	$sql="select sum(num) as allnum from stockoutmain_detail_color where id=".$_GET['id'];	
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	print $rs_a[0]['allnum'];
	return;
}
addShortCutByDate("createtime","����ʱ��","���һ��");
$SYSTEM_ADD_SQL=getKucunByUserid($SYSTEM_ADD_SQL,$_SESSION['LOGIN_USER_ID']);
$filetablename = "stockoutmain";
require_once( "include.inc.php" );
systemhelpcontent( "�������˵��", "100%" );
?>
