<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("�˻���ת��");
	
	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);//exit;
		global $db;
		$fromaccount = $_POST['fromaccount'];
		$toaccount = $_POST['toaccount'];
		$jine=floatval($_POST['jine']);
		if($fromaccount==$toaccount)
		{
			print "<script language='javascript'>alert('ת���˻���ת���˻�������ͬһ�˻�');window.history.back(-1);</script>";
			exit;
		}
		if($jine<=0)
		{
			print "<script language='javascript'>alert('���������0');window.history.back(-1);</script>";
			exit;
		}
		try 
		{
		    $db->StartTrans();  
		    
		    $accountinfo=returntablefield("bank", "rowid", $fromaccount, "jine,syslock");
			$oldjine=$accountinfo['jine'];
			if($jine>$oldjine)
			{
				print "<script language='javascript'>alert('ת���˻�����');window.history.back(-1);</script>";
				exit;
			}
			$sql="update bank set jine=jine-(".$jine.") where rowid=".$fromaccount;
			$db->Execute($sql);
			$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
			".$fromaccount.",".$oldjine.",".-$jine.",'�˻���ת��',".$_POST['id'].",'".$_POST['createman']."','".date("Y-m-d H:i:s")."')";
			$db->Execute($sql);
			
			$accountinfo=returntablefield("bank", "rowid", $toaccount, "jine,syslock");
			$oldjine=$accountinfo['jine'];
			$sql="update bank set jine=jine+(".$jine.") where rowid=".$toaccount;
			$db->Execute($sql);
			$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
			".$toaccount.",".$oldjine.",".$jine.",'�˻���ת��',".$_POST['id'].",'".$_POST['createman']."','".date("Y-m-d H:i:s")."')";
			$db->Execute($sql);
			
		    $db->CompleteTrans();
			//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());
	
		}
		catch (Exception $e)
		{
			print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
			exit;
		}   
		
	}
	
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		try 
		{
			//��������
			
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
					".$fromaccount.",".$oldjine.",".$jine.",'�˻���ת��',".$selectid[$i].",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
					$db->Execute($sql);
					
					$accountinfo=returntablefield("bank", "rowid", $toaccount, "jine,syslock");
					$oldjine=$accountinfo['jine'];
					$sql="update bank set jine=jine-(".$jine.") where rowid=".$toaccount;
					$db->Execute($sql);
					
					$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
					".$toaccount.",".$oldjine.",".-$jine.",'�˻���ת��',".$selectid[$i].",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
					$db->Execute($sql);
					
				}
	
			}
			$db->CompleteTrans();
			page_css("");
			//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());

		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
			exit;
		}
		
	}
	
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����banktobank_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'banktobank';
	$parse_filename		=	'banktobank';
	require_once('include.inc.php');
	?>