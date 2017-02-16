<?php
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();

//判断是否为BASE64编码
$isBase64 = isBase64();
//进行_GET变量转换
$isBase64==1?CheckBase64():'';
/*
if($_GET['action']=="add_default")		{
	header("location:stockin_input_newai.php?returnAction=init");
}
if($_GET['action']=="edit_default"&&$_GET['ROWID']!="")		{
	//print_R($_GET);
	header("location:stockin_input_newai.php?action=edit_default&ROWID=".$_GET['ROWID']);
}

*/
//确认入库
validateMenuPriv("入库单");
if($_GET['action']=="edit_default2")			
{
	$rowid=$_GET['billid'];
	//更新库存
	try {
		
		$Store=new Store($db);
		//开启事务
	    $db->StartTrans();   
	    //入库
	    //$db->debug=true;
	    $Store->confirmRuKu($rowid);
		$db->CompleteTrans();
		page_css("入库单确认");
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			
			$return=FormPageAction("action","init_default");
			print_infor("入库单已成功确认",'trip',"location='?$return'","?$return",0);
		}	
		
	}
	catch (Exception $e) 
	{   
		print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	} 
	exit;	
}

//撤销入库
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	try 
	{
		$Store=new Store($db);
		//开启事务
		//$db->debug=1;
	    $db->StartTrans();  
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				
				$Store->deleteRuKu($selectid[$i]);
				
			}
		}
		page_css("入库单删除");
		$db->CompleteTrans();
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			
			$return=FormPageAction("action","init_default");
			print_infor("入库单已成功删除",'trip',"location='?$return'","?$return",0);
		}
    	
		
	}
	catch(Exception $e)
	{
		print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;	
}
addShortCutByDate("createtime","创建时间","最近一月");
$filetablename='stockinmain';
$SYSTEM_ADD_SQL=getKucunByUserid($SYSTEM_ADD_SQL,$_SESSION['LOGIN_USER_ID']);
require_once('include.inc.php');
systemhelpContent("入库操作说明",'100%');



?>