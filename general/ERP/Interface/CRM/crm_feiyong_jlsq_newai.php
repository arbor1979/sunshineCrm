<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css("费用申请");

	addShortCutByDate("申请日期");

	if($_GET['action']=="edit_default_data")		{

		$单号 = $_POST['单号'];
		$sql = "select 是否作废 from crm_feiyong_sq where 单号='$单号'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();

		if($_POST['是否审核'] == 2 || $_POST['是否审核'] == 3){
		   $_POST['审核日期'] = date("Y-m-d");
		   $_POST['审核人']  = $_SESSION['LOGIN_USER_ID'];
		   $备注   = $_POST['备注'];
		   //拆分字符串
           $bz = substr($备注,0,7);
		   if($bz != "<审核人"){
		      //$_POST['备注'] = "<审核人:".$审核人.">".$_POST['备注'];
		   }
		}

		if($_POST['是否作废'] == '1')						{
		   $_POST['作废日期'] = date("Y-m-d");
		   $作废人 = $_SESSION['LOGIN_USER_ID'];
		   //$_POST['备注'] = "<作废人：".$作废人.">".$_POST['备注'];
		}

		if($rs_a[0]['是否作废'] == 1 && 0){

		   print "
			<div align=\"center\" title=\"作废记录管理\">
			<table class=\"MessageBox\" align=\"center\" width=\"650\"><tr><td class=\"msg info\">
			<div class=\"content\" style=\"font-size:12pt\">&nbsp;&nbsp;此项记录已经作废，系统禁止操作.</div>
			</td></tr></table>
			<br>
			<div align=center>
			";
			  print "<input type=button  value=\"返回\" class=\"SmallButton\" onClick=\"history.go(-2);\">
			</div>
			";
		   exit;
		}
	}




	$filetablename		=	'crm_feiyong_sq';
	$parse_filename		=	'crm_feiyong_jlsq';
	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
			$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			说明：<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;1、总经理可以对申请的部分内容进行修改，对申请点击修改进行审核和退回操作.<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;2、如果对应记录已经审核或退回，系统将禁止对其进行操作.<BR>
			</font></td></table>";
			print $PrintText;
		}
	?>