<?php
/*
版权归属:郑州单点科技软件有限公司;
联系方式:0371-69663266;
公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
*/

$from = "王纪云";
$to = "王纪云";
$subject = "职场宝典：CIO忽悠老板的四大“法宝”";
$letter = "==========tongda==========";
$attachment = "职场宝典：CIO忽悠老板的四大“法宝”.txt";
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
