<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("��Ʊ��¼");

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����kaipiaorecord_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	if($_GET['action']=="add_default_data")
	{
		global $db;
		$db->StartTrans();
		$CaiWu =new CaiWu($db);
		$CaiWu->insertKaiPiao($_POST['customerid'],$_POST['dingdanbillid'],$_POST['kaipiaoneirong'],$_POST['piaojutype'],$_POST['fapiaono'],$_POST['piaojujine'],$_SESSION['LOGIN_USER_ID']);
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			page_css("��Ʊ��¼");
			$return=FormPageAction("action","init_default");
			print_infor("������Ʊ��¼�ɹ�",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
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
				$CaiWu->deleteKaiPiao($selectid[$i]);
			}
		}
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			page_css("��Ʊ��¼");
			$return=FormPageAction("action","init_default");
			print_infor("��Ʊ��¼�ѳɹ�ɾ��",'trip',"location='?$return'","?$return",0);
		}
    	$db->CompleteTrans();
		exit;	
	
	}
	addShortCutByDate("createtime","¼��ʱ��");
	$filetablename		=	'kaipiaorecord';
	$parse_filename		=	'kaipiaorecord';
	require_once('include.inc.php');
	
	?>