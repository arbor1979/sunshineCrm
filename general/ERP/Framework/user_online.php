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

function online_userelement( $userid, $username, $userprivname, $usergif = "9.gif" )
{
				global $common_html;
				global $user_online_num;
				if ( isset( $userid, $username ) )
				{
								++$user_online_num;
								print "<TBODY>\n";
								print "<TR class=TableData align=middle>\n";
								print "<TD noWrap align=middle width=15><IMG src=\"./images/avatar/{$usergif}\"> </TD>\n";
								print "<TD width=60 noWrap >{$username}</TD>\n";
								print "<TD noWrap><A href=\"javascript:send_sms('{$userid}','{$username}')\">".$common_html['common_html']['sms']."</A>\n";
								print "<A href=\"javascript:send_email('{$userid}','{$username}')\">".$common_html['common_html']['email']."</A> </TD>\n";
								print "</TR>\n";
				}
}

require_once( "lib.inc.php" );
require_once( "../Enginee/newai.php" );
$sessionkey = returnsesskey( );
$GLOBAL_SESSION = returnsession( );
$systemlang = $_SESSION[$SUNSHINE_USER_LANG_VAR];
$ExecTimeBegin = getmicrotime( );
$lang = returnsystemlang( );
$common_html = returnsystemlang( "common_html" );
$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\r\n<HTML><HEAD>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n<LINK href=\"../theme/";
echo $LOGIN_THEME;
echo "/style.css\" rel=stylesheet>\r\n";
echo "<S";
echo "CRIPT language=JavaScript>\r\n\r\n// ------ 定时刷新页面 -------\r\nwindow.setTimeout('this.location.reload();',400000);  <!-- 定时刷新  -->\r\n\r\nfunction killErrors()\r\n{\r\n  return true;\r\n}\r\nwindow.onerror = killErrors;\r\n</SCRIPT>\r\n\r\n<META content=\"MSHTML 6.00.2800.1106\" name=GENERATOR></HEAD>\r\n<BODY class=user_panel leftMargin=0 topMargin=0>\r\n\r\n";
$sql = "select * from sessions2 where sessdata IS NOT NULL";
$rs = $db->execute( $sql );
$rs_a = $rs->getarray( );
$user_online_num = 0;
$m = 0;
for ( ;	$m < sizeof( $rs_a );	++$m	)
{
				$key = $rs_a[$m]['sesskey'];
				$DATA = adodb_session::read( $key );
				$sess_array = explode( ";", $DATA );
				$i = 0;
				for ( ;	$i < sizeof( $sess_array );	++$i	)
				{
								$sess_array_in = explode( "|", $sess_array[$i] );
								$name = $sess_array_in[0];
								$value_array = explode( ":", $sess_array_in[1] );
								$value = $value_array[sizeof( $value_array ) - 1];
								$GLOBAL_SESSION_LIST_INDEX[$name] = ereg_replace( "\"", "", $value );
				}
				$TEMP_USER_ID = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_ID_VAR];
				$TEMP_USER_DEPT = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_DEPT_VAR];
				$rs_online['SUNSHINE_USER_DEPT'][$TEMP_USER_DEPT] = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_DEPT_VAR];
				$rs_online['SUNSHINE_DEPT_LIST'][$TEMP_USER_DEPT][$TEMP_USER_ID] = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_ID_VAR];
				$rs_online['SUNSHINE_USER_DEPT_NAME'][$TEMP_USER_DEPT] = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_DEPT_NAME_VAR];
				$rs_online[$TEMP_USER_ID]['SUNSHINE_USER_ID'] = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_ID_VAR];
				$rs_online[$TEMP_USER_ID]['SUNSHINE_USER_NAME'] = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_NAME_VAR];
				$rs_online[$TEMP_USER_ID]['SUNSHINE_USER_NICK_NAME'] = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_NICK_NAME_VAR];
				$rs_online[$TEMP_USER_ID]['SUNSHINE_USER_DEPT'] = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_DEPT_VAR];
				$rs_online[$TEMP_USER_ID]['SUNSHINE_USER_PRIV'] = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_PRIVv];
				$rs_online[$TEMP_USER_ID]['SUNSHINE_USER_DEPT_NAME'] = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_DEPT_NAME_VAR];
				$rs_online[$TEMP_USER_ID]['SUNSHINE_USER_PRIV_NAME'] = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_PRIV_NAME_VAR];
				$rs_online[$TEMP_USER_ID]['SUNSHINE_USER_AVATAR'] = $GLOBAL_SESSION_LIST_INDEX[$SUNSHINE_USER_AVATAR_VAR];
				$rs->movenext( );
}
@array_multisort( $rs_online['SUNSHINE_USER_DEPT'], SORT_NUMERIC, SORT_ASC );
$rs_online['SUNSHINE_USER_DEPT'] = ( array )$rs_online['SUNSHINE_USER_DEPT'];
foreach ( $rs_online['SUNSHINE_USER_DEPT'] as $DEPT_LIST )
{
				$DEPT_NAME = $rs_online['SUNSHINE_USER_DEPT_NAME'][$DEPT_LIST];
				$len = 20;
				if ( $systemlang == "en" )
				{
								$DEPT_NAME = 22 < strlen( $DEPT_NAME ) ? substr( $DEPT_NAME, 0, 22 )."..." : $DEPT_NAME;
				}
				else
				{
								$DEPT_NAME = $len < strlen( $DEPT_NAME ) ? substr_cut( $DEPT_NAME, 0, $len )."..." : $DEPT_NAME;
				}
				print "<TABLE class=small cellSpacing=1 cellPadding=3 width=\"105%\" align=center bgColor=#000000 border=0>\n";
				print "<TBODY>\n";
				print "<TR class=TableHeader style=\"CURSOR: hand\" onclick=\"clickMenu('{$DEPT_LIST}')\">\n";
				print "<TD noWrap align=middle colSpan=5><B>{$DEPT_NAME}</B></TD></TR></TBODY></TABLE>\n";
				print "<TABLE class=small id={$DEPT_LIST} cellSpacing=1 cellPadding=3 width=\"105%\"  align=center bgColor=#000000 border=0>\n";
				print "<TBODY>\n";
				foreach ( $rs_online['SUNSHINE_DEPT_LIST'][$DEPT_LIST] as $DEPT_USER )
				{
								$SUNSHINE_USER_NAME_INDEX = $rs_online[$DEPT_USER]['SUNSHINE_USER_NAME'];
								$SUNSHINE_USER_NICK_NAME_INDEX = trim( $rs_online[$DEPT_USER]['SUNSHINE_USER_NICK_NAME'] );
								$SUNSHINE_USER_PRIV_INDEX = $rs_online[$DEPT_USER]['SUNSHINE_USER_PRIV'];
								$SUNSHINE_USER_ID_INDEX = $rs_online[$DEPT_USER]['SUNSHINE_USER_ID'];
								$SUNSHINE_USER_DEPT_INDEX = $rs_online[$DEPT_USER]['SUNSHINE_USER_DEPT'];
								$SUNSHINE_USER_AVATAR_INDEX = trim( $rs_online[$DEPT_USER]['SUNSHINE_USER_AVATAR'] );
								$SUNSHINE_USER_AVATAR_INDEX == "" ? ( $usergif = "19.gif" ) : ( $usergif = trim( $SUNSHINE_USER_AVATAR_INDEX ).".gif" );
								$SUNSHINE_USER_NAME_INDEX = 8 < strlen( $SUNSHINE_USER_NAME_INDEX ) ? substr_cut( $SUNSHINE_USER_NAME_INDEX, 10 ) : $SUNSHINE_USER_NAME_INDEX;
								if ( $SUNSHINE_USER_NICK_NAME_INDEX != "" )
								{
												$temp_value = $SUNSHINE_USER_NICK_NAME_INDEX;
								}
								else
								{
												$temp_value = $SUNSHINE_USER_NAME_INDEX;
								}
								online_userelement( $SUNSHINE_USER_NAME_INDEX, $temp_value, $SUNSHINE_USER_PRIV_INDEX, $usergif );
				}
				print "</TBODY></TABLE>\n";
}
echo "\r\n";
echo "<S";
echo "CRIPT language=JavaScript>\r\nfunction clickMenu(ID)\r\n{\r\n    targetelement=document.all(ID);\r\n    if (targetelement.style.display==\"\")\r\n        targetelement.style.display='none';\r\n    else\r\n        targetelement.style.display=\"\";\r\n}\r\n\r\nfunction send_sms(TO_ID,TO_NAME)\r\n{\r\n   mytop=screen.availHeight-246;\r\n   myleft=0;\r\n   window.open(\"./sms_show.php?action=sendsms&sessionkey=";
echo $sessionkey;
echo "&TO_ID=\"+TO_ID+\"&TO_NAME=\"+TO_NAME,\"send_sms\",\"height=190,width=350,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top=\"+mytop+\",left=\"+myleft+\",resizable=yes\");\r\n}\r\n\r\nfunction send_email(TO_ID,TO_NAME)\r\n{\r\n   //parent.parent.table_index.table_main.location=\"./email_newai.php?action=add_outbox&toid=\"+TO_ID+\"&toidname=\"+TO_NAME;\r\n   //Interface/OA2/email/new/\r\n   parent.parent.table_inde";
echo "x.table_main.location=\"../Interface/OA2/email/new/index.php?action=add_outbox&TO_ID=\"+TO_ID+\"&TO_NAME=\"+TO_NAME;\r\n}\r\n\r\nparent.parent.status_bar.user_count1.value=\"";
echo $user_online_num;
echo "\";\r\n</SCRIPT>\r\n</BODY></HTML>\r\n";
?>
