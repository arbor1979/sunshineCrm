<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("预付款");
	if($_GET['action']=="add_default_data")		{
		global $db;
		
		$supplyid=$_POST['supplyid'];
		$linkmanid=$_POST['linkmanid'];
		$accountid=$_POST['accountid'];
		$beizhu=$_POST['beizhu'];
		$jine=floatvalue($_POST['yufukuan']);
		
		if($jine==0)
		{
			print "<script language=javascript>alert('错误：预付款金额不能等于0');window.history.back(-1);</script>";
			exit;
		}
		//开启事务
		//$db->debug=1;
		$CaiWu=new CaiWu($db);
	    $db->StartTrans();  
		$CaiWu->insertYuFukuanReocord($supplyid,$linkmanid,$jine,$accountid,$_SESSION['LOGIN_USER_ID'],"预付货款",$beizhu);
		
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		 else 
		{ 
			page_css("预付款记录");
			$return=$_POST['url'];
			$return=$return."?".FormPageAction("action","init_default");
			print_infor("预付款记录已生成",'trip',"location='?$return'","$return",0);
			
		}
    	$db->CompleteTrans();
		exit;	
	}
	//撤销付款
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		try 
		{
			//开启事务
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
			//是否事务出现错误
			if ($db->HasFailedTrans()) 
			{
			 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			}
			else 
			{ 
				page_css("预付款记录");
				$return=FormPageAction("action","init_default");
				print_infor("预付款记录已成功删除",'trip',"location='?$return'","?$return",0);
			}
	    	$db->CompleteTrans();
			exit;	
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	    	exit;
		}
	}
	addShortCutByDate("createtime","创建时间");
	$filetablename		=	'v_accessprepay';
	$parse_filename		=	'v_accessprepay';
	require_once('include.inc.php');
	?>