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

global $HTTP_SESSION_VARS;
include( "./adodb/adodb.inc.php" );
include( "./adodb/adodb-session.php" );
adodb_sess_open( false, false, false );
session_start( );
$key = returnsesskey( );
$sndg_community = $HTTP_SESSION_VARS[sndg_community];
$sess_val = adodb_sess_read( $key );
if ( !session_is_registered( "sndg_community" ) )
{
}
$elementid = $HTTP_GET_VARS[elementid];
$elementname = $HTTP_GET_VARS[elementname];
if ( $elementid == "" || empty( $elementid ) )
{
				$elementid = "TO_ID2df";
}
if ( $elementname == "" || empty( $elementname ) )
{
				$elementname = "TO_NAME2df";
}
require_once( "lib.inc.php" );
require_once( "./sms_index/single_select.php" );
page_css( "Department list" );
frame_user_js_( $elementid, $elementname );
frame_user_header_( );
frame_user_data_department( 2 );
echo "<br>\r\n<hr>\r\n<DIV align=center><INPUT class=BigButton onclick=parent.close(); type=button value=�ر�> \r\n</DIV>\r\n";
?>
