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
	
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����message_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$SYSTEM_ADD_SQL=" and userid='".$_SESSION['LOGIN_USER_ID']."' and (attime is null or attime<now())";
	$filetablename		=	'message';
	$parse_filename		=	'message';
	require_once('include.inc.php');
	?>