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

function getsmsnum( )
{
				global $_SESSION;
				global $SUNSHINE_USER_NAME_VAR;
				global $SUNSHINE_USER_ID_VAR;
				global $SUNSHINE_USER_SMS_ON_VAR;
				global $db;
				global $_GET;
				global $POST;
				$USER_ID = $_SESSION[$SUNSHINE_USER_NAME_VAR];
				$SMS = $_SESSION[$SUNSHINE_USER_SMS_VAR];
				$sql = "select Count(*) as num from sms where REMIND_FLAG=1 and TO_ID='{$USER_ID}' and delete_receive!=1";
				$rs = $db->execute( $sql );
				return $rs->fields['num'];
}

require_once( "lib.inc.php" );
$GLOBAL_SESSION = returnsession( );
$newsmsnum = getsmsnum( );
if ( 1 <= $newsmsnum )
{
				print "S";
}
?>
