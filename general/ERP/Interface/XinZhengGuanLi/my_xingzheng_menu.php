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


$MenuArray[] = array("my_xingzheng_kaoqinmingxi_newai.php","实际考勤","实际考勤");
$MenuArray[] = array("my_xingzheng_kaoqin_newai.php","打卡","原始打卡");
$MenuArray[] = array("my_xingzheng_qingjia_newai.php","请假外出","请假外出");
$MenuArray[] = array("my_xingzheng_jiabanbuxiu_newai.php","加班补休","加班补休");
$MenuArray[] = array("my_xingzheng_tiaoxiububan_newai.php","调休加班","调休加班");
$MenuArray[] = array("my_xingzheng_tiaoban_newai.php","调班","调班");
$MenuArray[] = array("my_xingzheng_tiaobanxianghu_newai.php","相互调班","相互调班");
$MenuArray[] = array("my_xingzheng_kaoqinbudeng_newai.php","补登","考勤补登");
$MenuArray[] = array("my_xingzheng_kaoqin_static.php","统计","考勤统计");
$MenuArray[] = array("edu_xingzheng_kaoqinmingxi_administrator_change_peraonal.php","初始化","个人初始化");


for($i=0;$i<sizeof($MenuArray);$i++)					{
	$菜单地址 = $MenuArray[$i][0];
	$菜单名称 = $MenuArray[$i][1];
	$菜单TITLE = $MenuArray[$i][2];
	print "<A hideFocus title=$菜单名称 href=\"$菜单地址\" target=menu_main_frame>
	<SPAN><IMG height=16 src=\"images/notify_new.gif\" width=16 align=absMiddle>$菜单名称</SPAN></A> ";
}


?>