<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("Ԥ�տ�");
	if($_GET['action']=="add_default_data")		{
		global $db;
		
		$customerid=$_POST['customerid'];
		$linkmanid=$_POST['linkman'];
		$accountid=$_POST['accountid'];
		$beizhu=$_POST['beizhu'];
		$jine=floatvalue($_POST['yushoukuan']);
		$realjine=floatvalue($_POST['realjine']);
		if($jine==0)
		{
			print "<script language=javascript>alert('����Ԥ�տ���ܵ���0');window.history.back(-1);</script>";
			exit;
		}
		if($realjine==0)
		{
			print "<script language=javascript>alert('����ʵ�տ���ܵ���0');window.history.back(-1);</script>";
			exit;
		}
		//��������
		//$db->debug=1;
		$CaiWu=new CaiWu($db);
	    $db->StartTrans();  
		$CaiWu->insertYuShoukuanReocord($customerid,$linkmanid,$jine,$accountid,$_SESSION['LOGIN_USER_ID'],"Ԥ�ջ���",$beizhu,$realjine);
		
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		 else 
		{ 
			page_css("Ԥ�տ��¼");
			$return=$_POST['url'];
			$return=$return."?".FormPageAction("action","init_default");
			print_infor("Ԥ�տ��¼������",'trip',"location='?$return'","$return",0);
			
		}
    	$db->CompleteTrans();
		exit;	
	}
	//��������
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		try 
		{
			//��������
			$CaiWu=new CaiWu($db);
			//$db->debug=1;
		    $db->StartTrans();  
			for($i=0;$i<sizeof($selectid);$i++)
			{
				if($selectid[$i]!="")
				{
					
					$CaiWu->deleteYuShoukuanReocord($selectid[$i]);
					
				}

			}
			//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
			{
			 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			}
			else 
			{ 
				page_css("Ԥ�տ��¼");
				$return=FormPageAction("action","init_default");
				print_infor("Ԥ�տ��¼�ѳɹ�ɾ��",'trip',"location='?$return'","?$return",0);
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
	addShortCutByDate("createtime","����ʱ��");
	$filetablename		=	'v_accesspreshou';
	$parse_filename		=	'v_accesspreshou';
	require_once('include.inc.php');
	?>