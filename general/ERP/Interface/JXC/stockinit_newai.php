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
$GLOBAL_SESSION = returnsession( );
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
validateMenuPriv("����ʼ��");
if($_GET['action']=='edit_default2')
{
	$storeid=$_GET['ROWID'];
	$sql="select * from store where num<>0 and storeid=$storeid";
	$rs = $db->Execute($sql);
	$rs_detail = $rs->GetArray();
	if(sizeof($rs_detail)>0)
	{
		print "<script language=javascript>alert('���󣺲ֿ����Ѵ��ڲ�Ʒ�����ܽ��г�ʼ��');window.history.back(-1);</script>";
    	exit;
	}
	$sql="update store_init set jine=num*price where storeid=$storeid";
	$db->Execute($sql);
	require_once( "stockinit_input.php" );
	exit;
}
if($_GET['action']=='save')
{
	$storeid=$_GET['storeid'];
	try 
	{
		$sql = "select * from store_init where storeid=".$storeid." and flag=0";
		$rs = $db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$allnum=0;
		$allmoney=0;
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			$allnum=$allnum+$rs_detail[$i]['num'];
			$allmoney=$allmoney+$rs_detail[$i]['jine'];
		}
		if($allnum==0)
			throw new Exception("�������������0");	
	    
		//��������
	    $db->StartTrans();  
	    //��ȡ��ⵥ��	
	    //ɾ�����Ϊ0�ļ�¼
	    $sql = "delete from `store` where num=0 and storeid=$storeid";		
	    $db->Execute($sql);//�������
	    
	    $billid = returnAutoIncrement("billid","stockinmain");
	    //��������ⵥ
	    $sql = "insert into stockinmain (billid,zhuti,storeid,createman,createtime,caigoubillid,state,totalnum,totalmoney,instoreshenhe,indate,intype) values(".
	    $billid.",'����ʼ��',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',0,'�����',$allnum,$allmoney,'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."','��ʼ�����')";
		$db->Execute($sql);
	    
	    
	    for($i=0;$i<sizeof($rs_detail);$i++)
		{
			$num=floatvalue($rs_detail[$i]['num']);
			$price=floatvalue($rs_detail[$i]['price']);
			$jine=floatvalue($rs_detail[$i]['jine']);
			$memo=$rs_detail[$i]['memo'];
			//������
			if($num!=0)
			{
				$sql="select max(id) as maxid from stockinmain_detail";
				$rs = $db->Execute($sql);
				$rs_a=$rs->GetArray();
				$maxid=$rs_a[0]['maxid']+1;
	    		$sql = "insert into stockinmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine) values('$maxid','".
	    		$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['guige']."','".$rs_detail[$i]['xinghao'].
	    		"','".$rs_detail[$i]['danwei']."',".$price.",1,".$num.",".$billid.",".$jine.")";
	    		$db->Execute($sql);
	    		
	    		$maxid=returnAutoIncrement("id", "store");
	    		$sql="insert into store (id,prodid,num,price,storeid,memo) values($maxid,'".$rs_detail[$i]['prodid']."',$num,$price,$storeid,'$memo')";
	    		$db->Execute($sql);
			}
		}
		$sql = "delete from store_init where storeid=".$storeid." and flag=0 and num=0";
		$db->Execute($sql);
		//���³�ʼ��״̬
    	$sql = "update store_init set flag=1 where storeid=".$storeid." and flag=0";
		$db->Execute($sql);
		
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("����ʼ��");
			$return=FormPageAction("action","init_default");
			print_infor("����ɿ���ʼ��",'trip',"location='?$return'","?$return",0);
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
if($_GET['action']=='edit_default3')
{
	$storeid=$_GET['ROWID'];
	require_once( "stockinit_clear.php" );
	exit;
}

$SYSTEM_ADD_SQL=getKucunByUserid($SYSTEM_ADD_SQL,$_SESSION['LOGIN_USER_ID'],"ROWID");

$filetablename = "stock";
$parse_filename = "stockinit";
require_once( "include.inc.php" );
systemhelpcontent( "����ʼ��˵��", "100%" );
?>
