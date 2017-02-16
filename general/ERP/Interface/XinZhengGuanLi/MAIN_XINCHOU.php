<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

require_once('systemprivateinc.php');

$TARGET_TITLE = "人力资源-薪酬管理";

$TARGET_ARRAY = $PRIVATE_SYSTEM['人力资源']['薪酬管理'];

$MenuArray = SystemPrivateInc($TARGET_ARRAY,$TARGET_TITLE);

$fileName = $MenuArray[0][0];

//print_R($MenuArray);
//如果下属子菜单也只有一个菜单项,那么直接沿用下属菜单的那个菜单项
if(count($MenuArray)==1)	{
	EDU_Indextopage($MenuArray[0][0]);
	exit;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HEAD><TITLE>薪酬管理</TITLE>
<LINK href="/theme/<?php echo $LOGIN_THEME?>/style.css" type=text/css rel=stylesheet>
<frameset rows="30,*"  cols="*" frameborder="0" border="0" framespacing="0" id="frame1">
    <frame name="file_title" scrolling="no" noresize src="MAIN_XINCHOU_MENU.php" frameborder="0">
    <frame name="menu_main_frame2" scrolling="auto" src="<?php echo $fileName?>" frameborder="0">
</frameset>
