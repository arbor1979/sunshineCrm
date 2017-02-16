<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	$billid=$_GET['billid'];
	if($_GET['action']=="shenhe" || $_GET['action']=="shenheshoukuan")		
	{
		
		try 
		{
			//开启事务
			$CaiWu=new CaiWu($db);
	    	$db->StartTrans();  
	    	$CaiWu->dingdanshenhe($billid);
			$db->CompleteTrans();
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
		}
		
		if($_GET['action']=="shenhe")
		{
			page_css();
			$return=FormPageAction("action","init_default");
			print_infor("订单已审核",'trip',"location='?$return'","?$return",0);
			exit;
		}
		if($_GET['action']=="shenheshoukuan")
		{
			$customerid=returntablefield("sellplanmain","billid",$billid,"supplyid");
			print "<script>location='huikuanrecord_newai.php?action=add_default&customerid=$customerid&billid=$billid'</script>";
			exit;
		}
	}
	if($_GET['action']=="tuihui")
	{
		$sql="update sellplanmain set user_flag=0 where billid=$billid and user_flag=-2";
		$db->Execute($sql);
		page_css();
		$return=FormPageAction("action","init_default");
		print_infor("订单已退回",'trip',"location='?$return'","?$return",0);
		exit;
	}
	$filetablename		=	'v_dingdanshenhe';
	$parse_filename		=	'v_dingdanshenhe';
	require_once('include.inc.php');
	?>