<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
$IsWin = IsWin();


//判断学期信息是否为空
$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
if($当前学期=="")		{
	page_css("您的学期信息没有设置");
	print_infor("您的学期信息没有设置,请在教务管理->教学基本信息->学期中设置");
	exit;
}

require_once('systemprivateinc.php');

$TARGET_TITLE = "人力资源";

$TARGET_ARRAY = $PRIVATE_SYSTEM[$TARGET_TITLE];

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
<HEAD><TITLE>人力资源</TITLE>
<LINK href="/theme/<?php echo $LOGIN_THEME?>/style.css" type=text/css rel=stylesheet>
<frameset rows="30,*"  cols="*" frameborder="0" border="0" framespacing="0" id="frame1">
    <frame name="file_title" scrolling="no" noresize src="MAIN_RENLIZIYUAN_MENU.php" frameborder="0">
    <frame name="menu_main_frame" scrolling="auto" src="<?php echo $fileName?>" frameborder="0">
</frameset>
