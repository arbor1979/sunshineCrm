<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("付款记录");
	if($_GET['action']=="add_default_data")		{
		try 
		{

			global $db;
			$oddment=floatvalue($_POST['oddment']);
			$accountid=$_POST['accountid'];
			$shoukuan=floatvalue($_POST['jine']);
			
			$billinfo=returntablefield("buyplanmain", "billid", $_POST['caigoubillid'], "totalmoney,paymoney,oddment");
			$maxjine=$billinfo['totalmoney']-$billinfo['paymoney']-$billinfo['oddment'];
			
			if($maxjine>0 && $shoukuan+$oddment>$maxjine)
				throw new Exception("本次付款和去零合计不能大于$maxjine");
			if($maxjine<0 && $shoukuan+$oddment<$maxjine)
				throw new Exception("本次付款和去零合计不能小于$maxjine");
			if($shoukuan+$oddment==0)
				throw new Exception("本次付款+去零合计不能为0");
	
			//开启事务
			//$db->debug=1;
			$CaiWu=new CaiWu($db);
		    $db->StartTrans();  
	
			//插入付款记录
			
			$accesstype="货款支付";
			$CaiWu->insertFukuanReocord($_POST['supplyid'],$_POST['caigoubillid'],$shoukuan,$accountid,$_SESSION['LOGIN_USER_ID'],$accesstype,$oddment,$_POST['qici'],$_POST['beizhu'],$_POST['guanlianplanid']);

			//付款计划
			if($_POST['guanlianplanid']!='')
			{
				$sql="update fukuanplan set ifpay='已付款' where id=".$_POST['guanlianplanid'];
				$db->Execute($sql);
			}
			
	    	$db->CompleteTrans();
			//是否事务出现错误
			page_css("付款记录");
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());
			else 
			{ 
				$return=$_POST['url'];
				$return=$return."?".FormPageAction("action","init_default");
				print_infor("付款记录已生成",'trip',"location='?$return'","$return",0);
				
			}
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $e->getMessage())."');window.history.back(-1);</script>";
		}
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
					$fukuaninfo=returntablefield("fukuanrecord", "id", $selectid[$i], "id,supplyid,caigoubillid,jine,oddment,accountid,guanlianplanid");	
					$caigoubillid=$fukuaninfo['caigoubillid'];
					$fukuan=$fukuaninfo['jine'];
					$oddment=$fukuaninfo['oddment'];
					$planid=$fukuaninfo['guanlianplanid'];
					
					//删除回款记录
					$CaiWu->deleteFukuanReocord($selectid[$i]);
					
					
					//回款计划
					if($planid!='')
					{
						$sql="update fukuanplan set ifpay='未付款' where id=".$planid;
						$db->Execute($sql);
					}
				}

			}
			$db->CompleteTrans();
			//是否事务出现错误
			page_css("付款记录");
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());
			else 
			{ 
				$return=FormPageAction("action","init_default");
				print_infor("付款记录已成功删除",'trip',"location='?$return'","?$return",0);
			}
	    	
			
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	    	exit;
		}
		exit;	
	}
	addShortCutByDate("createtime","创建时间");
	$filetablename		=	'fukuanrecord';
	$parse_filename		=	'fukuanrecord';
	require_once('include.inc.php');
	?>