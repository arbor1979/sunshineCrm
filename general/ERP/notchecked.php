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

require_once( "config.inc.php" );
$LOGIN_THEME = $_SESSION['SUNSHINE_USER_LOGIN_THEME'];
$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";
echo "<html>\r\n<head>\r\n<title>系统登录(System Login)</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<LINK href=\"./theme/";
echo $LOGIN_THEME;
echo "/style.css\" rel=stylesheet>\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"5\">\r\n\r\n\r\n<div align=\"center\" title=\"提示信息框\">\r\n";
echo "<s";
echo "pan style=\"BACKGROUND:#EEEEEE;COLOR:#FF6633;margin: 10px;border:1px dotted #FF6633;font-weight:bold;padding:8px;width=300px\">\r\n<font color=\"#FF0000\"><img src=\"Framework/images/attention.gif\" height=\"20\"> <b>提示</b></font><hr>\r\n用户名或密码错误(注意大小写)!</span>\r\n</div>\r\n<br>\r\n<div align=\"center\">\r\n  <input type=\"button\" value=\"重新登录\" class=\"SmallButton\" onclick=\"window.open('./');window.opener=null;win";
echo "dow.close();\">\r\n</div>\r\n";
?>
