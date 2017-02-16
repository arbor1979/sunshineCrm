<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
//print_R($_SESSION);
require_once('systemprivateinc.php');

$TARGET_TITLE = "通达软件实验室系统设置";

$TARGET_ARRAY = $PRIVATE_SYSTEM['通达软件实验室系统设置'];

$MenuArray = SystemPrivateInc($TARGET_ARRAY,$TARGET_TITLE);

$fileName = $MenuArray[0][0];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HEAD><TITLE>系统管理员设置部分</TITLE>

<LINK href="../../theme/<?php echo $LOGIN_THEME?>/images/style.css" type=text/css rel=stylesheet>
<frameset rows="30,*"  cols="*" frameborder="0" border="0" framespacing="0" id="frame1">
    <frame name="file_title" scrolling="no" noresize src="MAIN_SETTINGS_MENU.php" frameborder="0">
    <frame name="main_frame" scrolling="auto" src="<?php echo $fileName?>" frameborder="0">
</frameset>