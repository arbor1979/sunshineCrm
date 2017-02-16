<?php
	require_once("lib.inc.php");
	
	$GLOBAL_SESSION=returnsession();

	$common_html=returnsystemlang('common_html');
	

	$_GET['所属状态'] = "资产已报废";//资产已报废

	$_GET['使用人员'] = $_SESSION['LOGIN_USER_NAME'];
	//对校长查看权限进行特殊定义
	if($_GET['指定人员']!="")			{
		$指定人员姓名 = returntablefield("user","USER_ID",$_GET['指定人员'],"USER_NAME");
		$_GET['使用人员'] = $指定人员姓名;
	}
	else	{
		$_GET['使用人员'] = $_SESSION['LOGIN_USER_NAME'];
	}

	$filetablename='fixedasset';
	$parse_filename = "my_fixedassetbaofeilist";
	require_once('include.inc.php');

?>