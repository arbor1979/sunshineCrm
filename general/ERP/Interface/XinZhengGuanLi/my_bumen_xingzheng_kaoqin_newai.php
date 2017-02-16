<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//header("Content-Type:text/html;charset=gbk");
//######################教育组件-权限较验部分##########################
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("教务管理-日常教学管理-教师考勤");
//######################教育组件-权限较验部分##########################

//print_R($_GET);

	//班次过滤部分,班次字段必须设为隐藏分组属性--开始
	$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
	$sql = "select 班次名称 from edu_xingzheng_banci where 班次管理一='$LOGIN_USER_NAME' or 班次管理二='$LOGIN_USER_NAME'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$班次名称 = array();
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$Element = $rs_a[$i];
		$班次名称[]  = $Element['班次名称'];
	}
	$班次名称TEXT = join(',',$班次名称);
	if($班次名称TEXT=="")	$班次名称TEXT = "没有所管理的班次信息";
	$_GET['班次'] = $班次名称TEXT;
	//班次过滤部分,班次字段必须设为隐藏分组属性--结束

$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
if($_GET['学期']=="") $_GET['学期'] = $当前学期;

$filetablename='edu_teacherkaoqin';
$parse_filename = 'my_bumen_xingzheng_kaoqin';

require_once('include.inc.php');



?>