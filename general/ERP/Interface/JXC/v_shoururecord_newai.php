<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("�������뵥");
	if($_GET['action']=="add_default_data")		{
		
		global $db;
		
		//��������
	    $db->StartTrans(); 
	    $CaiWu=new CaiWu($db);
	    $CaiWu->insertFeiYongAccount($_POST['typeid'],$_POST['jine'],$_POST['accountid'],$_SESSION['LOGIN_USER_ID'],$_POST['kind'],$_POST['chanshengdate'],$_POST['beizhu']);
	    
	    //�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("�������뵥");
			$return=FormPageAction("action","init_default");
			print_infor("�������뵥���ӳɹ�",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
		exit;	
		
	}
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		//��������
		$CaiWu=new CaiWu($db);
	    $db->StartTrans(); 
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				$CaiWu->deleteFeiYongAccount($selectid[$i]);
			}
		}
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("�������뵥");
			$return=FormPageAction("action","init_default");
			print_infor("�������뵥ɾ���ɹ�",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
		exit;
	}

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����v_shoururecord_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	addShortCutByDate("createtime","¼��ʱ��");
	$filetablename		=	'v_shoururecord';
	$parse_filename		=	'v_shoururecord';
	require_once('include.inc.php');
	?>