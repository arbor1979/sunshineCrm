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
$filetablename = "sms";
$sessionkey = returnsesskey( );
$GLOBAL_SESSION = returnsession( );
$ExecTimeBegin = getmicrotime( );
$lang = returnsystemlang( );
$columns = returntablecolumn( $filetablename );
$html_etc = returnsystemlang( $filetablename );
$common_html = returnsystemlang( "common_html" );
if ( $_GET['action'] == "sms_send" )
{
				$user_number = addslashes( $_POST['user_number'] );
				$msg_content = addslashes( $_POST['msg_content'] );
				$file = readfile( "mobile_sendsms.php?action=sms_send&user_number={$user_number}&msg_content={$msg_content}" );
				print_r( $file );
}
else
{
				require_once( "lib/html/mobile_sms.html" );
}
?>
