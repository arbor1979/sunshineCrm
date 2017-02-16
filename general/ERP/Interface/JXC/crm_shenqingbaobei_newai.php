<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("项目报备");	
	
	$customerid=$_GET['customerid'];
	if($customerid!='' && $_GET['action']=='add_default')
	{
		$ADDINIT=array("customerid"=>$customerid);
	}
	
	//$SYSTEM_PRINT_SQL = 1;
	//print_r($_GET);exit;
	if($_GET['action']=="edit_TongYi")		{
		print "<script>location='crm_shenqingbaobei_shenhe.php?id=".$_GET['id']."';</script>";
		exit;
	}
	if($_POST['action']=="TongYi")		{
		page_css();
		$billid = $_GET['id'];
		$sql = "update crm_shenqingbaobei set state='2',shenheman='".$_SESSION['LOGIN_USER_ID']."',shenhetime=now(),piyu='".$_POST['piyu']."',tixingren='".$_POST["tixingren"]."' where id='$billid'";
		$rs = $db->Execute($sql);
		$touser=explode(",",$_POST["tixingren"]);
		$messagetitle="项目报备";
		$guanlianid=$billid;
		for($i=0;$i<sizeof($touser);$i++)
		{
			if($touser[$i]!="")
			{
				newMessage($touser[$i],$_POST['zhuti'],$messagetitle,'../JXC/crm_shenqingbaobei_newai.php?'.base64_encode('action=view_default&id='.$guanlianid),$guanlianid);
			}	
			
		}
		$return=FormPageAction("action","init_default");
		print_infor("<b>审核通过</b>",'trip',"location='?$return'","?".$return,1);
		exit;
	}
	if($_POST['action']=="FouJue")		{
		page_css();
		$billid = $_GET['id'];
		$sql = "update crm_shenqingbaobei set state='3',shenheman='".$_SESSION['LOGIN_USER_ID']."',shenhetime=now(),piyu='".$_POST['piyu']."' where id='$billid'";
		$rs = $db->Execute($sql);
		$return=FormPageAction("action","init_default");
		print_infor("<b>审核否决</b>",'trip',"location='?$return'","?".$return,1);
		exit;
		
	}
	if($_GET['action']=="edit_FouJue")		{
		page_css();
		$billid = $_GET['id'];
		$sql = "update crm_shenqingbaobei set state='1',shenheman='',shenhetime=null,piyu='' where id='$billid'";
		$rs = $db->Execute($sql);
		deleteMessage("项目报备",$billid);
		$return=FormPageAction("action","init_default");
		print_infor("<b>撤销审核</b>",'trip',"location='?$return'","?".$return,1);
		exit;
	}
	addShortCutByDate("createtime","申请时间");
	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"customerid");
	

	//数据表模型文件,对应Model目录下面的crm_shenqingbaobei_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'crm_shenqingbaobei';
	$parse_filename		=	'crm_shenqingbaobei';
	require_once('include.inc.php');
	?>