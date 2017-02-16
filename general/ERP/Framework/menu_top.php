<?php
/*
版权归属:郑州单点科技软件有限公司;
联系方式:0371-69663266;
公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
*/

require_once( "lib.inc.php" );
require_once( "../Enginee/newai.php" );
$GLOBAL_SESSION = returnsession( );
$lang = returnsystemlang( );
$systemlang = $_SESSION[$SUNSHINE_USER_LANG_VAR];
$common_html = returnsystemlang( "common_html" );
$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\r\n<HTML><HEAD><TITLE></TITLE><LINK href=\"images/style.css\" type=text/css \r\nrel=stylesheet>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n";
echo "<S";
echo "CRIPT>\r\nfunction view_online()\r\n{\r\n  parent.user_online.location=\"user_online.php\";\r\n   setTimeout('view_online();',60000);\r\n}\r\n\r\nsetTimeout('view_online();',60000);\r\n</SCRIPT>\r\n\r\n<META content=\"MSHTML 6.00.2743.600\" name=GENERATOR></HEAD>\r\n<BODY leftMargin=0 topMargin=0 onload=parent.init_menu()>\r\n<TABLE class=small height=\"100%\" cellSpacing=0 borderColorDark=#ffffff \r\ncellPadding=0 width=\"100%\" bgColo";
echo "r=#eeeeee borderColorLight=#000000 border=1>\r\n  <TBODY>\r\n  <TR>\r\n    <TD id=menu_1 onmouseover=parent.setPointer(this,1,1) title=mainmenu \r\n    style=\"CURSOR: hand\" onclick=parent.view_menu(1) \r\n    onmouseout=parent.setPointer(this,2,1) align=middle>";
echo $common_html['common_html']['mainmenu'];
echo "</TD>\r\n    <TD id=menu_2 onmouseover=parent.setPointer(this,1,2) title=onlineusers\r\n    style=\"CURSOR: hand\" onclick=parent.view_menu(2) \r\n    onmouseout=parent.setPointer(this,2,2) align=middle>";
echo $common_html['common_html']['onlineuser'];
echo "</TD>\r\n    <TD id=menu_3 onmouseover=parent.setPointer(this,1,3) title=MyTask  \r\n    style=\"CURSOR: hand\" onclick=parent.view_menu(3) \r\n    onmouseout=parent.setPointer(this,2,3) align=middle>";
echo $common_html['common_html']['Allusers'];
echo "</TD></TR></TBODY></TABLE></BODY></HTML>\r\n";
?>
