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
