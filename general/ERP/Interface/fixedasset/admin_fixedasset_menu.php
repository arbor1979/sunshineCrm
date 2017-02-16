<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');

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
<?php


$MenuArray[] = array("fixedassetout_newai.php","借领明细","借领明细");
$MenuArray[] = array("fixedassettui_newai.php","归还明细","归还明细");
$MenuArray[] = array("fixedassetin_newai.php","采购明细","采购明细");
$MenuArray[] = array("fixedassettiaoku_newai.php","调拨明细","调拨明细");
$MenuArray[] = array("fixedassetweixiu_newai.php","维修明细","维修明细");
$MenuArray[] = array("fixedassetbaofei_newai.php","报废明细","报废明细");



for($i=0;$i<sizeof($MenuArray);$i++)					{
	$菜单地址 = $MenuArray[$i][0];
	$菜单名称 = $MenuArray[$i][1];
	$菜单TITLE = $MenuArray[$i][2];
	print "<A hideFocus title=$菜单名称 href=\"$菜单地址\" target=menu_main_frame>
	<SPAN><IMG height=16 src=\"images/notify_new.gif\" width=16 align=absMiddle>$菜单名称</SPAN></A> ";
}


?>