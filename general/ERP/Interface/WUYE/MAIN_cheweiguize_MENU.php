<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/menu_top.css">
<script>
window.onload=function()
{
	 var type=2-2;
   var menu_id=0,menu=document.getElementById("navMenu");
   if(!menu) return;

   for(var i=0; i<menu.childNodes.length;i++)
   {
      if(menu.childNodes[i].tagName!="A")
         continue;
      if(menu_id==type)
         menu.childNodes[i].className="active";

      menu.childNodes[i].onclick=function(){
         var menu=document.getElementById("navMenu");
         for(var i=0; i<menu.childNodes.length;i++)
         {
            if(menu.childNodes[i].tagName!="A")
               continue;
            menu.childNodes[i].className="";
         }
         this.className="active";
      }
      menu_id++;
   }
};
</script>
</head>
<body>
<div id="navPanel">
  <div id="navMenu">


<A hideFocus title="停车场管理" href="wu_tingchechang_newai.php" target=menu_main1>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>停车场管理</SPAN></A>


<A hideFocus title="停车位管理" href="wu_tingchewei_newai.php" target=menu_main1>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>停车位管理</SPAN></A>

<A hideFocus title="车位费用规则设置" href="wu_tingchefeiguize_newai.php" target=menu_main1>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>车位费用规则设置</SPAN></A>


<A hideFocus title="车位状态设置" href="wu_cheweizhuangtai_newai.php" target=menu_main1>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>车位状态设置</SPAN></A>
</DIV></DIV></BODY></HTML>
