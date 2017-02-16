<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	if($_GET['action']=="add_default")		
	{
		$CUR_HOUR = date('Y-m-d',strtotime("+3 days"));
		$ADDINIT=array("daohuodate"=>$CUR_HOUR);
	}
	if($_GET['action']=="add_default_data")		
	{
		$supplyid=$_POST['supplyid'];
		$linkman=$_POST['linkman'];
		$caigoudate=$_POST['caigoudate'];
		$daohuodate=$_POST['daohuodate'];
		$createman=$_SESSION['LOGIN_USER_ID'];
		$createtime=date('Y-m-d H:i:m');
		$state=0;
		$totalmoney=floatval($_POST['totalmoney']);
		$oddment=floatval($_POST['oddment']);
		$realmoney=floatval($_POST['realmoney']);
		$accountid=$_POST['accountid'];
		
		try 
		{
			if($totalmoney<($oddment+$realmoney))
				throw new Exception("去零加已付金额不能大于总金额 $totalmoney");
		
		    //开启事务
		    $db->StartTrans();  
		    $billid = returnAutoIncrement("billid","caigouorder");
		    //插入新纪录
			$sql="insert into caigouorder values($billid,'$supplyid','$linkman','$caigoudate','$daohuodate','$createman','$createtime',
			$totalmoney,$oddment,$realmoney,$accountid,$state)";
			$db->Execute($sql);
		    $CaiWu=new CaiWu($db);
		    if($accountid>0)
		    	$CaiWu->operateAccount($accountid,$realmoney,'采购订金',$billid);
		    else 
		    	$CaiWu->operatePrepay($supplyid,$realmoney,'采购订金',$billid);
			if($oddment!=0)
				$CaiWu->insertFeiYong(1,$oddment,$accountid,$_SESSION['LOGIN_USER_ID'],1,$billid,'');
			//是否事务出现错误
			if ($db->HasFailedTrans()) 
			 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			else 
			{ 
				page_css();
				$return=FormPageAction("action","init_default");
				print_infor("采购订单已生成，请录入明细",'trip',"location='?$return'","?$return",0);
				
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
	//撤销采购订单
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
					$caigouinfo=returntablefield("caigouorder", "billid", $selectid[$i], "billid,supplyid,accountid,totalmoney,oddment,realmoney");	
					$billid=$caigouinfo['billid'];
					$realmoney=$caigouinfo['realmoney'];
					$oddment=$caigouinfo['oddment'];
					$accountid=$caigouinfo['accountid'];
					$supplyid=$caigouinfo['supplyid'];
					$sql="update caigouorder set state=-1 where billid=$billid and state>-1";
					$rs=$db->Execute($sql);
					print_r($rs);
				    $CaiWu=new CaiWu($db);
				    if($accountid>0)
				    	$CaiWu->operateAccount($accountid,-$realmoney,'采购订金',$billid);
				    else 
				    	$CaiWu->operatePrepay($supplyid,-$realmoney,'采购订金',$billid);
					if($oddment!=0)
						$CaiWu->insertFeiYong(1,-$oddment,$accountid,$_SESSION['LOGIN_USER_ID'],1,$billid,'');

				}

			}
			//是否事务出现错误
			if ($db->HasFailedTrans()) 
			{
			 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			}
			else 
			{ 
				page_css("");
				$return=FormPageAction("action","init_default");
				//print_infor("采购订单成功删除",'trip',"location='?$return'","?$return",0);
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
	if($_GET['action']=="edit_default3")			
	{
		print "<script>location='caigouorder_mingxi.php?billid=".$_GET['billid']."'</script>";
		exit;
	}
	$SYSTEM_ADD_SQL=" and state>-1";
	$filetablename		=	'caigouorder';
	$parse_filename		=	'caigouorder';
	require_once('include.inc.php');
	?>