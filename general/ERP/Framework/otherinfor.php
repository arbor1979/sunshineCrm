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
$lang = returnsystemlang( );
$GLOBALS['_GET']['action'] = isset( $_GET['action'] ) ? $_GET['action'] : "bottom";
switch ( $_GET['action'] )
{
case "bottom" :
				echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\r\n<HTML><HEAD><TITLE></TITLE>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n";
				$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
				print "<LINK href=\"../theme/{$LOGIN_THEME}/style.css\" rel=stylesheet>";
				echo "\r\n<BODY class=bodycolor topMargin=5>\r\n<DIV align=right>\r\n<INPUT class=SmallButton onclick=parent.close(); type=button value='";
				echo $common_html['common_html']['close'];
				echo "'\r\n</DIV></BODY></HTML>\r\n\r\n";
}
?>
