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
require_once( "./sms_index/single_select.php" );
$lang = returnsystemlang( );
$html_etc = returnsystemlang( "hrms" );
$common_html = returnsystemlang( "common_html" );
$departmentid = isset( $_GET['departmentid'] ) ? $_GET['departmentid'] : $_SESSION[$SUNSHINE_USER_DEPT_VAR];
$action_page = $_GET['action_page'];
$MODE = $_GET['MODE'];
if ( $departmentid == "" || empty( $departmentid ) )
{
				$departmentid = 1;
}
require_once( "./sms_index/user.php" );
page_css( "User List User" );
frame_user_js( $departmentid, $_GET['TO_ID'], $_GET['TO_NAME'] );
frame_user_header( );
if ( $_GET['action_page'] == "single" )
{
				frame_user_data_one( $departmentid );
}
else
{
				frame_user_data( $departmentid );
}
?>
