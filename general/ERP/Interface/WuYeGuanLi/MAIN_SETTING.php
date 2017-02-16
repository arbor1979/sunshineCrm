<?php

require_once('../EDU/lib.inc.php');
$GLOBAL_SESSION=returnsession();
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HTML><HEAD><TITLE>类型设置</TITLE><LINK href="images/style.css" type=text/css
rel=stylesheet>
<SCRIPT src="images/ccorrect_btn.js"></SCRIPT>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="MSHTML 6.00.6000.16735" name=GENERATOR></HEAD>
<?php
$MenuArray[] = array("wygl_pingjialeixing_newai.php","评价类型","评价类型");
$MenuArray[] = array("wygl_biaoxiuxiangmu_newai.php","报修项目","报修项目");

$fileName = $MenuArray[0][0];
?>
<FRAMESET id=frame1 border=0 frameSpacing=0 rows=30,* frameBorder=NO cols=*>
<FRAME name=menu_top src="MAIN_SETTING_MENU.php" frameBorder=0 noResize scrolling=no>
<FRAME name=menu_mainXX src="<?php echo $fileName?>" frameBorder=0 noResize></FRAMESET>
</HTML>
