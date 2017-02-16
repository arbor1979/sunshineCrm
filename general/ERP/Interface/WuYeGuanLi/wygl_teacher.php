<?php

require_once('../EDU/lib.inc.php');
$GLOBAL_SESSION=returnsession();
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HTML><HEAD><TITLE>网上报修</TITLE><LINK href="images/style.css" type=text/css
rel=stylesheet>
<SCRIPT src="images/ccorrect_btn.js"></SCRIPT>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="MSHTML 6.00.6000.16735" name=GENERATOR></HEAD>
<?php
$MenuArray[0][0] = "wygl_wangshangbaoxiu_teacher.php";
$MenuArray[0][1] = "网上报修";
$MenuArray[0][2] = "网上报修";

$MenuArray[1][0] = "wygl_weixiupingjia_teacher.php";
$MenuArray[1][1] = "维修评价";
$MenuArray[1][2] = "维修评价";

$fileName = $MenuArray[0][0];

//print_R($MenuArray);
//如果下属子菜单也只有一个菜单项,那么直接沿用下属菜单的那个菜单项
if(count($MenuArray)==1)	{
	EDU_Indextopage($MenuArray[0][0]);
	exit;
}

?>
<FRAMESET id=frame1 border=0 frameSpacing=0 rows=30,* frameBorder=NO cols=*>
<FRAME name=menu_top src="wygl_teacher_menu.php" frameBorder=0 noResize scrolling=no>
<FRAME name=menu_main_frame src="<?php echo $fileName?>" frameBorder=0 noResize></FRAMESET>
</HTML>
