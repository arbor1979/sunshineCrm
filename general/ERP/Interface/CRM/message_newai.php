<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	
	if($_GET['action']=="readed")		{
		global $db;
		$sql="update message set flag=1,readtime='".date("Y-m-d H:m:s")."' where id=".$_GET['id'];
		$db->Execute($sql);
		$_GET['action']='init_default';
		$_GET['flag']='0';
	}
	if($_GET['action']=="unread")		{
		global $db;
		$sql="update message set flag=0 where id=".$_GET['id'];
		$db->Execute($sql);
		$_GET['action']='init_default';
		$_GET['flag']='0';
	}
	if($_GET['action']=='operation_readed')
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
	
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				$sql="update message set flag=1 where id=".$selectid[$i];
				$db->Execute($sql);			
			}
		}
		$_GET['action']='init_default';
		$_GET['flag']='0';
	}
	
	if($_GET['action']=='')
	{
		
		$_GET['action']='init_default';
		$_GET['flag']='0';
	}
	
	//数据表模型文件,对应Model目录下面的message_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$SYSTEM_ADD_SQL=" and userid='".$_SESSION['LOGIN_USER_ID']."' and (attime is null or attime<now())";
	$filetablename		=	'message';
	$parse_filename		=	'message';
	require_once('include.inc.php');
	?>