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
empty( $_GET['sessionkey'] ) ? exit( ) : "";
$GLOBAL_SESSION = returnsession( $_GET['sessionkey'] );
$ExecTimeBegin = getmicrotime( );
$lang = returnsystemlang( );
$CAL_ID = $_GET['CAL_ID'];
$sql = "select * from calendar where CAL_ID='{$CAL_ID}'";
$rs = $db->execute( $sql );
$CAL_TIME = $rs->fields['CAL_TIME'];
$content = $rs->fields['CONTENT'];
$subject = 20 < strlen( $subject ) ? substr( $subject, 0, 20 ) : $subject;
$itemCategory_array = array( "Anniversary", "Birthday", "Business", "Get-together", "Gifts", "Holiday", "Meeting", "Personal", "Shopping" );
$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\r\n<HTML><HEAD><TITLE></TITLE>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n<LINK href=\"../theme/";
echo $LOGIN_THEME;
echo "/style.css\" rel=stylesheet>\r\n<html>\r\n<head>\r\n<title>�ճ̰��ţ�";
echo $subject;
echo " </title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n</head>\r\n\r\n<body bgcolor=\"#FFFFCC\" topmargin=\"5\">\r\n\r\n<div class=\"small\">\r\n";
echo $CAL_TIME;
echo "<BR>\r\n<HR>\r\n����:";
echo nl2br( $content );
echo "<BR>\r\n\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
