<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";

	validateMenuPriv("发货方式","客户联系人","供应商联系人","发货单");
	if($_GET['action']=="delete_array")
	{
		$selectid=explode(",",$_GET['selectid']);
		for($i=0;$i<count($selectid);$i++)
		{
			if($selectid[$i]!='')
			{
				
				$billid=returntablefield("fahuodan", "fahuotype", $selectid[$i], "billid");
				if($billid!='')
				{
					$fahuoname=returntablefield("fahuotype", "id", $selectid[$i], "name");
					print "<script language='javascript'>alert('".$fahuoname." 存在发货单记录，请先删除相关单据');window.history.back(-1);</script>";
					exit;
				}
				
			}
		}
		
	}
	if($_POST['action']=="postmoban")
	{
		global $db;
		$content=$_POST['moban'];
		$content=urldecode($content);
		$contentArray = explode("\r\n",$content);
		
		$NewArray = array();
		for($i=0;$i<sizeof($contentArray);$i++)		{
			$Element = $contentArray[$i];
			
			$ElementArray = explode(".ADD_PRINT_TEXT",$Element);
			if($ElementArray[1]!="")	{
				$NewArray[] = $Element;
			}
			$ElementArray = explode(".SET_PRINT_STYLEA",$Element);
			if($ElementArray[1]!="")	{
				$NewArray[] = $Element;
			}
			
		}
		$RESULT = join("\r\n",$NewArray);
		
		$sql="update fahuotype set design='".$RESULT."' where id=".$_POST['id'];
		$db->Execute($sql);
		print_r($RESULT);
		exit;
	}
	if($_POST['action']=="getmoban")
	{
		global $db;
		$sql="select design from fahuotype where id=".$_POST['id'];
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		if(sizeof($rs_a)>0)
			echo $rs_a[0]['design'];
		//print $sql;
		exit;
	}
	$filetablename		=	'fahuotype';
	$parse_filename		=	'fahuotype';
	require_once('include.inc.php');
	?>