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
//empty( $_GET['sessionkey'] ) ? exit( ) : "";
//$GLOBAL_SESSION = returnsession( $_GET['sessionkey'] );
$attachmentid = $_GET[attachmentid];
$attachmentname = $_GET[attachmentname];

if ( $_GET['action'] == "download" )
{
				$pathname = "../attachment/".$attachmentid."/".urldecode( $attachmentname )."";
			
				is_file( $pathname ) ? "" : ( $pathname = "attachment/".$attachmentid."/".urldecode( $attachmentname )."" );
				if ( is_file( $pathname ) )
				{
								$filesize = filesize( $pathname );
								$file = fopen( $pathname, "r" );
								header( "Pragma: no-cache" );
								header( "Cache-control: private" );
								header( "Content-type: application/octet-stream" );
								header( "Content-Length: {$filesize}" );
								header( "Content-Disposition: attachment; filename=\"".urldecode( $attachmentname )."\"" );
								header( "Content-Description: ".$_SERVER['SERVER_NAME'] );
								echo fread( $file, $filesize );
								fclose( $file );
								exit( );
				}
				else
				{
								exit( );
				}
}
if ( $_GET['action'] == "picturefile" )
{
				$pathname =ROOT_DIR."general/ERP/Framework/attachment/".$attachmentid."/".urldecode( $attachmentname )."";

				is_file( $pathname ) ? "" : ( $pathname = "attachment/".$attachmentid."/".urldecode( $attachmentname )."" );
				
				if ( is_file( $pathname ) )
				{
					
				$filesize = filesize( $pathname );
				$file = fopen( $pathname, "r" );
				header( "Pragma: no-cache" );
				header( "Cache-control: private" );
				header( "Content-type: image/gif" );
				header( "Content-Length: {$filesize}" );
				header( "Content-Disposition: attachment; filename=\"".urldecode( $attachmentname )."\"" );
				header( "Content-Description: ".$_SERVER['SERVER_NAME'] );
				echo fread( $file, $filesize );
				fclose( $file );
				exit( );
				}
				
}
if ( $_GET['action'] == "binaryfile" )
{
				require_once( "include.inc.php" );
				$sql = "select * from student where xuehao='20021052157'";
				$rs = $db->execute( $sql );
				$file = $rs->fields['photo'];
				header( "Content-type: image/gif" );
				echo stripslashes( $file );
}
?>
