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
require_once( "./sms_index/single_select.php" );
$common_html = returnsystemlang( "common_html" );
$GLOBALS['_GET']['TO_ID'] = isset( $_GET['TO_ID'] ) ? $_GET['TO_ID'] : "TO_ID";
$GLOBALS['_GET']['TO_NAME'] = isset( $_GET['TO_NAME'] ) ? $_GET['TO_NAME'] : "TO_NAME";
$GLOBALS['_GET']['action_page'] = isset( $_GET['action_page'] ) ? $_GET['action_page'] : "action_page";
$MODE = $_GET['MODE'];
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Frameset//EN\">\r\n<!-- saved from url=(0036)http://localhost/module/user_select/ -->\r\n<HTML>\r\n<HEAD>\r\n<TITLE>\r\n";
echo $common_html['common_html']['adduser'];
echo "</TITLE>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n<LINK href=\"./images/style.css\" type=text/css rel=stylesheet>\r\n<META content=\"MSHTML 6.00.2800.1106\" name=GENERATOR>\r\n</HEAD>\r\n<FRAMESET id=bottom border=1 frameSpacing=0 rows=225,* frameBorder=YES cols=*>\r\n<FRAMESET id=bottom border=1 frameSpacing=0 rows=* frameBorder=YES cols=150,*>\r\n<FRAME name=dept \r\nsrc=\"./frame_user_dept.p";
echo "hp?action_page=";
echo $_GET['action_page'];
echo "&TO_ID=";
echo $_GET['TO_ID'];
echo "&TO_NAME=";
echo $_GET['TO_NAME'];
echo "&MODE=";
echo $MODE;
echo "\">\r\n<FRAME name=user \r\nsrc=\"./frame_user_user.php?action_page=";
echo $_GET['action_page'];
echo "&TO_ID=";
echo $_GET['TO_ID'];
echo "&TO_NAME=";
echo $_GET['TO_NAME'];
echo "&MODE=";
echo $MODE;
echo "\">\r\n</FRAMESET>\r\n<FRAME name=bottom \r\nsrc=\"otherinfor.php?action=bottom\" frameBorder=NO scrolling=no></FRAMESET></HTML>\r\n";
?>
