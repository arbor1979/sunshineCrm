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
$GLOBAL_SESSION = returnsession( );
$common_html = returnsystemlang( "common_html" );
require_once( "./sms_index/single_select.php" );
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Frameset//EN\">\r\n<!-- saved from url=(0036)http://localhost/module/user_select/ -->\r\n<HTML><HEAD><TITLE>";
echo $framework_html[$choose_lang]['adduser'];
echo "</TITLE>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\"><LINK \r\nhref=\"../theme/3/images/style.css\" type=text/css rel=stylesheet>\r\n<META content=\"MSHTML 6.00.2800.1106\" name=GENERATOR></HEAD>\r\n\r\n<FRAMESET id=bottom1 border=1 frameSpacing=0 rows=230,* frameBorder=YES cols=*>\r\n<FRAMESET id=bottom2 border=1 frameSpacing=0 rows=* frameBorder=YES cols=*,0>\r\n<FRAME name=user src=\"./select_dep";
echo "artmentlist.php?tablename=";
echo $_GET['tablename'];
echo "&fieldid=";
echo $_GET['fieldid'];
echo "&fieldname=";
echo $_GET['fieldname'];
echo "&field=";
echo $_GET['field'];
echo "&field2=";
echo $_GET['field2'];
echo "&type=";
echo $_GET['type'];
echo "&title=";
echo $_GET['title'];
echo "&AddUserField=";
echo $_GET['AddUserField'];
echo "\">\r\n</FRAMESET>\r\n<FRAME name=bottom3 src=\"otherinfor.php?action=bottom\" frameBorder=NO scrolling=no></FRAMESET>\r\n\r\n</HTML>";
?>
