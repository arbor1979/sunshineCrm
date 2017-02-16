<?php
require_once('lib.inc.php');//

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("人力资源-行政考勤-我的考勤");
//print_R($_SESSION);
$_GET['人员'] = $_SESSION['LOGIN_USER_NAME'];
$_GET['人员用户名'] = $_SESSION['LOGIN_USER_ID'];

$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
if($_GET['学期']=="") $_GET['学期'] = $当前学期;

$SYSTEM_ADD_SQL = " and 人员用户名='".$_GET['人员用户名']."'";
//$SYSTEM_PRINT_SQL = 1;

addShortCutByDate("日期");

$filetablename='edu_xingzheng_kaoqinmingxi';
$parse_filename = 'my_xingzheng_kaoqinmingxi';



require_once('include.inc.php');



require_once('../Help/module_xingzhengkaoqin.php');


if($_GET['action']==''||$_GET['action']=='init_default')		{
	$PrintText = "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >
注意：此处仅为个人的行政考勤相关信息,仅为查询显示功能,个人排班功能是数字化校园->人力资源->行政考勤菜单中进行分组和排班。
</font></td></table>";
	print $PrintText;
}

?>