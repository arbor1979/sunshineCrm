<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
if($_GET['action']=="add_default_data" || $_GET['action']=="add_default")
	validateMenuPriv("�칫��Ʒ�嵥");
else
	validateMenuPriv("������¼");


//Array ( [action] => add_default2_data [pageid] => 1 ) Array ( [�칫��Ʒ����] => ���ɻ�����˼��������� [�칫��Ʒ���] => 100002 [�����ֿ�] => һ�Ųֿ� [����ֿ�] => һ�Ųֿ� [��������] => 1 [������] => ������ [��ע] => [������] => admin [����ʱ��] => 2009-06-14 11:19:11 [submit] => ���� )
if($_GET['action']=="kuguanren")	
{
	$userid = returntablefield( "officeproductcangku", "���", $_GET['tostore'], "�ֿ⸺����" );
	$useridArray=explode(",", $userid);	
	header('Content-Type:text/xml;charset=GBK'); 
	$doc=new DOMDocument("1.0","GBK"); #�����ĵ�����
	$doc->formatOutput=true;               #���ÿ����������
	#�������ڵ㣬���һ��XML�ļ��и����ڵ�
	$root=$doc->createElement("root");    #�����ڵ����ʵ�� 
	$root=$doc->appendChild($root);      #�ѽڵ���ӽ���
	foreach ($useridArray as $row)
	{
		if($row=='') continue;
		$linkman=$doc->createElement("kuguanren"); 
        $linkman=$root->appendChild($linkman);
        		 
		$rowid=$doc->createElement("id");
        $rowid=$linkman->appendChild($rowid);    

        $name=$doc->createElement("name");
        $name=$linkman->appendChild($name); 
        
        $rowid->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$row)));
        $username=returntablefield("user", "user_id", $row, "user_name");
        $name->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$username)));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ
        		
	}
	echo $doc->saveXML();
	exit;
}

if($_GET['action']=="add_default_data")		{
	page_css();
	if($_POST['��׼��']=='')
	{
		print "<script language=javascript>alert('����˲���Ϊ��');window.history.back(-1);</script>";
		exit;	
	}
	$username=returntablefield("user","user_id", $_POST['������'],"user_name");
	$title="���� $username �ĵ���,�������� ".$_POST['�칫��Ʒ����']." ������".$_POST['��������'];
	$messagetitle="�������";
	$guanlianid=$_POST['���'];
	$url="../officeproduct/officeproducttiaoku_newai.php?".base64_encode("action=init_default_search&searchfield=���&searchvalue=$guanlianid");
	newMessage($_POST['��׼��'],$title,$messagetitle,$url,$guanlianid);
}

if($_GET['action']=="yes")		{
	global $db;
	$billinfo=returntablefield("officeproducttiaoku", "���", $_GET['���'], "�칫��Ʒ���,��������,�����ֿ�,����ֿ�");
	$num=$billinfo['��������'];
	$prodid=$billinfo['�칫��Ʒ���'];
	$fromstore=$billinfo['�����ֿ�'];
	$tostore=$billinfo['����ֿ�'];
	$kucun=returntablefield("officeproduct", "�칫��Ʒ���", $prodid, "����","��ŵص�",$fromstore);
	if($kucun<$num)
	{
		print "<script language=javascript>alert('�˱�ŵİ칫��Ʒ��治��');window.history.back(-1);</script>";
		exit;	
	}
	$db->StartTrans();  
	$sql="update officeproduct set ����=����-$num,�ϼƽ��=round(����*����,2) where �칫��Ʒ���='$prodid' and ��ŵص�='$fromstore'";
	$db->Execute($sql);
	$kucun=returntablefield("officeproduct", "�칫��Ʒ���", $prodid, "����","��ŵص�",$tostore);
	if($kucun!='')
		$sql="update officeproduct set ����=����+$num,�ϼƽ��=round(����*����,2) where �칫��Ʒ���='$prodid' and ��ŵص�='$tostore'";
	else 
	{
		$sql="select * from officeproduct where �칫��Ʒ���='$prodid' and ��ŵص�='$fromstore'";
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
		$sql="insert into officeproduct (�칫��Ʒ���,�칫��Ʒ����,�칫��Ʒ���,�ͺŹ��,������λ,����,����,�ϼƽ��,Ʒ��,��ŵص�,������,����ʱ��) 
		values('$prodid','".$rs_a[0]['�칫��Ʒ����']."','".$rs_a[0]['�칫��Ʒ���']."','".$rs_a[0]['�ͺŹ��']."','".$rs_a[0]['������λ']."',$num,".
		$rs_a[0]['����'].",".$rs_a[0]['����']*$num.",'".$rs_a[0]['Ʒ��']."',$tostore,'".$_SESSION['LOGIN_USER_ID']."','".date('Y-m-d H:m:s')."')";
	}
	$db->Execute($sql);
	$sql="update officeproducttiaoku set `�Ƿ����`=2,`���ʱ��`='".date('Y-m-d H:m:s')."' where `���`='".$_GET['���']."'";
	$db->Execute($sql);
	$db->CompleteTrans();
	//�Ƿ�������ִ���
	if ($db->HasFailedTrans()) 
		print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
	else 
	{ 
		page_css();
		$return=FormPageAction("action","init_default");
		print_infor("���������",'trip',"location='?$return'","?$return",0);
	}
	exit;
	
}
if($_GET['action']=="no")		{
	global $db;
	$billinfo=returntablefield("officeproducttiaoku", "���", $_GET['���'], "�칫��Ʒ���,��������,�����ֿ�,����ֿ�");
	$num=$billinfo['��������'];
	$prodid=$billinfo['�칫��Ʒ���'];
	$fromstore=$billinfo['�����ֿ�'];
	$tostore=$billinfo['����ֿ�'];

	$sql="update officeproducttiaoku set `�Ƿ����`=3,`���ʱ��`='".date('Y-m-d H:m:s')."' where `���`='".$_GET['���']."'";
	$db->Execute($sql);
	page_css();
	$return=FormPageAction("action","init_default");
	print_infor("�����ѷ��",'trip',"location='?$return'","?$return",0);
	exit;
	
}
$filetablename='officeproducttiaoku';
require_once('include.inc.php');
?>