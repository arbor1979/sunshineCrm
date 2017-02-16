<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
$IsWin = IsWin();
$fileName = "../../Framework/inc_XingzhengKaoQin_page.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HEAD><TITLE>行政考勤管理</TITLE>
<LINK href="/theme/<?php echo $LOGIN_THEME?>/style.css" type=text/css rel=stylesheet>
<frameset rows="30,*"  cols="*" frameborder="0" border="0" framespacing="0" id="frame1">
    <frame name="file_title" scrolling="no" noresize src="XingzhengKaoQin_header.php" frameborder="0">
    <frameset rows="*"  cols="220,*" frameborder="0" border="0" framespacing="0" id="frame2">
       <frame name="left" scrolling="auto" resize src="<?php echo $fileName?>" frameborder="0">
       <frame name="edu_main" scrolling="auto" src="../Help/XingzhengKaoQin.php" frameborder="0">
    </frameset>
</frameset>
