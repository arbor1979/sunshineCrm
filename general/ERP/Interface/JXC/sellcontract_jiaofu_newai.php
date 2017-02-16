<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("交付记录");
	//删除交付记录
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		try 
		{
			
			//开启事务
			$Store=new Store($db);
			//$db->debug=1;
		    $db->StartTrans();  
			for($i=0;$i<sizeof($selectid);$i++)
			{
				if($selectid[$i]!="")
				{
					$Store->deleteHeTongJiaoFu($selectid[$i]);
				}
			}
			//是否事务出现错误
			if ($db->HasFailedTrans()) 
			{
			 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			}
			else 
			{ 
				page_css("交付记录删除");
				$return=FormPageAction("action","init_default");
				print_infor("交付记录已成功删除",'trip',"location='?$return'","?$return",0);
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
	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"customerid");
	$limitEditDelCust='customerid';
	//数据表模型文件,对应Model目录下面的sellcontract_jiaofu_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'sellcontract_jiaofu';
	$parse_filename		=	'sellcontract_jiaofu';
	require_once('include.inc.php');
	?>