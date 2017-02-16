<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("账户间转款");
	
	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);//exit;
		global $db;
		$fromaccount = $_POST['fromaccount'];
		$toaccount = $_POST['toaccount'];
		$jine=floatval($_POST['jine']);
		if($fromaccount==$toaccount)
		{
			print "<script language='javascript'>alert('转出账户和转入账户不能是同一账户');window.history.back(-1);</script>";
			exit;
		}
		if($jine<=0)
		{
			print "<script language='javascript'>alert('金额必须大于0');window.history.back(-1);</script>";
			exit;
		}
		try 
		{
		    $db->StartTrans();  
		    
		    $accountinfo=returntablefield("bank", "rowid", $fromaccount, "jine,syslock");
			$oldjine=$accountinfo['jine'];
			if($jine>$oldjine)
			{
				print "<script language='javascript'>alert('转出账户余额不足');window.history.back(-1);</script>";
				exit;
			}
			$sql="update bank set jine=jine-(".$jine.") where rowid=".$fromaccount;
			$db->Execute($sql);
			$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
			".$fromaccount.",".$oldjine.",".-$jine.",'账户间转款',".$_POST['id'].",'".$_POST['createman']."','".date("Y-m-d H:i:s")."')";
			$db->Execute($sql);
			
			$accountinfo=returntablefield("bank", "rowid", $toaccount, "jine,syslock");
			$oldjine=$accountinfo['jine'];
			$sql="update bank set jine=jine+(".$jine.") where rowid=".$toaccount;
			$db->Execute($sql);
			$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
			".$toaccount.",".$oldjine.",".$jine.",'账户间转款',".$_POST['id'].",'".$_POST['createman']."','".date("Y-m-d H:i:s")."')";
			$db->Execute($sql);
			
		    $db->CompleteTrans();
			//是否事务出现错误
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());
	
		}
		catch (Exception $e)
		{
			print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
			exit;
		}   
		
	}
	
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		try 
		{
			//开启事务
			
		    $db->StartTrans();  
			for($i=0;$i<sizeof($selectid);$i++)
			{
				if($selectid[$i]!="")
				{
						
					$billinfo=returntablefield("banktobank", "id", $selectid[$i], "fromaccount,toaccount,jine");
					$fromaccount=$billinfo['fromaccount'];
					$toaccount=$billinfo['toaccount'];
					$jine=$billinfo['jine'];
					$accountinfo=returntablefield("bank", "rowid", $fromaccount, "jine,syslock");
					$oldjine=$accountinfo['jine'];
					$sql="update bank set jine=jine+(".$jine.") where rowid=".$fromaccount;
					$db->Execute($sql);
					
					$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
					".$fromaccount.",".$oldjine.",".$jine.",'账户间转款',".$selectid[$i].",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
					$db->Execute($sql);
					
					$accountinfo=returntablefield("bank", "rowid", $toaccount, "jine,syslock");
					$oldjine=$accountinfo['jine'];
					$sql="update bank set jine=jine-(".$jine.") where rowid=".$toaccount;
					$db->Execute($sql);
					
					$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
					".$toaccount.",".$oldjine.",".-$jine.",'账户间转款',".$selectid[$i].",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
					$db->Execute($sql);
					
				}
	
			}
			$db->CompleteTrans();
			page_css("");
			//是否事务出现错误
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());

		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
			exit;
		}
		
	}
	
	//数据表模型文件,对应Model目录下面的banktobank_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'banktobank';
	$parse_filename		=	'banktobank';
	require_once('include.inc.php');
	?>