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

require_once( "include.inc.php" );
$sessionkey = returnsesskey( );
$GLOBAL_SESSION = returnsession( );
$ExecTimeBegin = getmicrotime( );
$lang = returnsystemlang( );
$columns = returntablecolumn( $filetablename );
$html_etc = returnsystemlang( $filetablename );
$common_html = returnsystemlang( "common_html" );
if ( $_GET['action'] == "sms_send" )
{
				print "\r\n\t<form action=\"http://sms.zhengzhou.gov.cn/sms/comm/send_lt.asp\"  method=post name=form1>\r\n\t<input type=hidden name=uid value=50006>\r\n\t<input type=hidden name=upass value=888888>\r\n\t<textarea cols=50 name=user_number rows=3>".$_GET[user_number]."</textarea>\r\n\t<textarea cols=30 name=msg_content rows=5>".$_GET[msg_content]."</textarea>\r\n\t<form>\r\n\r\n\t<script>\r\n\tdocument.form1.submit();\r\n\t</script>\r\n\r\n\t";
}
?>
