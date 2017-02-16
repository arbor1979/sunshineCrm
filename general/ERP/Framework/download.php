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
