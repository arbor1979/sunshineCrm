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

global $HTTP_SESSION_VARS;
include( "./adodb/adodb.inc.php" );
include( "./adodb/adodb-session.php" );
adodb_sess_open( false, false, false );
session_start( );
$key = returnsesskey( );
$sndg_community = $HTTP_SESSION_VARS[sndg_community];
$sess_val = adodb_sess_read( $key );
if ( !session_is_registered( "sndg_community" ) )
{
}
$elementid = $HTTP_GET_VARS[elementid];
$elementname = $HTTP_GET_VARS[elementname];
if ( $elementid == "" || empty( $elementid ) )
{
				$elementid = "TO_ID2df";
}
if ( $elementname == "" || empty( $elementname ) )
{
				$elementname = "TO_NAME2df";
}
require_once( "lib.inc.php" );
require_once( "./sms_index/single_select.php" );
page_css( "Department list" );
frame_user_js_( $elementid, $elementname );
frame_user_header_( );
frame_user_data_department( 2 );
echo "<br>\r\n<hr>\r\n<DIV align=center><INPUT class=BigButton onclick=parent.close(); type=button value=关闭> \r\n</DIV>\r\n";
?>
