<?php
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
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
