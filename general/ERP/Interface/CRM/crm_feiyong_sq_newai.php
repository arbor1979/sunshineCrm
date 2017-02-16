<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("报销申请");	
	//$SYSTEM_PRINT_SQL = 1;
	//print_r($_GET);exit;
	$customerid=$_GET['客户名称'];
	if($customerid!='' && $_GET['action']=='add_default')
	{
		$ADDINIT=array("客户名称"=>$customerid);
	}
	if($_GET['action']=="edit_TongYi")		{

		page_css();
		$billid = $_GET['单号'];
		$sql = "update crm_feiyong_sq set 是否审核='2',审核人='".$_SESSION['LOGIN_USER_ID']."',审核日期=now() where 单号='$billid'";
		$rs = $db->Execute($sql);
		$billinfo=returntablefield("crm_feiyong_sq","单号",$billid,"费用类型,金额,录单员");
		$feiyongname=returntablefield("v_feiyongbaoxiao","id",$billinfo['费用类型'],"typename");
		newMessage($billinfo['录单员'],$feiyongname.'(金额:'.$billinfo['金额'].')--已通过！','报销申请','../CRM/crm_feiyong_sq_newai.php?'.base64_encode('action=view_default&单号='.$billid),$billid);
		$return=FormPageAction("action","init_default");
		print_infor("<b>审核通过</b>",'trip',"location='?$return'","?".$return,1);
		exit;
	}
	if($_GET['action']=="edit_FouJue")		{
		page_css();
		$billid = $_GET['单号'];
		$sql = "update crm_feiyong_sq set 是否审核='3',审核人='".$_SESSION['LOGIN_USER_ID']."',审核日期=now() where 单号='$billid'";
		$rs = $db->Execute($sql);
		$return=FormPageAction("action","init_default");
		print_infor("<b>审核否决</b>",'trip',"location='?$return'","?".$return,1);
		exit;
		
	}
	$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"录单员");
	addShortCutByDate("创建时间","创建时间");
	$filetablename		=	'crm_feiyong_sq';
	$parse_filename		=	'crm_feiyong_sq';
	require_once('include.inc.php');

	
	?>