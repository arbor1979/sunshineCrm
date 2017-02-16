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

CheckSystemPrivate("人力资源-行政考勤-原始打卡");
//######################教育组件-权限较验部分##########################

$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
if($_GET['学期']=="") $_GET['学期'] = $当前学期;


addShortCutByDate("考勤日期");

if($_GET['action']=="init_default"||$_GET['action']=="")					{
	//print "		<table border=0 class=TableBlock width=100% height=20>		<tr class=TableData><td valign=bottom align=left>该部分数据从考勤机里面提取,数据格式项:教师用户名,教师姓名,考勤日期,刷卡时间.数据导入前,请先<input type=button accesskey=c name=cancel value=\"删除上月考勤数据\" class=SmallButton onClick=\"location='?".base64_encode("action=DeleteCurMonth")."'\" > <BR></td></tr>		</table><BR>		";
}

if($_GET['action']=="DeleteCurMonth")					{
	page_css("考勤数据清理中...");
	$LikeMonth = date("Y-m-",mktime(1,1,1,date("m")-1,date("d"),date("Y")));
	$sql = "delete from edu_teacherkaoqin where 考勤日期 like '$LikeMonth%'";
	$db->Execute($sql);
	//exit;
	print "
		<table border=0 class=TableBlock width=100% height=20>
		<tr class=TableHeader><td valign=bottom align=left>当月考勤信息已经被删除,你可以重新导入该月考勤数据,系统返回中...<BR></td></tr>
		</table><BR>
		";
	EDU_Indextopage('?',$nums='0');
	exit;
}


$filetablename='edu_teacherkaoqin';
require_once('include.inc.php');


require_once('../Help/module_xingzhengkaoqin_yuanshidaka.php');

?>