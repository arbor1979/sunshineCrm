<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("收票记录");
	
	if($_GET['action']=="add_default_data")
	{
		try 
		{
			$piaojujine=floatvalue($_POST['piaojujine']);
			$billinfo=returntablefield("buyplanmain", "billid", $_POST['caigoubillid'], "totalmoney,shoupiaomoney");
			$maxjine=$billinfo['totalmoney']-$billinfo['shoupiaomoney'];
			if($maxjine>0 && $piaojujine>$maxjine)
				throw new Exception("本次收票金额不能大于$maxjine");
			if($maxjine<0 && $piaojujine<$maxjine)
				throw new Exception("本次收票金额不能小于$maxjine");
			if($piaojujine==0)
				throw new Exception("本次收票金额不能为0");
			global $db;
			$db->StartTrans();
			$CaiWu =new CaiWu($db);
			$CaiWu->insertShouPiao($_POST['supplyid'],$_POST['caigoubillid'],$_POST['kaipiaoneirong'],$_POST['piaojutype'],$_POST['fapiaono'],$_POST['piaojujine'],$_SESSION['LOGIN_USER_ID'],$_POST['qici'],$_POST['beizhu'],$_POST['kaipiaodate']);
			$db->CompleteTrans();
			page_css("收票记录");
			//是否事务出现错误
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());
			else 
			{ 
				
				$return=FormPageAction("action","init_default");
				print_infor("新增收票记录成功",'trip',"location='?$return'","?$return",0);
				
			}
	    	
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $e->getMessage())."');window.history.back(-1);</script>";
		}
    	exit;
		
	}
	
	else if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
			
		//开启事务
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
		page_css("开票记录");
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			
			$return=FormPageAction("action","init_default");
			print_infor("开票记录已成功删除",'trip',"location='?$return'","?$return",0);
		}
    	
		exit;	
	
	}
	addShortCutByDate("createtime","创建时间");
	$filetablename		=	'shoupiaorecord';
	$parse_filename		=	'shoupiaorecord';
	require_once('include.inc.php');
	?>