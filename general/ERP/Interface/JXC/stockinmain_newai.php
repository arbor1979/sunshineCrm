<?php
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();

//�ж��Ƿ�ΪBASE64����
$isBase64 = isBase64();
//����_GET����ת��
$isBase64==1?CheckBase64():'';
/*
if($_GET['action']=="add_default")		{
	header("location:stockin_input_newai.php?returnAction=init");
}
if($_GET['action']=="edit_default"&&$_GET['ROWID']!="")		{
	//print_R($_GET);
	header("location:stockin_input_newai.php?action=edit_default&ROWID=".$_GET['ROWID']);
}

*/
//ȷ�����
validateMenuPriv("��ⵥ");
if($_GET['action']=="edit_default2")			
{
	$rowid=$_GET['billid'];
	//���¿��
	try {
		
		$Store=new Store($db);
		//��������
	    $db->StartTrans();   
	    //���
	    //$db->debug=true;
	    $Store->confirmRuKu($rowid);
		$db->CompleteTrans();
		page_css("��ⵥȷ��");
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			
			$return=FormPageAction("action","init_default");
			print_infor("��ⵥ�ѳɹ�ȷ��",'trip',"location='?$return'","?$return",0);
		}	
		
	}
	catch (Exception $e) 
	{   
		print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
	} 
	exit;	
}

//�������
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
				
				$Store->deleteRuKu($selectid[$i]);
				
			}
		}
		page_css("��ⵥɾ��");
		$db->CompleteTrans();
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			
			$return=FormPageAction("action","init_default");
			print_infor("��ⵥ�ѳɹ�ɾ��",'trip',"location='?$return'","?$return",0);
		}
    	
		
	}
	catch(Exception $e)
	{
		print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;	
}
addShortCutByDate("createtime","����ʱ��","���һ��");
$filetablename='stockinmain';
$SYSTEM_ADD_SQL=getKucunByUserid($SYSTEM_ADD_SQL,$_SESSION['LOGIN_USER_ID']);
require_once('include.inc.php');
systemhelpContent("������˵��",'100%');



?>