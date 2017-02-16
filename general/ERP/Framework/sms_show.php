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
