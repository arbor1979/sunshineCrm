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
$sql = "select * from sessions where data IS NOT NULL";
$rs = $db->execute( $sql );
$user_online_num = 0;
while ( !$rs->EOF )
{
				$DATA = urldecode( $rs->fields['DATA'] );
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
array_multisort( $rs_online['SUNSHINE_USER_DEPT'], SORT_NUMERIC, SORT_ASC );
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
}
echo "<S";
echo "CRIPT language=JavaScript>\r\n\tparent.parent.status_bar.user_count1.value=\"";
echo $user_online_num;
echo "\";\r\n</SCRIPT>";
?>
