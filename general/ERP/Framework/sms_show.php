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

function send_sms( )
{
				global $html_etc;
				global $common_html;
				global $sessionkey;
				global $GLOBAL_SESSION;
				global $SUNSHINE_USER_NAME_VAR;
				global $SUNSHINE_USER_ID_VAR;
				global $db;
				global $_GET;
				global $POST;
				$TO_ID = $GLOBAL_SESSION[$SUNSHINE_USER_NAME_VAR];
				require_once( "../Enginee/lib/html/sendsms.html" );
}

function read_sms( )
{
				global $html_etc;
				global $common_html;
				global $sessionkey;
				global $GLOBAL_SESSION;
				global $SUNSHINE_USER_NAME_VAR;
				global $SUNSHINE_USER_NICK_NAME_VAR;
				global $db;
				global $_GET;
				global $POST;
				global $GLOBAL_SESSION;
				$USER_ID = $GLOBAL_SESSION[$SUNSHINE_USER_NAME_VAR];
				$USER_NAME = $GLOBAL_SESSION[$SUNSHINE_USER_NICK_NAME_VAR];
				$sql = "select * from sms where REMIND_FLAG=1 and TO_ID='{$USER_ID}' and delete_receive!=1  order by SEND_TIME DESC";
				$rs = $db->execute( $sql );
				if ( $rs->recordcount( ) <= 0 )
				{
								echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=javascript:window.close()'>\n";
				}
				$SMS_ID = $rs->fields['SMS_ID'];
				$FROM_ID = $rs->fields['FROM_ID'];
				$SEND_TIME = $rs->fields['SEND_TIME'];
				$CONTENT = $rs->fields['CONTENT'];
				$FROM_NAME = returntablefield( "user", "USER_NAME", $FROM_ID, "NICK_NAME" );
				$FROM_ID = $rs->fields['FROM_ID'];
				require_once( "../Enginee/lib/html/readsms.html" );
}

function sendsms_data( )
{
				global $html_etc;
				global $common_html;
				global $GLOBAL_SESSION;
				global $SUNSHINE_USER_NAME_VAR;
				global $SUNSHINE_USER_ID_VAR;
				global $db;
				global $_GET;
				global $POST;
				$USER_ID = $GLOBAL_SESSION[$SUNSHINE_USER_NAME_VAR];
				$datetime = date( "Y-m-d H:i:s" );
				$sql = "insert into sms(from_id,to_id,sms_type,content,send_time,remind_flag,delete_sender,delete_receive) values('{$USER_ID}','{$_POST['TO_ID']}',0,'{$_POST['CONTENT']}','{$datetime}',1,0,0)";
				$rs = $db->execute( $sql );
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=javascript:window.close()'>\n";
}

function delete_sms( )
{
				global $html_etc;
				global $common_html;
				global $GLOBAL_SESSION;
				global $SUNSHINE_USER_NAME_VAR;
				global $SUNSHINE_USER_ID_VAR;
				global $db;
				global $_GET;
				global $POST;
				$USER_ID = $GLOBAL_SESSION[$SUNSHINE_USER_NAME_VAR];
				$sql_update = "update sms set REMIND_FLAG=0 where TO_ID='{$USER_ID}' and SMS_ID='".$_GET[SMS_ID]."'";
				$rs = $db->execute( $sql_update );
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=javascript:window.close()'>\n";
}

require_once( "lib.inc.php" );
$filetablename = "sms";
empty( $_GET['sessionkey'] ) ? exit( ) : "";
$sessionkey = $_GET['sessionkey'];
$GLOBAL_SESSION = returnsession( $_GET['sessionkey'] );
$ExecTimeBegin = getmicrotime( );
$lang = returnsystemlang( );
$columns = returntablecolumn( $filetablename );
$html_etc = returnsystemlang( $filetablename );
$common_html = returnsystemlang( "common_html" );
$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";
print "<LINK href=\"../theme/{$LOGIN_THEME}/style.css\" rel=stylesheet>";
switch ( $_GET['action'] )
{
case "readsms" :
				read_sms( );
				break;
case "sendsms" :
				send_sms( );
				break;
case "reply" :
				send_sms( );
				print "<SCRIPT> parent.parent.opener.new_sms.innerHTML = \"\";</SCRIPT>\n";
				break;
case "sendsms_data" :
				sendsms_data( );
				break;
case "delete" :
				delete_sms( );
				print "<SCRIPT> parent.parent.opener.new_sms.innerHTML = \"\";</SCRIPT>\n";
}
?>
