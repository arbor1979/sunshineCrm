<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("回款记录");
	
	$customerid=$_GET['customerid'];
	if($customerid!='' && $_GET['action']=='add_default')
	{
		
		$dingdanbillid=$_GET['billid'];
		$ADDINIT=array("customerid"=>$customerid,"dingdanbillid"=>$dingdanbillid);
	}
	if($_GET['action']=="add_default_data")		{
		global $db;
		$oddment=floatvalue($_POST['oddment']);
		$accountid=$_POST['accountid'];
		$shoukuan=floatvalue($_POST['jine']);
		
		$billinfo=returntablefield("sellplanmain", "billid", $_POST['dingdanbillid'], "billtype,totalmoney,huikuanjine,oddment");
		$maxjine=$billinfo['totalmoney']-$billinfo['huikuanjine']-$billinfo['oddment'];
		if($shoukuan==0 && $oddment==0)
		{
			print "<script language=javascript>alert('回款金额和去零金额不能都为0');window.history.back(-1);</script>";
			exit;
		}
		if($maxjine>0 && $shoukuan+$oddment>$maxjine)
		{
			print "<script language=javascript>alert('错误：本次回款和去零合计不能大于".$maxjine."');window.history.back(-1);</script>";
			exit;
		}
		if($maxjine<0 && $shoukuan+$oddment<$maxjine)
		{
			print "<script language=javascript>alert('错误：本次回款和去零合计不能小于".$maxjine."');window.history.back(-1);</script>";
			exit;
		}
		/*
		if($shoukuan+$oddment==0)
		{
			print "<script language=javascript>alert('错误：本次回款+去零合计不能为0');window.history.back(-1);</script>";
			exit;
		}
		*/
		try {
			//开启事务
			//$db->debug=1;
			$CaiWu=new CaiWu($db);
		    $db->StartTrans();  
	
			//插入回款记录
			
			$accesstype="货款收取";
			//if($billinfo['billtype']==3)
			//	$accesstype="欠款收取";
				
			$CaiWu->insertShoukuanReocord($_POST['customerid'],$_POST['dingdanbillid'],$shoukuan,$accountid,$_SESSION['LOGIN_USER_ID'],$accesstype,$oddment,$_POST['qici'],$_POST['guanlianplanid']);
			
			//$CaiWu->updatesellplanmainhuikuan($_POST['dingdanbillid']);
			
			//回款计划
			if($_POST['guanlianplanid']!='')
			{
				$sql="update huikuanplan set ifpay='已回款' where id=".$_POST['guanlianplanid'];
				$n=$db->Execute($sql);
				
			}
			
			//是否事务出现错误
			if ($db->HasFailedTrans()) 
			{
			 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			}
			 else 
			{ 
				page_css("回款记录");
				$return=$_POST['url'];
				$return=$return."?".FormPageAction("action","init_default");
				print_infor("回款记录已生成",'trip',"location='?$return'","$return",0);
				
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
	//撤销回款
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
					$huikuaninfo=returntablefield("huikuanrecord", "id", $selectid[$i], "id,customerid,dingdanbillid,jine,oddment,accountid,guanlianplanid,jifenchongdimoney");	
					$dingdanbillid=$huikuaninfo['dingdanbillid'];
					$shoukuan=$huikuaninfo['jine'];
					$oddment=$huikuaninfo['oddment'];
					$accountid=$huikuaninfo['accountid'];
					$planid=$huikuaninfo['guanlianplanid'];
					$customerid=$huikuaninfo['customerid'];
					$jifenchongdimoney=$huikuaninfo['jifenchongdimoney'];
					
					//删除回款记录
					if($shoukuan!=0 || $oddment!=0 || $jifenchongdimoney!=0)
					{
						$CaiWu->deleteShoukuanReocord($selectid[$i]);
					}
					
					//回款计划
					if($planid!='')
					{
						$sql="update huikuanplan set ifpay='未回款' where id=".$planid;
						$db->Execute($sql);
					}
				}

			}
			//是否事务出现错误
			if ($db->HasFailedTrans()) 
			{
			 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
				//echo $db->ErrorMsg();
			}
			else 
			{ 
				page_css("回款记录");
				$return=FormPageAction("action","init_default");
				print_infor("回款记录已成功删除",'trip',"location='?$return'","?$return",0);
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
	//数据表模型文件,对应Model目录下面的huikuanrecord_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"createman");
	addShortCutByDate("createtime","创建时间");
	$filetablename		=	'huikuanrecord';
	$parse_filename		=	'huikuanrecord';
	require_once('include.inc.php');
	?>