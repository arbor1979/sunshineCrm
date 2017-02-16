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


    <A hideFocus title="维修服务管理" href="wuFWGL.php" target="menu_main_frame">
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align="absMiddle">维修服务管理</SPAN></A>


	
    <A hideFocus title="客户投诉" href="wuTSGL.php" target="menu_main_frame">
	<SPAN><IMG height="16" src="images/notify_new.gif" width="16" align="absMiddle">客户投诉</SPAN></A>




	<A hideFocus title="保安巡查" href="wu_securityinspections_newai.php" target="menu_main_frame">
	<SPAN><IMG height="16" src="images/notify_new.gif" width="16" align="absMiddle">保安巡查管理</SPAN></A>



    <A hideFocus title="外来人员登记表" href="wu_foreignworkers_newai.php" target="menu_main_frame">
	<SPAN><IMG height="16" src="images/notify_new.gif" width="16" align="absMiddle">外来人员登记表</SPAN></A>


</DIV></DIV></BODY></HTML>
