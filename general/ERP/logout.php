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
