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

require_once( "../include.inc.php" );
$GLOBAL_SESSION = returnsession( );
$SUNSHINE_USER_ID = $_SESSION[$SUNSHINE_USER_ID_VAR];
if ( $SUNSHINE_USER_ID )
{
				echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Frameset//EN\">\r\n<HTML><HEAD>\r\n<TITLE>\r\nSunshine Anywhere ����Эͬϵͳ 2.4 (CRM���ɰ�)\r\n</TITLE>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n";
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
