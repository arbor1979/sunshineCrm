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
				$noregister = "软件尚未注册，请点击这里注册";
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
