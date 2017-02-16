<?php
	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");

	CheckSystemPrivate("人力资源-行政考勤-组别");

	if($_GET['action'] == "add_default_data")
	{
		//print_R($_GET);
		//print_R($_POST);

		$行政组名称 = $_POST['行政组名称'];
		$_POST['组员名称'] = $_POST['COPY_TO_ID'];
		$备注 = $_POST['备注'];
		$创建人 = $_POST['创建人'];
		$创建时间 = $_POST['创建时间'];
		//$sql = "insert into edu_xingzheng_group values('','".$行政组名称."','".$组员名称."','".$备注."','".$创建人."','".$创建时间."')";
		//print $sql;exit;
		//$result = $db -> Execute($sql);
		//print "<meta http-equiv='refresh' content='1;url=?'>";
		//exit;
	}
	if($_GET['action'] == "edit_default_data")
	{
		//print_R($_GET);
		//print_R($_POST);
		//$记录编号 = $_GET['编号'];
		$_POST['组员名称'] = $_POST['COPY_TO_ID'];
		//$sql = "update edu_xingzheng_group set 组员名称='".$组员名称."' where 编号=".$记录编号;
		//print $sql;//exit;
		//$db -> Execute($sql);
		//print "<meta http-equiv='refresh' content='1;url=?'>";
		//exit;
	}

	$filetablename='edu_xingzheng_group';
	require_once('include.inc.php');


require_once("lib.xingzheng.inc.php");
//定时执行函数($函数名称='自动清理行政考勤中离职人员产生的多余数据',$间隔时间='30');

require_once('../Help/module_xingzhengkaoqin.php');



?>