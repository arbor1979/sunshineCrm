<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("Ԥ����");
	if($_GET['action']=="add_default_data")		{
		global $db;
		
		$supplyid=$_POST['supplyid'];
		$linkmanid=$_POST['linkmanid'];
		$accountid=$_POST['accountid'];
		$beizhu=$_POST['beizhu'];
		$jine=floatvalue($_POST['yufukuan']);
		
		if($jine==0)
		{
			print "<script language=javascript>alert('����Ԥ������ܵ���0');window.history.back(-1);</script>";
			exit;
		}
		//��������
		//$db->debug=1;
		$CaiWu=new CaiWu($db);
	    $db->StartTrans();  
		$CaiWu->insertYuFukuanReocord($supplyid,$linkmanid,$jine,$accountid,$_SESSION['LOGIN_USER_ID'],"Ԥ������",$beizhu);
		
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		 else 
		{ 
			page_css("Ԥ�����¼");
			$return=$_POST['url'];
			$return=$return."?".FormPageAction("action","init_default");
			print_infor("Ԥ�����¼������",'trip',"location='?$return'","$return",0);
			
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
					
					$CaiWu->deleteYuFukuanReocord($selectid[$i]);
					
				}

			}
			//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
			{
			 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			}
			else 
			{ 
				page_css("Ԥ�����¼");
				$return=FormPageAction("action","init_default");
				print_infor("Ԥ�����¼�ѳɹ�ɾ��",'trip',"location='?$return'","?$return",0);
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
	$filetablename		=	'v_accessprepay';
	$parse_filename		=	'v_accessprepay';
	require_once('include.inc.php');
	?>