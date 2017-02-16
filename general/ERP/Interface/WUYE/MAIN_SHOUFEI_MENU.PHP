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


	<A hideFocus title="水电气收费明细" href="wu_wpgfeesdetails_newai.php" target=menu_main_frame>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>水电气收费明细</SPAN></A>

	<A hideFocus title="物业收费明细" href="wu1_wpgfeesdetails_newai.php" target=menu_main_frame>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>物业收费明细</SPAN></A>

	<A hideFocus title="费用收取汇总" href="wu_costsummary_newai.php" target=menu_main_frame>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>费用收取汇总</SPAN></A>

	<A hideFocus title="费用收取" href="wu_feiyongshouqu.php" target=menu_main_frame>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>费用收取</SPAN></A>

	<A hideFocus title="费用收取查询" href="wu_costReport.php" target=menu_main_frame>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>费用收取查询</SPAN></A>

   <!-- 
	<A hideFocus title="已收费用统计" href="" target=menu_main_frame>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>已收费用统计</SPAN></A>
	 -->

	<A hideFocus title="欠费统计" href="wu_qianfei.php" target=menu_main_frame>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>欠费统计</SPAN></A>

	<A hideFocus title="清单报表打印" href="wu_shoufeibaobiao.php" target=menu_main_frame>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>清单报表打印</SPAN></A>


	<A hideFocus title="收费设置及电表管理" href="MAIN_SHOUFEIGUANLI.php" target=menu_main_frame>
	<SPAN><IMG height=16 src="images/notify_new.gif" width=16 align=absMiddle>收费设置及水电气表管理</SPAN></A>


</DIV></DIV></BODY></HTML>


