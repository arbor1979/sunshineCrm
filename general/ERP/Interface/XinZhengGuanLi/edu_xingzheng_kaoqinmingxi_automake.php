<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//######################教育组件-权限较验部分##########################
require_once("lib.inc.php");
require_once("../../Enginee/lib/version.php");
//require_once("lib.xingzheng.inc.php");
require_once("lib.xiaoli.inc.php");
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
page_css();

require_once("systemprivateinc.php");
//CheckSystemPrivate("教务管理-日常教学管理-教师考勤");
//######################教育组件-权限较验部分##########################


//作用:只用于同步考勤机数据到edu_teacherkaoqin表,注:已经在教师考勤中实现,此处属于备份使用
//2010-2-26修改

$CurXueQi = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");






/*

TRUNCATE TABLE `edu_xingzheng_kaoqinmingxi` ;
TRUNCATE TABLE `edu_teacherkaoqin` ;

*/

//得到现有MYSQL里面最近一次考勤记录ID的值
$sql = "select max(考勤机ID值) AS 编号 from edu_teacherkaoqin";
$rs = $db->Execute($sql);
$最近一次考勤记录ID的值 = $rs->fields['编号'];
if($最近一次考勤记录ID的值>0)		 $AddSqlKaoQinJiText = "where $考勤表_主EKY>'$最近一次考勤记录ID的值'";
else	$AddSqlKaoQinJiText = "";





//#######################################################################################
//使用MSSQL数据连接部分代码-开始
//#######################################################################################
if($SYSTEM_VERSION_CONTENT=="TONGDA")					{
	page_css("自动检测是否安装MSSQL数据库信息");
	print_infor("您的服务器没有检测到考勤机SQL SERVER数据库信息,请确认装有指定型号的考勤机类型和数据库后再进行读取考勤信息操作,VERSION INFOR IS ERROR",'stop',"location='?'");
	exit;
}

if($SYSTEM_VERSION_CONTENT=="JMQX")					{
	include "../EDU/KAOQINJI_JMQX.php";
	exit;
}

if($SYSTEM_VERSION_CONTENT=="HCVT")					{
	include "../EDU/KAOQINJI_HCVT.php";
	exit;
}

if($SYSTEM_VERSION_CONTENT=="FJHG")					{
	include "../EDU/KAOQINJI_FJHG.php";
	exit;
}


?>