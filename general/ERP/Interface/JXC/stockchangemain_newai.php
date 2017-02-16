<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("库存调拨单");
	//生成出入库单
	if($_GET['action']=="edit_default4")
	{
	
		//开启事务
    	try {
	    	$db->StartTrans();  
		    	//$db->debug=true;
	   		$Store=new Store($db);
	   		$Store->newDiaoBoRuKu($_GET['billid']);
	    		//是否事务出现错误
			if ($db->HasFailedTrans()) 
			 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
	    	else 
			{ 
				page_css("");
				$return=FormPageAction("action","init_default");
				print_infor("已生成出入库单，等待库管确认",'trip',"location='?$return'","?$return",0);
			}
			$db->CompleteTrans();
	    	exit;
    	}
    	catch (Exception $e)
		{
			print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
    		exit;
		} 
		
	}
	//删除调拨单
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		try 
		{
			//开启事务
			$Store=new Store($db);
		    $db->StartTrans();  
			for($i=0;$i<sizeof($selectid);$i++)
			{
				if($selectid[$i]!="")
					$Store->deleteDiaoBo($selectid[$i]);
			}
			//是否事务出现错误
			if ($db->HasFailedTrans()) 
			 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			else 
			{ 
				page_css("调拨单删除");
				$return=FormPageAction("action","init_default");
				print_infor("调拨单已成功删除",'trip',"location='?$return'","?$return",0);
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
	
	if($_GET['action']=="add_default_data" || $_GET['action']=="edit_default_data")
	{
		if($_POST['instoreid']==$_POST['outstoreid'])
		{
			print "<script language=javascript>alert('错误：调出仓库和调入仓库不能为同一仓库');window.history.back(-1);</script>";
    		exit;
		}
	}	
	if($_GET['action']=="edit_default2")			
	{
		$storeid=returntablefield("stockchangemain","billid",$_GET['billid'],"outstoreid");
		print "<script>location='DataQuery/productFrame.php?tablename=stockchangemain_detail&deelname=调拨单明细&rowid=".$_GET['billid']."&storeid=".$storeid."'</script>";
		exit;
	}
	//数据表模型文件,对应Model目录下面的stockchangemain_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	addShortCutByDate("createtime","调拨单创建时间");
	$filetablename		=	'stockchangemain';
	$parse_filename		=	'stockchangemain';
	require_once('include.inc.php');
	systemhelpContent("库存调拨说明",'100%');
?>