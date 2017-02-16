<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();



$_GET['出库性质'] = "领用";
$_GET['出库对象'] = $_SESSION['LOGIN_USER_NAME'];
$_GET['action']=checkreadaction('init_customer');
//对校长查看权限进行特殊定义
if($_GET['指定人员']!="")			{
	$指定人员姓名 = returntablefield("user","USER_ID",$_GET['指定人员'],"USER_NAME");
	$_GET['出库对象'] = $指定人员姓名;
}
else	{
	$_GET['出库对象'] = $_SESSION['LOGIN_USER_NAME'];
}

$filetablename='officeproductout';
require_once('include.inc.php');

require_once('../Help/module_officeproduct.php');

?>