<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("资金注入抽取");
	
	if($_GET['action']=="add_default_data")		{
		
		$accountid=$_POST['accountid'];
		$jine=$_POST['jine'];
		$inouttype=$_POST['inouttype'];
		$memo=$_POST['memo'];
		global $db;
		$CaiWu=new CaiWu($db);	
		//开启事务
	    $db->StartTrans(); 
	    $CaiWu->insertBankZhuruAccount($jine,$accountid,$memo,$inouttype);
	    //是否事务出现错误
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("资金注入抽取");
			$return=FormPageAction("action","init_default");
			print_infor("新增资金注入抽取单成功",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
		exit;	
	}
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		global $db;
		$CaiWu=new CaiWu($db);
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				$CaiWu->deleteBankZhuruAccount($selectid[$i]);
			}
		}
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("资金注入抽取");
			$return=FormPageAction("action","init_default");
			print_infor("删除资金注入抽取单成功",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
		exit;
	}
	addShortCutByDate("opertime","操作时间");
	$filetablename		=	'bankzhuru';
	$parse_filename		=	'bankzhuru';
	require_once('include.inc.php');
	?>