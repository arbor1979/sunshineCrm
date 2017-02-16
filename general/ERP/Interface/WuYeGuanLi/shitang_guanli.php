<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HEAD><TITLE>食堂信息管理</TITLE>
<LINK href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/images/style.css" type=text/css rel=stylesheet>
<frameset rows="30,*"  cols="*" frameborder="0" border="0" framespacing="0" id="frame1">
    <frame name="file_title" scrolling="no" noresize src="my_shitang_menu.php" frameborder="0">
    <frame name="menu_main_frame" scrolling="auto" src="edu_shitangjiance_newai.php" frameborder="0">
</frameset>