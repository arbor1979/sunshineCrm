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
//CheckSystemPrivate("人力资源-行政考勤-我的考勤");
//######################教育组件-权限较验部分##########################

//print_R($_GET);
$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
if($_GET['学期']=="") $_GET['学期'] = $当前学期;

$_GET['教师姓名'] = $_SESSION['LOGIN_USER_NAME'];
$_GET['教师用户名'] = $_SESSION['LOGIN_USER_ID'];

$SYSTEM_ADD_SQL = " and 教师用户名='".$_GET['教师用户名']."'";
//$SYSTEM_PRINT_SQL = 1;

$filetablename='edu_teacherkaoqin';
$parse_filename = 'my_xingzheng_kaoqin';

require_once('include.inc.php');



require_once('../Help/module_kaoqinji.php');

?>