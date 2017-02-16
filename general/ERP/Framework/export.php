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
