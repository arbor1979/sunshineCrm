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
$lang = returnsystemlang( );
$html_etc = returnsystemlang( "hrms" );
$common_html = returnsystemlang( "common_html" );
echo "<LINK \r\nhref=\"./images/style.css\" type=text/css rel=stylesheet>\r\n<META content=\"MSHTML 6.00.2800.1106\" name=GENERATOR>\r\n\r\n<BODY class=bodycolor leftMargin=0 topMargin=5>\r\n";
$action = $_GET['action_page'];
$action_page = $_GET['action_page'];
$to_id = $_GET['TO_ID'];
$to_name = $_GET['TO_NAME'];
$MODE = $_GET['MODE'];
require_once( "./sms_index/dept.php" );
page_css( "User Department List" );
depart_js( );
depart_header( );
depart_list( $to_id, $to_name );
?>
