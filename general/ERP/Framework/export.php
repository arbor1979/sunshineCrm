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

require_once( "adodb/adodb.inc.php" );
require_once( "config.inc.php" );
$method = $_GET[method];
$GLOBALS['_GET']['exportsql'] = ereg_replace( ":", "'", $_GET['exportsql'] );
if ( isset( $_GET['exportsql'] ) )
{
				global $db;
				$sql = explode( " ", $_GET['exportsql'] );
				if ( $sql[0] != "select" || $sql[2] != "from" )
				{
								exit( );
				}
				$fields = explode( ",", trim( $sql[1] ) );
				$string = join( ",", array_unique( $fields ) );
				$rs = $db->cacheexecute( 150, $_GET['exportsql'] );
				$array = $rs->getarray( );
				$targetarray = array( );
				array_push( $targetarray, $string );
				foreach ( $array as $list )
				{
								array_push( $targetarray, join( ",", $list ) );
				}
				$content = join( "\n", $targetarray );
				header( "Pragma: no-cache" );
				header( "Cache-control: private" );
				header( "Content-Disposition: attachment; filename=".$_GET['tablename']."_".gmdate( "Y_m_d_H_i" ).".csv" );
				header( "Content-Type: text/csv; charset=UTF-8" );
				header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
				header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )." GMT" );
				header( "Cache-Control: post-check=0, pre-check=0", false );
				header( "Content-Length: ".strlen( $content ) );
				print $content;
				exit( );
}
?>
