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

$from = "������";
$to = "������";
$subject = "ְ�����䣺CIO�����ϰ���Ĵ󡰷�����";
$letter = "==========tongda==========";
$attachment = "ְ�����䣺CIO�����ϰ���Ĵ󡰷�����.txt";
$newfile = $subject.".eml";
$URL = "http://".$_SERVER['SERVER_NAME'];
header( "Pragma: no-cache" );
header( "Cache-control: private" );
header( "Content-type: application/octet-stream" );
header( "Content-Disposition: attachment; filename=\"{$newfile}" );
header( "Content-Description: {$URL}" );
echo "Date: ".date( r )."\n";
echo "From: \"{$from}\" <chr>\n";
echo "MIME-Version: 1.0\n";
echo "To: \"{$to}\" <chr>\n";
echo "Subject: {$subject}\n";
echo "Content-Type: multipart/mixed;\n";
echo " boundary=\"{$letter}\"\n\n";
echo "This is a multi-part message in MIME format.\n";
echo "--{$letter}\n";
echo "Content-Type: text/html;\n";
echo "charset=\"gb2312\"\n";
echo "Content-Transfer-Encoding: base64\n\n";
echo $Content;
echo "\n\n\n--{$letter}\n";
echo "Content-Type: application/octet-stream;\n";
echo "\tname=\"{$attachment}\"\n";
echo "Content-Transfer-Encoding: base64\n";
echo "Content-Disposition: attachment;\n";
echo "\tfilename=\"{$attachment}\"\n";
$filename = "dir.class.php";
if ( is_file( $filename ) )
{
				$handle = fopen( $filename, r );
				$contents = fread( $handle, filesize( $filename ) );
				fclose( $handle );
				echo "\n\n\n";
				echo base64_encode( $contents )."\n";
}
exit( );
?>
