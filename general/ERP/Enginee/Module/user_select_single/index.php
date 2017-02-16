<?php
session_start();
include_once( "../user_select/setting.inc.php" );
print "<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">";
print "<meta http-equiv=\"x-ua-compatible\" content=\"IE=7\">";
print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."theme/$LOGIN_THEME/style.css\" />";

$TO_ID=$_GET['TO_ID'];
$TO_NAME=$_GET['TO_NAME'];
$MODULE_ID=$_GET['MODULE_ID'];
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
    $TO_ID = "TO_ID";
    $TO_NAME = "TO_NAME";
}
if ( $MODULE_ID == "undefined" )
{
    $MODULE_ID = "";
}
if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
    $FORM_NAME = "form1";
}

echo "\r\n<html>\r\n<head>\r\n<title>选择人员</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n\r\n</head>\r\n<frameset rows=\"*,30\"  rows=\"*\" frameborder=\"NO\" border=\"1\" framespacing=\"0\" id=\"bottom\">\r\n  <frameset cols=\"200,*\"  rows=\"*\" frameborder=\"YES\" border=\"1\" framespacing=\"0\">\r\n     <frame name=\"dept\" src=\"dept.php?TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&MODULE_ID=";
echo $MODULE_ID;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "\">\r\n     <frame name=\"user\" src=\"user.php?TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&MODULE_ID=";
echo $MODULE_ID;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "\">\r\n  </frameset>\r\n   <frame name=\"control\" scrolling=\"no\" src=\"control.php?TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&MANAGE_FLAG=";
echo $MANAGE_FLAG;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "\">\r\n</frameset>\r\n";
?>
