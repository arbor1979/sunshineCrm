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

if ( $_GET[rows] == "" )
{
				$rows = 200;
}
else
{
				$rows = $_GET[rows];
}
$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\r\n<HTML><HEAD><TITLE>控制左菜单显隐</TITLE>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n<LINK href=\"../theme/";
echo $LOGIN_THEME;
echo "/style.css\" rel=stylesheet>\r\n";
echo "<S";
echo "CRIPT language=JavaScript>\r\n\r\nvar LEFT_MENU_VIEW=0;\r\n\r\nfunction leftmenu_open()\r\n{\r\n   LEFT_MENU_VIEW=0;\r\n   leftmenu_ctrl();\r\n}\r\n\r\nfunction leftmenu_ctrl()\r\n{\r\n   if(LEFT_MENU_VIEW==0)\r\n   {\r\n      parent.frame2.cols=\"";
echo $rows;
echo ",8,*\";\r\n      LEFT_MENU_VIEW=1;\r\n      myarrow.src=\"./images/arrow_l.gif\";\r\n   }\r\n   else\r\n   {\r\n      parent.frame2.cols=\"0,8,*\";\r\n      LEFT_MENU_VIEW=0;\r\n      myarrow.src=\"./images/arrow_r.gif\";\r\n   }\r\n}\r\n\r\nfunction setPointer(theRow, thePointerColor)\r\n{\r\n    if (typeof(theRow.style) == 'undefined' || typeof(theRow.cells) == 'undefined')\r\n    {\r\n        return false;\r\n    }\r\n\r\n    var row_cell";
echo "s_cnt=theRow.cells.length;\r\n    for (var c = 0; c < row_cells_cnt; c++)\r\n    {\r\n        theRow.cells[c].bgColor = thePointerColor;\r\n    }\r\n\r\n    return true;\r\n}\r\n\r\n</SCRIPT>\r\n\r\n<META content=\"MSHTML 6.00.2800.1106\" name=GENERATOR></HEAD>\r\n<BODY leftMargin=0 topMargin=0 onload=leftmenu_ctrl()>\r\n\r\n<TABLE height=\"100%\" cellSpacing=0 cellPadding=0 width=\"100%\" align=center \r\nbackground=\"../theme/";
echo $LOGIN_THEME;
echo "/images/index0_02.gif\">\r\n  <TBODY>\r\n  <TR>\r\n    <TD>\r\n      <TABLE height=50 cellSpacing=0 borderColorDark=#ffffff cellPadding=0 \r\n      width=\"100%\" bgColor=#eeeeee borderColorLight=#000000 border=1>\r\n        <TBODY>\r\n        <TR onmouseover=\"setPointer(this, '#D3E5FF')\" onclick=leftmenu_ctrl() \r\n        onmouseout=\"setPointer(this, '#EEEEEE')\">\r\n          <TD style=\"CURSOR: hand\"><IMG id=myarrow \r\n     ";
echo "       src=\"./images/arrow_l.gif\"> \r\n  </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>\r\n\r\n\r\n  </BODY></HTML>\r\n";
?>
