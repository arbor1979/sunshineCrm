<?php
session_start();

include_once( "../user_select/setting.inc.php" );
print "<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">";
print "<meta http-equiv=\"x-ua-compatible\" content=\"IE=7\">";
print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."theme/$LOGIN_THEME/style.css\" />";
print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/lib/common.js\"></script>";
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
    $TO_ID = "TO_ID";
    $TO_NAME = "TO_NAME";
}
if ( $MANAGE_FLAG == "undefined" )
{
    $MANAGE_FLAG = "";
}
if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
    $FORM_NAME = "form1";
}
echo "\r\n<html>\r\n<head>\r\n<title>选择人员</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n</head>\r\n<script src=\"".ROOT_DIR."inc/js/utility.js\"></script>\r\n<script>\r\n
function getOpenner()
{
   if(is_moz)
   {
      return window.opener.document;
   }
   else
      return window.dialogArguments.document;
}
var parent_window = getOpenner();
var to_form = parent_window.form1;
var to_id =   to_form.".$TO_ID.";
var to_name = to_form.".$TO_NAME.";
function Load_Do()
{
   var TO_ID_STR = to_id.value;
	var TO_NAME_STR=to_name.value;	
	
   if(TO_ID_STR==\"\" || TO_NAME_STR==\"\")
         user.location=\"children.php?seldeptid=".$_SESSION['LOGIN_DEPT_ID']."&TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "&MODULE_ID=";
echo $MODULE_ID;
echo "&MANAGE_FLAG=";
echo $MANAGE_FLAG;
echo "&TO_ID_STR=\"+URLSpecialChars(TO_ID_STR);\r\n   else\r\n      user.location=\"selected.php?TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "&MODULE_ID=";
echo $MODULE_ID;
echo "&TO_ID_STR=\"+URLSpecialChars(TO_ID_STR)+\"&TO_NAME_STR=\"+URLSpecialChars(TO_NAME_STR);\r\n }\r\n</script>\r\n\r\n<frameset rows=\"*,30\"  rows=\"*\" frameborder=\"no\" border=\"1\" framespacing=\"0\" id=\"frame1\" onload=\"Load_Do();\">\r\n   <frameset cols=\"200,*\"  rows=\"*\" frameborder=\"yes\" border=\"1\" framespacing=\"0\" id=\"frame2\">\r\n      <frame name=\"dept\" src=\"dept.php?TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "&MODULE_ID=";
echo $MODULE_ID;
echo "&MANAGE_FLAG=";
echo $MANAGE_FLAG;
echo "\">\r\n      <frame name=\"user\" src=\"\">\r\n   </frameset>\r\n   <frame name=\"control\" scrolling=\"no\" src=\"control.php\">\r\n</frameset>\r\n";
?>
