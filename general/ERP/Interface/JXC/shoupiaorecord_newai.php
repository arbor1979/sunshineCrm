<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("��Ʊ��¼");
	
	if($_GET['action']=="add_default_data")
	{
		try 
		{
			$piaojujine=floatvalue($_POST['piaojujine']);
			$billinfo=returntablefield("buyplanmain", "billid", $_POST['caigoubillid'], "totalmoney,shoupiaomoney");
			$maxjine=$billinfo['totalmoney']-$billinfo['shoupiaomoney'];
			if($maxjine>0 && $piaojujine>$maxjine)
				throw new Exception("������Ʊ���ܴ���$maxjine");
			if($maxjine<0 && $piaojujine<$maxjine)
				throw new Exception("������Ʊ����С��$maxjine");
			if($piaojujine==0)
				throw new Exception("������Ʊ����Ϊ0");
			global $db;
			$db->StartTrans();
			$CaiWu =new CaiWu($db);
			$CaiWu->insertShouPiao($_POST['supplyid'],$_POST['caigoubillid'],$_POST['kaipiaoneirong'],$_POST['piaojutype'],$_POST['fapiaono'],$_POST['piaojujine'],$_SESSION['LOGIN_USER_ID'],$_POST['qici'],$_POST['beizhu'],$_POST['kaipiaodate']);
			$db->CompleteTrans();
			page_css("��Ʊ��¼");
			//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());
			else 
			{ 
				
				$return=FormPageAction("action","init_default");
				print_infor("������Ʊ��¼�ɹ�",'trip',"location='?$return'","?$return",0);
				
			}
	    	
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('����".str_replace("'",  "\'", $e->getMessage())."');window.history.back(-1);</script>";
		}
    	exit;
		
	}
	
	else if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
			
		//��������
		global $db;
		//$db->debug=1;
	    $db->StartTrans();  
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				$CaiWu =new CaiWu($db);
				$CaiWu->deleteShouPiao($selectid[$i]);
			}
		}
		$db->CompleteTrans();
		page_css("��Ʊ��¼");
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			
			$return=FormPageAction("action","init_default");
			print_infor("��Ʊ��¼�ѳɹ�ɾ��",'trip',"location='?$return'","?$return",0);
		}
    	
		exit;	
	
	}
	addShortCutByDate("createtime","����ʱ��");
	$filetablename		=	'shoupiaorecord';
	$parse_filename		=	'shoupiaorecord';
	require_once('include.inc.php');
	?>