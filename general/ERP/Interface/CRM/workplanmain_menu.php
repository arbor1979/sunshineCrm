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

$MenuArray[] = array("workplanmain_newai.php","我发起的");
$MenuArray[] = array("workplanmain_zhixing.php","需我执行的");
$MenuArray[] = array("workplanmain_xiaji.php","查看下级的");

for($i=0;$i<sizeof($MenuArray);$i++)					{
	$manuAddress = $MenuArray[$i][0];
	$menuName = $MenuArray[$i][1];
	
	print "<A hideFocus href=\"$manuAddress\" target=menu_main_frame>
	<SPAN><IMG height=16 src=\"images/notify_new.gif\" width=16 align=absMiddle>$menuName</SPAN></A> ";
}


?>
</div>
</div>
</body>
</html>