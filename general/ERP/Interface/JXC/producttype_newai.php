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
validateMenuPriv("��Ʒ���͹���");
if($_GET['action']=="edit_default_data")
{
	if($_POST['parentid']==$_GET['ROWID'])
	{
		print "<script language=javascript>alert('���಻�����Լ�');window.history.back(-1);</script>";
    	exit;
	}
}
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	for($i=0;$i<sizeof($selectid);$i++)
	{
		
		if($selectid[$i]!="")
		{
			$parent=returntablefield("producttype", "parentid", $selectid[$i], "name");
			if($parent!='')
			{
				print "<script language=javascript>alert('������´������࣬����ɾ������');window.history.back(-1);</script>";
    			exit;
			}
			$productid=returntablefield("product", "producttype", $selectid[$i], "productid");
			if($productid!='')
			{
				print "<script language=javascript>alert('������´��ڲ�Ʒ������ɾ����Ʒ');window.history.back(-1);</script>";
    			exit;
			}
		}
	}
}
$filetablename = "producttype";
require_once( "include.inc.php" );
?>
