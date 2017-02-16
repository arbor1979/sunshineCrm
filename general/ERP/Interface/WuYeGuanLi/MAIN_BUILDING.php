<?php

require_once('../EDU/lib.inc.php');

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HTML><HEAD><TITLE>MAIN_BUILDING</TITLE><LINK href="images/style.css" type=text/css
rel=stylesheet>
<SCRIPT src="images/ccorrect_btn.js"></SCRIPT>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="MSHTML 6.00.6000.16735" name=GENERATOR></HEAD>
<?php
$MenuArray[] = array("edu_building_newai.php","教学楼设置","教学楼设置");
$MenuArray[] = array("dorm_building_newai.php","宿舍楼设置","宿舍楼设置");

$fileName = $MenuArray[0][0];
?>
<FRAMESET id=frame1 border=0 frameSpacing=0 rows=30,* frameBorder=NO cols=*>
<FRAME name=menu_top src="MAIN_BUILDING_MENU.php" frameBorder=0 noResize scrolling=no>
<FRAME name=menu_mainXX src="<?php echo $fileName?>" frameBorder=0 noResize></FRAMESET>
</HTML>
