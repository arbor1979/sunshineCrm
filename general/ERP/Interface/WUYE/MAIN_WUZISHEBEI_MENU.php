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

    <!--  -->
    <A hideFocus title="物资设备明细" href="wu_materialsequipmentmx_newai.php" target="menu_main_frame">

	<SPAN><IMG height="16" src="images/notify_new.gif" width="16" align="absMiddle">物资设备明细</SPAN></A>

	<A hideFocus title="设备初始化" href="wu_materialsequipment_newai.php" target="menu_main_frame">

	<SPAN><IMG height="16" src="images/notify_new.gif" width="16" align="absMiddle">设备初始化</SPAN></A>

	<A hideFocus title="设备借领明细" href="wu_materialsequipmentj_newai.php" target="menu_main_frame">

	<SPAN><IMG height="16" src="images/notify_new.gif" width="16" align="absMiddle">设备借领明细</SPAN></A>

	<A hideFocus title="设备归还明细" href="wu_materialsequipmenth_newai.php" target="menu_main_frame">

	<SPAN><IMG height="16" src="images/notify_new.gif" width="16" align="absMiddle">设备归还明细</SPAN></A>

	<A hideFocus title="设备维修明细" href="wu_materialsequipmentx_newai.php" target="menu_main_frame">

	<SPAN><IMG height="16" src="images/notify_new.gif" width="16" align="absMiddle">设备维修明细</SPAN></A>

	<A hideFocus title="设备报废明细" href="wu_materialsequipmentf_newai.php" target="menu_main_frame">

	<SPAN><IMG height="16" src="images/notify_new.gif" width="16" align="absMiddle">设备报废明细</SPAN></A>




</DIV></DIV></BODY></HTML>
