<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();


	$_GET['报废申请人'] = $_SESSION['LOGIN_USER_NAME'];
	//$_GET['所属状态'] = "购置未分配,购置已分配,资产已分配,资产已归还";
	//对校长查看权限进行特殊定义
	if($_GET['指定人员']!="")			{
		$指定人员姓名 = returntablefield("user","USER_ID",$_GET['指定人员'],"USER_NAME");
		$_GET['报废申请人'] = $指定人员姓名;
	}
	else	{
		$_GET['报废申请人'] = $_SESSION['LOGIN_USER_NAME'];
	}
	$filetablename='fixedassetbaofei';
	$parse_filename = 'my_fixedassetbaofei';


	require_once('include.inc.php');


require_once('../Help/module_fixxedasset.php');

?>