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
require_once( "./sms_index/single_select.php" );
$common_html = returnsystemlang( "common_html" );
$GLOBALS['_GET']['TO_ID'] = isset( $_GET['TO_ID'] ) ? $_GET['TO_ID'] : "TO_ID";
$GLOBALS['_GET']['TO_NAME'] = isset( $_GET['TO_NAME'] ) ? $_GET['TO_NAME'] : "TO_NAME";
$GLOBALS['_GET']['action_page'] = isset( $_GET['action_page'] ) ? $_GET['action_page'] : "action_page";
$MODE = $_GET['MODE'];
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Frameset//EN\">\r\n<!-- saved from url=(0036)http://localhost/module/user_select/ -->\r\n<HTML>\r\n<HEAD>\r\n<TITLE>\r\n";
echo $common_html['common_html']['adduser'];
echo "</TITLE>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n<LINK href=\"./images/style.css\" type=text/css rel=stylesheet>\r\n<META content=\"MSHTML 6.00.2800.1106\" name=GENERATOR>\r\n</HEAD>\r\n<FRAMESET id=bottom border=1 frameSpacing=0 rows=225,* frameBorder=YES cols=*>\r\n<FRAMESET id=bottom border=1 frameSpacing=0 rows=* frameBorder=YES cols=150,*>\r\n<FRAME name=dept \r\nsrc=\"./frame_user_dept.p";
echo "hp?action_page=";
echo $_GET['action_page'];
echo "&TO_ID=";
echo $_GET['TO_ID'];
echo "&TO_NAME=";
echo $_GET['TO_NAME'];
echo "&MODE=";
echo $MODE;
echo "\">\r\n<FRAME name=user \r\nsrc=\"./frame_user_user.php?action_page=";
echo $_GET['action_page'];
echo "&TO_ID=";
echo $_GET['TO_ID'];
echo "&TO_NAME=";
echo $_GET['TO_NAME'];
echo "&MODE=";
echo $MODE;
echo "\">\r\n</FRAMESET>\r\n<FRAME name=bottom \r\nsrc=\"otherinfor.php?action=bottom\" frameBorder=NO scrolling=no></FRAMESET></HTML>\r\n";
?>
