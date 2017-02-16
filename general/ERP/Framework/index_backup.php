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

require_once( "../include.inc.php" );
$GLOBAL_SESSION = returnsession( );
$SUNSHINE_USER_ID = $_SESSION[$SUNSHINE_USER_ID_VAR];
if ( $SUNSHINE_USER_ID )
{
				echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Frameset//EN\">\r\n<HTML><HEAD>\r\n<TITLE>\r\nSunshine Anywhere 网络协同系统 2.4 (CRM集成版)\r\n</TITLE>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n";
				echo "<S";
				echo "CRIPT language=JavaScript>\r\nfunction killErrors()\r\n{\r\n  return true;\r\n}\r\nwindow.onerror = killErrors;\r\n\r\n self.moveTo(0,0);\r\n self.resizeTo(screen.availWidth,screen.availHeight);\r\n self.focus();\r\n</SCRIPT>\r\n\r\n<META content=\"MSHTML 6.00.2800.1106\" name=GENERATOR></HEAD>\r\n\r\n<FRAMESET id=frame1 border=0 frameSpacing=0 rows=70,*,20 frameBorder=NO cols=*>\r\n\t<FRAME name=banner src=\"index_top.php\" frameBorder";
				echo "=0 noResize scrolling=no>\r\n\r\n<FRAMESET id=frame2 border=0 frameSpacing=0 rows=* frameBorder=NO cols=200,8,*>\r\n\r\n\t<FRAME name=leftmenu src=\"menu/menu_index.php\" frameBorder=0 noResize>\r\n\r\n<FRAME name=callleftmenu src=\"callleftmenu.php\" frameBorder=0 noResize scrolling=no>\r\n\r\n<frameset rows=\"21,*\"  cols=\"*\" frameborder=\"NO\" border=\"0\" framespacing=\"0\">\r\n    <frame name=\"login_info\" scrolling=\"no\" noresiz";
				echo "e src=\"login_info.php\" frameborder=\"0\">\r\n    <frame name=\"main\" scrolling=\"auto\" noresize src=\"mytable.php\" frameborder=\"0\">\r\n</frameset>\r\n\r\n</FRAMESET>\r\n\r\n<frame name=\"status_bar\" scrolling=\"no\" noresize src=\"status_bar.php\" frameborder=\"0\">\r\n</FRAMESET>\r\n\r\n</HTML>\r\n";
}
else
{
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=../index.php'>\n";
}
?>
