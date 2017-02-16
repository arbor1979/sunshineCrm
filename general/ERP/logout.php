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

require_once( "include.inc.php" );
$common_html = returnsystemlang( "common_html" );


session_start(); 
session_unset();
session_destroy();
$_SESSION=array();


header("Location: ./");   
exit;
echo "<html>\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"theme/";
echo $SYSTEM_THEME;
echo "/style.css\">\r\n</head>\r\n\r\n<body class=\"logout\" topmargin=\"5\">\r\n\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" class=\"small\">\r\n  <tr>\r\n    <td class=\"Small\"><b><font color=\"#000000\"> ";
echo $common_html['common_html']['exit'];
echo "</font></b><br>\r\n    </td>\r\n  </tr>\r\n</table>\r\n\r\n<hr width=\"95%\" height=\"1\" align=\"left\" color=\"#000000\">\r\n\r\n<br>\r\n<div align=\"center\">\r\n<b>\r\n<font color=\"#000000\">\r\n";
echo $common_html['common_html']['closebrowserinfor'];
echo "</font></b>\r\n</div>\r\n\r\n<br>\r\n<div align=\"center\">\r\n  <input type=\"button\" value=\"";
echo $common_html['common_html']['relogin'];
echo "\" class=\"SmallButton\" onclick=\"window.open('./');window.opener=null;window.close();\">&nbsp;&nbsp;&nbsp;&nbsp;\r\n  <input type=\"button\" value=\"";
echo $common_html['common_html']['closebrowser'];
echo "\" class=\"SmallButton\" onclick=\"window.opener=null;window.close()\">\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
