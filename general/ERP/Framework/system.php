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
if ( $_GET['action'] == "" || $_GET['action'] == "init" )
{
				form_begin( "form1" );
				table_begin( );
				print_title( "VOD��վ��Ϣ�趨���˲��ֲ��������趨ҳ��������ֵ��" );
				print_tr( "��վ��ַ ��", "index", $vod_config[index], 25, 1, "BigInput", "" );
				print_tr( "ӰƬͼƬ����ַ", "basepic", $vod_config[basepic], 25, 1, "BigInput", "" );
				print_tr( "ӰƬ�ļ�����ַ ��", "baseurl", $vod_config[baseurl], 25, 1, "BigInput", "" );
				$showtext6 = "<font color=red>*��ҳ�ײ���Ϣ*</font>";
				$showtext7 = "<font color=red>*��ҳ�ײ���Ϣ*</font>";
				$showtext8 = "<font color=red>*������ϵͳ�Ƿ��շѽ����趨*</font>";
				print_tr( "��Ȩ��Ϣ ��", "copyright", $vod_config[copyright], 15, 1, "BigInput", $showtext6 );
				print_tr( "��Ȩ��֯ ��", "issue", $vod_config[issue], 15, 1, "BigInput", $showtext7 );
				print_tr( "��ҳ���� ��", "email", $vod_config[email], 25, 1, "BigInput", "" );
				print_tr( "��ӭ��Ϣ ��", "welcome", $vod_config[welcome], 25, 1, "BigInput", "" );
				print_submit( );
				table_end( );
				form_end( );
}
if ( $_GET['action'] == "updatedata" )
{
				if ( is_file( $goalfile ) )
				{
								unlink( $goalfile );
				}
				$string = "<?php\n\$vod_config[index]=\"{$index}\";\n\$vod_config[basepic]=\"{$basepic}\";\n\$vod_config[baseurl]=\"{$baseurl}\";\n\$vod_config[copyright]=\"{$copyright}\";\n\$vod_config[issue]=\"{$issue}\";\n\$vod_config[email]=\"{$email}\";\n\$vod_config[welcome]=\"{$welcome}\";\n\n\$vod_config[isvip]=\"{$isvip}\";\n\$vod_config[vipmethod]=\"{$vipmethod}\";\n\$vod_config[onevodprice]=\"{$onevodprice}\";\n\$vod_config[pagenum]=\"{$pagenum}\";\n\$vod_config[pagenumlist]=\"{$pagenumlist}\";\n\n\$vod_config[isregister]=\"{$isregister}\";\n\$vod_config[initpoint]=\"{$initpoint}\";\n\n\$vod_config[adminusername]=\"{$adminusername}\";\n\$vod_config[adminpassword]=\"{$adminpassword}\";\n";
				string_towrite_file( $string, $goalfile );
				print_error( "������ü������" );
				pageindexto( "init" );
}
?>
