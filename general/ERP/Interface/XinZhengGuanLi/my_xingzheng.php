<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HEAD><TITLE>我的行政考勤记录</TITLE>
<LINK href="/theme/<?php echo $LOGIN_THEME?>/images/style.css" type=text/css rel=stylesheet>
<frameset rows="30,*"  cols="*" frameborder="0" border="0" framespacing="0" id="frame1">
    <frame name="file_title" scrolling="no" noresize src="my_xingzheng_menu.php" frameborder="0">
    <frame name="menu_main_frame" scrolling="auto" src="my_xingzheng_kaoqinmingxi_newai.php" frameborder="0">
</frameset>

<?php
//自动执行SQL SERVER语句,同步教师数据到OA数据库
	//print_R($_GET);
	if(1)		{
		$URL_XINGZHENG = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/general/EDU/Interface/XinZhengGuanLi/edu_xingzheng_kaoqinmingxi_automake_exec.php";
		require_once('../../config_mssql_teacherkaoqin.php');
		//print $MS_userdb_pwd;print $MS_userdb;
		if($MS_userdb_pwd!="sa")		{
			print "<iframe src=\"$URL_XINGZHENG\" width=0 height=0> ";
		}
	}
?>