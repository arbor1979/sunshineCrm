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
require_once( "lib.inc.php" );
$isBase64 = isbase64( );
$isBase64 == 1 ? checkbase64( ) : "";
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = "1";
validateMenuPriv("��Ʒ����");

$customerid=$_GET['customerid'];
if($customerid!='' && $_GET['action']=='add_default')
{
	$ADDINIT=array("�ͻ�"=>$customerid);
}

if($_GET['action']=="edit_default3")			
{
print "<script>location='DataQuery/productFrame.php?tablename=customerproduct_detail&deelname=���۵���ϸ&rowid=".$_GET['ROWID']."'</script>";
exit;
}
if($_GET['action']=="tongyi")			
{
	page_css();
	$sql="update customerproduct set `�Ƿ����`=2,`���ʱ��`='".date("Y-m-d H:i:s")."',�����='".$_SESSION['LOGIN_USER_ID']."' where ROWID=".$_GET['ROWID'];
	$db->Execute($sql);
	$billinfo=returntablefield("customerproduct","ROWID",$_GET['ROWID'],"����,������");
	newMessage($billinfo['������'],$billinfo['����'].'--��ͨ����','���۵����','../JXC/customerproduct_newai.php?'.base64_encode('action=view_default&ROWID='.$_GET['ROWID']),$_GET['ROWID']);
	$return=FormPageAction("action","init_default");
	print_infor("��ͬ�⣡",'trip',"location='?$return'","?$return",0);
	exit;
}
if($_GET['action']=="foujue")			
{
	page_css();
	$sql="update customerproduct set `�Ƿ����`=3,`���ʱ��`='".date("Y-m-d H:i:s")."',�����='".$_SESSION['LOGIN_USER_ID']."' where ROWID=".$_GET['ROWID'];
	$db->Execute($sql);
	$billinfo=returntablefield("customerproduct","ROWID",$_GET['ROWID'],"����,������");
	newMessage($billinfo['������'],$billinfo['����'].'--�������','���۵����','../JXC/customerproduct_newai.php?'.base64_encode('action=view_default&ROWID='.$_GET['ROWID']),$_GET['ROWID']);
	$return=FormPageAction("action","init_default");
	print_infor("�ѷ����",'trip',"location='?$return'","?$return",0);
	exit;
}
if($_GET['action']=="edit_default2")			
{
		$rowid=$_GET['ROWID'];
		//��������
	    $db->StartTrans();  
	    //��ȡ������	
	    $billid = returnAutoIncrement("billid","sellplanmain");
	    $sql = "select * from customerproduct where ROWID=".$rowid;
		$rs = $db->Execute($sql);
		$rs_a= $rs->GetArray();
		if(count($rs_a)==0)
			throw new Exception("�Ҳ����˱��۵�");
		$zhuti=$rs_a[0]['����'];
		$customerid=$rs_a[0]['�ͻ�'];
		$jieshouren=$rs_a[0]['������'];
		
		$address=returntablefield("linkman", "rowid", $jieshouren, "address");
		$tel=returntablefield("linkman", "rowid", $jieshouren, "phone");
		
		$jine=$rs_a[0]['���'];
		$chance=$rs_a[0]['���ۻ���'];
		$totalnum=intval($rs_a[0]['������']);
		$beizhu="����˵��:".$rs_a[0]['����˵��']." ����˵��:".$rs_a[0]['����˵��']." ��װ����˵��:".$rs_a[0]['��װ����˵��']." ��ע��".$rs_a[0]['��ע'];
	    //�����¶���
	    $sql = "insert into sellplanmain (billid,zhuti,user_id,supplyid,chanceid,totalmoney,plandate,zuiwanfahuodate,beizhu,linkman,address,mobile,createtime,billtype,totalnum) values(".
	    $billid.",'".$zhuti."','".$_SESSION['LOGIN_USER_ID']."',".$customerid.",'".$chance."',".$jine.",'".date("Y-m-d")."','".date("Y-m-d",strtotime(date("Y-m-d")." +30 days")).
	    "','".$beizhu."','".$jieshouren."','".$address."','".$tel."','".date("Y-m-d H:i:s")."',2,$totalnum)";
	    
		$db->Execute($sql);
		
		$sql = "select * from customerproduct_detail where mainrowid=".$rowid;
		$rs = $db->Execute($sql);
		$rs_detail = $rs->GetArray();
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			$sql="select max(id) as maxid from sellplanmain_detail";
			$rs = $db->Execute($sql);
			$rs_a = $rs->GetArray();
			$maxid=$rs_a[0]['maxid']+1;
			$sql = "insert into sellplanmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,inputtime) values(".$maxid.",'".
    		$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$billid.",".$rs_detail[$i]['price']*$rs_detail[$i]['zhekou']*$rs_detail[$i]['num'].",'".$rs_detail[$i]['inputtime']."')";
    		$db->Execute($sql);
    			    
	    		
		}
			
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("���ɶ���");
			$return=FormPageAction("action","init_default");
			print_infor("���������ɳɹ�",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
		exit;	
}
addShortCutByDate("����ʱ��","����ʱ��");
$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"�ͻ�");
$limitEditDelCust='�ͻ�';
$filetablename = "customerproduct";
require_once( "include.inc.php" );
systemhelpContent("��Ʒ����˵��",'100%');
?>
