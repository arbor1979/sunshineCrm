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
require_once( "../Enginee/newai.php" );
$GLOBAL_SESSION = returnsession( );
global $SUNSHINE_USER_NAME_VAR;
$lang = returnsystemlang( );
$systemlang = $_SESSION[$SUNSHINE_USER_LANG_VAR];
$common_html = returnsystemlang( "common_html" );
echo "<html>\r\n<head>\r\n<title>";
echo $_SESSION['sunshine20'];
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"./images/style.css\">\r\n";
echo "<s";
echo "cript Language=JavaScript>\r\nwindow.setTimeout('this.location.reload();',60000000);\r\n\r\nvar OA_TIME = new Date();\r\n\r\nfunction timeview()\r\n{\r\n  timestr=OA_TIME.toLocaleString();\r\n  timestr=timestr.substr(timestr.indexOf(\" \"));\r\n  time_area.innerHTML = timestr;\r\n  OA_TIME.setSeconds(OA_TIME.getSeconds()+1);\r\n  window.setTimeout( \"timeview()\", 1000 );\r\n}\r\n</script>\r\n</head>\r\n\r\n<body bgcolor=\"#C8D8F1\" topm";
echo "argin=\"0\" leftmargin=\"2\" onload=\"timeview();\">\r\n\r\n<img src=\"./images/dot3.gif\">\r\n";
echo "<s";
echo "pan class=\"small\">";
echo $common_html['common_html']['username'];
echo ":<b>\r\n";
echo $_SESSION[$SUNSHINE_USER_NICK_NAME_VAR];
echo "</b>&nbsp;&nbsp;&nbsp;&nbsp;";
echo $common_html['common_html']['time'];
echo ":<b>";
echo "<s";
echo "pan id=\"time_area\"></span>&nbsp;&nbsp;";
echo date( "m-d-Y" );
echo "</b>&nbsp;&nbsp;&nbsp;&nbsp;\r\n\r\n";
echo $common_html['common_html']['Identifier'];
echo ":<b>";
echo $_SESSION[$SUNSHINE_USER_DEPT_NAME_VAR];
echo " ";
echo $_SESSION[$SUNSHINE_USER_PRIV_NAME_VAR];
echo "</b></span>\r\n</body>\r\n</html>";
?>
