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
