<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

require_once('include.inc.php');
//$表前缀 = "TD_OA.";
//print_R($db);
function logincheck($username,$password)							{
	global $db,$prefix;
	$SQL		= "SELECT * FROM ".$prefix."user WHERE USER_ID = '$username'";
	$rs			= $db->Execute($SQL);
	$rs_a		= $rs->GetArray();
	$USER_ID	= $rs_a[0]['USER_ID'];
	$PASSWORDTEXT = $rs_a[0]['PASSWORD'];
	//print crypt('', $PASSWORDTEXT) == $PASSWORDTEXT;exit;
	//print_R($password);print_R($PASSWORDTEXT);exit;
	if($USER_ID!="")												{
		if(crypt($password,$PASSWORDTEXT) == $PASSWORDTEXT)			{
			//密码正确
			return $rs_a;
			exit;
		}
		else	{
			//密码错误
			//print_R($password);print_R($username);exit;
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=notchecked.php'>\n";
			exit;
		}
	}
	else	{
		//用户名不存在
		//print_R($password);print_R($_POST);exit;
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=notchecked.php'>\n";
		exit;
	}
	exit;
}
//$array=explode('||',$_GET['checkstring']);//print_R($array);
//$username=$array[0];
//$password=$array[1];
//print $username.$password;exit;

//较验特殊字母 =
$checkUserName = explode('=',$_REQUEST['username']);
$checkUserPassword = explode('=',$_REQUEST['password']);
if(sizeof($checkUserName)>1||sizeof($checkUserPassword)>1)  {
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=notchecked.php'>\n";
}
//较验特殊字母 "
$checkUserName = explode('"',$_REQUEST['username']);
$checkUserPassword = explode('"',$_REQUEST['password']);
if(sizeof($checkUserName)>1||sizeof($checkUserPassword)>1)  {
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=notchecked.php'>\n";
}
//较验特殊字母 '
$checkUserName = explode("'",$_REQUEST['username']);
$checkUserPassword = explode("'",$_REQUEST['password']);
if(sizeof($checkUserName)>1||sizeof($checkUserPassword)>1)  {
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=notchecked.php'>\n";
}

$rs_a	=	logincheck($_REQUEST['username'],$_REQUEST['password']);
if($rs_a[0]['USER_NAME']!=''){
	session_start();
	$rs_a[0]['THEME'] = '3';
	$_SESSION['LOGIN_UID']		=	$rs_a[0]['UID'];
	$_SESSION['LOGIN_USER_ID']	=	$rs_a[0]['USER_ID'];
	$_SESSION['LOGIN_DEPT_ID']	=	$rs_a[0]['DEPT_ID'];
	$_SESSION['LOGIN_USER_PRIV']=	$rs_a[0]['USER_PRIV'];
	$_SESSION['LOGIN_THEME']	=	$rs_a[0]['THEME'];
	$_SESSION['LOGIN_AVATAR']	=	$rs_a[0]['AVATAR'];
	$_SESSION['LOGIN_USER_NAME']=	$rs_a[0]['USER_NAME'];
	
	$sql = "select FUNC_ID_STR from ".$prefix."user_priv where USER_PRIV='".$rs_a[0]['USER_PRIV']."'";
	$rs_user_priv = $db->Execute($sql);
	$rs_user_priv_array = $rs_user_priv->GetArray();
	$FUNC_ID_STR = $rs_user_priv_array[0]['FUNC_ID_STR'];
	$_SESSION['LOGIN_FUNC_ID_STR'] = $FUNC_ID_STR;

	$DEPT_ID=$rs_a[0]['DEPT_ID'];
	$sql="select DEPT_NAME from ".$prefix."department where DEPT_ID='$DEPT_ID'";
	//print $sql;
	$rs_d=$db->Execute($sql);
	$DEPT_NAME=$rs_d->fields['DEPT_NAME'];

	$USER_PRIV=$rs_a[0]['USER_PRIV'];
	$sql="select PRIV_NAME from ".$prefix."user_priv where USER_PRIV='$USER_PRIV'";
	//print $sql;
	$rs_u=$db->Execute($sql);
	$PRIV_NAME=$rs_u->fields['PRIV_NAME'];

	$_SESSION[$SUNSHINE_USER_DEPT_NAME_VAR]=$DEPT_NAME;
	$_SESSION[$SUNSHINE_USER_PRIV_NAME_VAR]=$PRIV_NAME;
	//print $SUNSHINE_USER_AVATAR_VAR;

	$goalfile = "Interface/Framework/sms_config.ini";
	@$ini_file = @parse_ini_file( $goalfile );
	$_SESSION['SmsServerIP']=$ini_file[SmsServerIP];
	$_SESSION['SmsLoginID']=$ini_file[SmsLoginID];
	$_SESSION['SmsLoginPWD']=$ini_file[SmsLoginPWD];
	
	//print_R($_SESSION);print_R($_GET);exit;
	$MENU_TYPE = 0;

	//日志记录
	//system_log_input('登录成功');

	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=Framework/index.php'>\n";


	//echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=Framework/index.php'>\n";
}
else	{
	//system_log_input('登录失败');
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=notchecked.php'>\n";

}
?>
