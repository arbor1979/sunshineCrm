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
$sessionkey = returnsesskey( );
$GLOBA_SESSION = returnsession( );
global $SUNSHINE_USER_ID_VAR;
global $_SESSION;
global $SUNSHINE_USER_PRIV_VAR;
$USER_PRIV = $_SESSION[$SUNSHINE_USER_PRIV_VAR];
$USER_ID = $_SESSION[$SUNSHINE_USER_ID_VAR];
$USER_PRIV = $USER_PRIV != "" ? $USER_PRIV : returntablefield( "user", "USER_ID", $USER_ID, "USER_PRIV" );
$GLOBALS['_SESSION'][$SUNSHINE_USER_PRIV_VAR] = $USER_PRIV;
require_once( "mytable_function.php" );
$ExecTimeBegin = getmicrotime( );
$lang = returnsystemlang( );
$common_html = returnsystemlang( "common_html" );
page_css( "mytable", "Sunshine20 office anywhere" );
echo "\r\n\r\n";
echo "<S";
echo "CRIPT language=javascript>\r\n\r\n\tvar _d = new Date();\r\n\tfunction showFilter(o)\r\n\t{\r\n\t\tif(o.parentNode.nextSibling.firstChild.style.display == \"none\")\r\n\t\t{\r\n\t\t\twith (o.parentNode)\r\n\t\t\t{\r\n\t\t\t\tchildNodes[0].firstChild.src = \"images/box_on_left.gif\";\r\n\t\t\t\tchildNodes[1].runtimeStyle.backgroundColor = \"#889DC2\";\r\n\t\t\t\tnextSibling.firstChild.style.display = \"\";\r\n\t\t\t\tnextSibling.firstChild.style.visiblity = ";
echo "\"\";\r\n\t\t\t}\r\n\t\t\to.firstChild.src = \"images/box_on_right_up.gif\";\r\n\t\t}\r\n\t\telse\r\n\t\t{\r\n\t\t\twith (o.parentNode)\r\n\t\t\t{\r\n\t\t\t\tchildNodes[0].firstChild.src = \"images/box_on_left_down.gif\";\r\n\t\t\t\tchildNodes[1].runtimeStyle.backgroundColor = \"#a5a5a5\";\t\t\t\r\n\t\t\t\t\r\n\t\t\t\tnextSibling.firstChild.style.display = \"none\";\r\n\t\t\t\tnextSibling.firstChild.style.visiblity = \"none\";\r\n\t\t\t}\r\n\t\t\to.firstChild.src = \"images/box_on_ri";
echo "ght_down.gif\";\r\n\t\t}\r\n\t}\t\r\n    \r\n</SCRIPT>\r\n\r\n\r\n";
$file_ini = parse_ini_file( "Model/mytable_newai.ini", true );
$array_index = array_keys( $file_ini );
print "<TABLE cellSpacing=1 cellPadding=3 width=760 \tborder=0>\n<TBODY>\n<TR>\n<TD noWrap valign=top>\n";
newai_dataline( "notify" );
newai_dataline( "news" );
return_summarize( "summarize_email", "summarize_template_mytable" );
print "</TD>\n";
print "<TD noWrap valign=top width=10>\n";
print "&nbsp;";
print "</TD>\n";
print "<TD noWrap valign=top>\n";
newai_dataline( "calendar" );
newai_dataline( "url", "url_dataline_view" );
print "</TD>\n";
print "</TR>\n</table>\n";
$systemlang = $_SESSION['SUNSHINE_USER_LANG'];
if ( $systemlang == "" || $systemlang == "zh" )
{
				$noregister = "�����δע�ᣬ��������ע��";
}
else
{
				$noregister = "Not register,click to register";
}
if ( file_exists( "license.ini" ) )
{
				$ini_file = parse_ini_file( "license.ini" );
				$result = machinecode_sunshine_512_20( $ini_file[MACHINE_CODE] );
				if ( $result != $ini_file[REGISTER_CODE] )
				{
								print "<div align=\"center\">\r\n\t\t<input type=\"button\" value=\"{$noregister}\" class=\"SmallButton\" onclick=\"location='register.php'\">\r\n\t\t</div>";
				}
				else if ( $result == $ini_file[REGISTER_CODE] && date( "d" ) == 12 )
				{
								$code = returnmachinecode( );
								if ( $code != $ini_file[MACHINE_CODE] )
								{
												@unlink( "license.ini" );
								}
				}
}
else
{
				print "<div align=\"center\">\r\n\t\t<input type=\"button\" value=\"{$noregister}\" class=\"SmallButton\" onclick=\"location='register.php'\">\r\n\t\t</div>";
}
?>
