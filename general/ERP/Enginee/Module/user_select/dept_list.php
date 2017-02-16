<?php
session_start();
include_once( "../user_select/setting.inc.php" );
print "<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"xtree.css\" />\r\n<div id=\"xtree\" class=\"xtree\" xname=\"";
echo $xname;
echo "\" showButton=\"";
echo $showButton;
echo "\" XmlSrc=\"tree.php?DEPT_ID=0&PARA_URL=";
echo $PARA_URL;
echo "&e=";
echo $e;
echo "&PARA_TARGET=";
echo $PARA_TARGET;
echo "&PRIV_NO_FLAG=";
echo $PRIV_NO_FLAG;
echo "&PARA_ID=";
echo $PARA_ID;
echo "&PARA_VALUE=";
echo $PARA_VALUE;
echo "&showButton=";
echo $showButton;
echo "\"></div>\r\n\r\n";
?>
