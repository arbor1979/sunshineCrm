<?php
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
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
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\r\n<HTML><HEAD><TITLE>������˵�����</TITLE>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n<LINK href=\"../theme/";
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
