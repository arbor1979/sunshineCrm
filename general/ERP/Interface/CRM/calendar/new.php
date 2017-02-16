<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
page_css('新建事务');
include_once( "utility_all.php" );
echo "\r\n<html>\r\n<head>\r\n<title>新建事务</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\"><script src=\"/inc/js/module.js\"></script>\r\n\r\n<script Language=\"JavaScript\">\r\nfunction CheckForm()\r\n{\r\n   if(document.form1.CONTENT.value==\"\")\r\n   { alert(\"事务内容不能为空！\");\r\n     return (false);\r\n   }\r\n   return (true);\r\n}\r\n\r\nfunction change_remind()\r\n{\r\n   document.form1.END_MIN.value=document.form1.CAL_MIN.value;\r\n   var END_HOUR_INDEX=parseFloat(document.form1.CAL_HOUR.value)+1;\r\n   if(END_HOUR_INDEX==24) END_HOUR_INDEX=0;\r\n   document.form1.END_HOUR.options(END_HOUR_INDEX).selected=true;\r\n   document.form1.REMIND_TIME.value=document.form1.CAL_DATE.value+\" \"+document.form1.CAL_HOUR.value+\":\"+document.form1.CAL_MIN.value+\":00\"\r\n}\r\n</script>\r\n</head>\r\n\r\n\r\n";
if ( $CAL_TIME == "" || $CAL_TIME == "undefined" )
{
    $CUR_HOUR = date( "H", time( ) ) + 1;
}
else
{
    $CUR_HOUR = $CAL_TIME;
}
$CUR_MIN = "00";
$CAL_END = $CUR_HOUR + 1;
if ( $CUR_HOUR == 23 )
{
    $CAL_END = "00";
}
echo "\r\n<body class=\"bodycolor\" topmargin=\"5\" onload=\"document.form1.CONTENT.focus();\">\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" class=\"small\">\r\n  <tr>\r\n    <td class=\"Big\"><img src=\"../../../Framework/images/calendar.gif\" align=\"absMiddle\" WIDTH=\"22\" HEIGHT=\"20\" align=\"absmiddle\"><span class=\"big3\"> 新建事务</span>\r\n    </td>\r\n  </tr>\r\n</table>\r\n\r\n <table class=\"TableBlock\" width=\"450\" align=\"center\">\r\n  <form action=\"submit.php\"  method=\"post\" name=\"form1\" onsubmit=\"return CheckForm();\">\r\n    <tr>\r\n      <td nowrap class=\"TableData\"> 日期：</td>\r\n      <td class=\"TableData\">\r\n        <input type=\"text\" class=\"BigInput\" name=\"CAL_DATE\" value=\"";
echo $CAL_DATE;
echo "\" size=\"11\">\r\n        <img src=\"../../../Framework/images/calendar.gif\" align=\"absMiddle\" border=\"0\" style=\"cursor:pointer\" onclick=\"td_calendar('form1.CAL_DATE');\" align=\"absMiddle\">\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td nowrap class=\"TableData\">开始时间：</td>\r\n      <td class=\"TableData\">\r\n<!-------------- 时 ------------>\r\n        <select name=\"CAL_HOUR\" class=\"\" onchange=\"change_remind();\">\r\n";
$I = 0;
for ( ; $I <= 23; ++$I )
{
    if ( $I < 10 )
    {
        $I = "0".$I;
    }
    echo "          <option value=\"";
    echo $I;
    echo "\" ";
    if ( $I == $CUR_HOUR )
    {
        echo "selected";
    }
    echo ">";
    echo $I;
    echo "</option>\r\n";
}
echo "        </select>：\r\n\r\n<!-------------- 分 ------------>\r\n        <select name=\"CAL_MIN\" class=\"\" onchange=\"change_remind();\">\r\n";
$I = 0;
for ( ; $I <= 59; ++$I )
{
    if ( $I < 10 )
    {
        $I = "0".$I;
    }
    echo "          <option value=\"";
    echo $I;
    echo "\" ";
    if ( $I == $CUR_MIN )
    {
        echo "selected";
    }
    echo ">";
    echo $I;
    echo "</option>\r\n";
}
echo "        </select>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td nowrap class=\"TableData\">结束时间：</td>\r\n      <td class=\"TableData\">\r\n\r\n<!-------------- 时 ------------>\r\n        <select name=\"END_HOUR\" class=\"\">\r\n";
$I = 0;
for ( ; $I <= 23; ++$I )
{
    if ( $I < 10 )
    {
        $I = "0".$I;
    }
    echo "          <option value=\"";
    echo $I;
    echo "\" ";
    if ( $I == $CAL_END )
    {
        echo "selected";
    }
    echo ">";
    echo $I;
    echo "</option>\r\n";
}
echo "        </select>：\r\n\r\n<!-------------- 分 ------------>\r\n        <select name=\"END_MIN\" class=\"\">\r\n";
$I = 0;
for ( ; $I <= 59; ++$I )
{
    if ( $I < 10 )
    {
        $I = "0".$I;
    }
    echo "          <option value=\"";
    echo $I;
    echo "\" ";
    if ( $I == $CUR_MIN )
    {
        echo "selected";
    }
    echo ">";
    echo $I;
    echo "</option>\r\n";
}
echo "        </select>\r\n      </td>\r\n    </tr>\r\n         </td>\r\n    </tr>\r\n    <tr>\r\n      <td nowrap class=\"TableData\"> 事务内容：</td>\r\n      <td class=\"TableData\">\r\n        <textarea name=\"CONTENT\" cols=\"45\" rows=\"5\" class=\"BigInput\"></textarea>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td nowrap class=\"TableData\"> 提醒时间：</td>\r\n      <td class=\"TableData\">\r\n        <input type=\"text\" name=\"REMIND_TIME\" size=\"19\" maxlength=\"19\" class=\"BigInput\" value=\"";
echo $CAL_DATE;
echo " 09:00:00\">\r\n        <img src=\"../../../Framework/images/menu/calendar.gif\" align=\"absMiddle\" border=\"0\" style=\"cursor:pointer\" onclick=\"td_calendar('form1.REMIND_TIME');\">\r\n        <img src=\"../../../Framework/images/menu/clock.gif\" align=\"absMiddle\" border=\"0\" style=\"cursor:pointer\" onclick=\"td_clock('form1.REMIND_TIME');\">\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td nowrap class=\"TableData\"> 提醒：</td>\r\n      <td class=\"TableData\">\r\n";
echo sms_remind( 5 );
echo "      </td>\r\n    </tr>\r\n    <tr align=\"center\" class=\"TableControl\">\r\n      <td colspan=\"2\" nowrap>\r\n        <input type=\"submit\" value=\"确定\" class=\"BigButton\">&nbsp;&nbsp;\r\n        <input type=\"button\" value=\"关闭\" class=\"BigButton\" onclick=\"window.close();\">\r\n      </td>\r\n    </tr>\r\n  </table>\r\n</form>\r\n\r\n</body>\r\n</html>";
?>
