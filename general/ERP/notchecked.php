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

require_once( "config.inc.php" );
$LOGIN_THEME = $_SESSION['SUNSHINE_USER_LOGIN_THEME'];
$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";
echo "<html>\r\n<head>\r\n<title>ϵͳ��¼(System Login)</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<LINK href=\"./theme/";
echo $LOGIN_THEME;
echo "/style.css\" rel=stylesheet>\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"5\">\r\n\r\n\r\n<div align=\"center\" title=\"��ʾ��Ϣ��\">\r\n";
echo "<s";
echo "pan style=\"BACKGROUND:#EEEEEE;COLOR:#FF6633;margin: 10px;border:1px dotted #FF6633;font-weight:bold;padding:8px;width=300px\">\r\n<font color=\"#FF0000\"><img src=\"Framework/images/attention.gif\" height=\"20\"> <b>��ʾ</b></font><hr>\r\n�û������������(ע���Сд)!</span>\r\n</div>\r\n<br>\r\n<div align=\"center\">\r\n  <input type=\"button\" value=\"���µ�¼\" class=\"SmallButton\" onclick=\"window.open('./');window.opener=null;win";
echo "dow.close();\">\r\n</div>\r\n";
?>
