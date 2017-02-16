<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="/theme/<?php echo $LOGIN_THEME?>/menu_top.css">
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

$MenuArray[] = array("hrms_salary_type_newai.php","项目列表","项目列表");
/*
$MenuArray[] = array("hrms_salary_type_gongzi_newai.php","工资项目设置","工资项目设置");
$MenuArray[] = array("hrms_salary_type_fuli_newai.php","福利项目设置","福利项目设置");
$MenuArray[] = array("hrms_salary_type_jc_newai.php","奖惩项目设置","奖惩项目设置");
$MenuArray[] = array("hrms_salary_type_baoxian_newai.php","保险项目设置","保险项目设置");
*/
$MenuArray[] = array("hrms_salary_stypebig_newai.php","费用类别","费用类别");




for($i=0;$i<sizeof($MenuArray);$i++)					{
	$菜单地址 = $MenuArray[$i][0];
	$菜单名称 = $MenuArray[$i][1];



	$菜单TITLE = $MenuArray[$i][2];
	print "<A hideFocus title=$菜单名称 href=\"$菜单地址\" target=menu_main_frame>
	<SPAN><IMG height=16 src=\"images/notify_new.gif\" width=16 align=absMiddle>$菜单名称</SPAN></A> ";
}


?>