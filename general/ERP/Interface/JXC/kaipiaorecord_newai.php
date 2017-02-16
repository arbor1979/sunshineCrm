<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("开票记录");

	//数据表模型文件,对应Model目录下面的kaipiaorecord_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	if($_GET['action']=="add_default_data")
	{
		global $db;
		$db->StartTrans();
		$CaiWu =new CaiWu($db);
		$CaiWu->insertKaiPiao($_POST['customerid'],$_POST['dingdanbillid'],$_POST['kaipiaoneirong'],$_POST['piaojutype'],$_POST['fapiaono'],$_POST['piaojujine'],$_SESSION['LOGIN_USER_ID']);
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			page_css("开票记录");
			$return=FormPageAction("action","init_default");
			print_infor("新增开票记录成功",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
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
				$CaiWu->deleteKaiPiao($selectid[$i]);
			}
		}
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			page_css("开票记录");
			$return=FormPageAction("action","init_default");
			print_infor("开票记录已成功删除",'trip',"location='?$return'","?$return",0);
		}
    	$db->CompleteTrans();
		exit;	
	
	}
	addShortCutByDate("createtime","录入时间");
	$filetablename		=	'kaipiaorecord';
	$parse_filename		=	'kaipiaorecord';
	require_once('include.inc.php');
	
	?>