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
page_css( "System Setting" );
$goalfile = "system_config.ini";
if ( $_GET['action'] == "" || $_GET['action'] == "init" )
{
				@$ini_file = @parse_ini_file( $goalfile );
				form_begin( "form1", "action=updatedata" );
				table_begin( );
				print_title( $common_html['common_html']['systemconfiginformation'] );
				print_tr( "�������ʾ:", "CompanyName", $ini_file[CompanyName], 50, 1, "SmallInput", "" );
				print_tr( "״̬����ʾ:", "status_bar", $ini_file[status_bar], 50, 1, "SmallInput", "" );
				print_tr( "IE������:", "IETitle", $ini_file[IETitle], 50, 1, "SmallInput", "" );
				print_tr( "��¼���������:", "LoginTitle", $ini_file[LoginTitle], 50, 1, "SmallInput", "" );
				print_submit( $common_html['common_html']['submit'],2,'all','#');
				table_end( );
				form_end( );
}
if ( $_GET['action'] == "updatedata" )
{
				if ( is_file( $goalfile ) )
				{
								unlink( $goalfile );
				}
				$goalfile = $goalfile;
				$_POST['status_bar']=str_replace("(", "��", $_POST['status_bar']);
				$_POST['status_bar']=str_replace(")", "��", $_POST['status_bar']);
				$_POST['CompanyName']=str_replace("(", "��", $_POST['CompanyName']);
				$_POST['CompanyName']=str_replace(")", "��", $_POST['CompanyName']);
				$_POST['IETitle']=str_replace("(", "��", $_POST['IETitle']);
				$_POST['IETitle']=str_replace(")", "��", $_POST['IETitle']);
				$_POST['LoginTitle']=str_replace("(", "��", $_POST['LoginTitle']);
				$_POST['LoginTitle']=str_replace(")", "��", $_POST['LoginTitle']);
				$string = "[section]\nstatus_bar={$_POST['status_bar']}\n";
				$string .= "CompanyName={$_POST['CompanyName']}\n";
				$string .= "IETitle={$_POST['IETitle']}\n";
				$string .= "LoginTitle={$_POST['LoginTitle']}\n";
				$string .= "provinces={$_POST['provinces']}\n";
				!( $handle = @fopen( $goalfile, "w" ) );
				if ( !fwrite( $handle, $string ) )
				{
								exit( );
				}
				fclose( $handle );
				page_css( "Configure" );
				$showtext = "�������!";
				print_infor( $showtext, "trip", "?","system_interface.php",1);
}
?>
