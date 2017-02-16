<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("报销单审核");
	if($_GET['action']=="shenhedan")		{

		$CaiWu=new CaiWu($db);
		$db->StartTrans();  
		$billid = $_GET['单号'];
		$feiyonginfo=returntablefield("v_feiyong_sq", "单号", $billid, "金额,费用类型,费用用途,申请日期,客户名称,录单员");
		$jine=$feiyonginfo['金额'];
		$fytype=$feiyonginfo['费用类型'];
		$yongtu=$feiyonginfo['费用用途'];
		$jingshouren=$feiyonginfo['录单员'];
		$jingshouren=returntablefield("user","USER_ID",$jingshouren,"USER_NAME");
		$sql = "update crm_feiyong_sq set 是否审核='4',出纳员='".$_SESSION['LOGIN_USER_ID']."',支付时间=now() where 单号='$billid'";
		$rs = $db->Execute($sql);
		$custName=returntablefield("customer","ROWID", $feiyonginfo['客户名称'], "supplyname");
		$CaiWu->insertFeiYongAccount($fytype,$jine,1,$_SESSION['LOGIN_USER_ID'],-1,$feiyonginfo['申请日期'],$yongtu."(".$custName.")","",$jingshouren);
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		 else 
		{ 
			page_css("报销单审核");
			$return=$return."?".FormPageAction("action","init_default");
			print_infor("已报销",'trip',"location='?$return'","$return",0);
			
		}
    	$db->CompleteTrans();
		exit;
	}
	addShortCutByDate("创建时间","申请时间");
	$filetablename		=	'v_feiyong_sq';
	$parse_filename		=	'v_feiyong_sq';
	require_once('include.inc.php');
	?>