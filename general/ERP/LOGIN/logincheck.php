<?php
header("Content-type:text/html;charset=gb2312");

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

require_once('include.inc.php');
//$表前缀 = "TD_OA.";
//print_R($db);exit;
$errmsg='';
function logincheck($username,$password)							{
	global $db,$表前缀;
	global $errmsg;
	$SQL		= "SELECT * FROM ".$表前缀."user WHERE USER_ID = '$username'";
	$rs			= $db->Execute($SQL);
	$rs_a		= $rs->GetArray();
	$USER_ID	= $rs_a[0]['USER_ID'];
	$PASSWORDTEXT = $rs_a[0]['PASSWORD'];
	$DISABLED=$rs_a[0]['DISABLED'];
	//print crypt('', $PASSWORDTEXT) == $PASSWORDTEXT;exit;
	//print_R($password);print_R($PASSWORDTEXT);exit;
	if($USER_ID!="")												{
		
		if(crypt($password,$PASSWORDTEXT) == $PASSWORDTEXT)			{
			//密码正确
			if($DISABLED==0)
			{
				$errmsg='用户被禁用';
			}
			else
				return $rs_a;
		}
		else	{
			//密码错误
			//print_R($password);print_R($username);exit;
			//echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=notchecked.php'>\n";
			$errmsg='密码错误';

		}
	}
	else	{
		//用户名不存在
		//print_R($password);print_R($_POST);exit;
		//echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=notchecked.php'>\n";
		$errmsg='用户名不存在';

	}

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
$_REQUEST['username']=iconv('UTF-8','gbk',$_REQUEST['username']);
$rs_a	=	logincheck($_REQUEST['username'],$_REQUEST['password']);
if($rs_a[0]['USER_NAME']!='')	{
	session_start();
	$rs_a[0]['THEME'] = '3';
	$_SESSION['LOGIN_UID']		=	$rs_a[0]['UID'];
	$_SESSION['LOGIN_USER_ID']	=	$rs_a[0]['USER_ID'];
	$_SESSION['LOGIN_DEPT_ID']	=	$rs_a[0]['DEPT_ID'];
	$_SESSION['LOGIN_USER_PRIV']=	$rs_a[0]['USER_PRIV'];
	$_SESSION['LOGIN_THEME']	=	$rs_a[0]['THEME'];
	$_SESSION['LOGIN_AVATAR']	=	$rs_a[0]['AVATAR'];
	$_SESSION['LOGIN_USER_NAME']=	$rs_a[0]['USER_NAME'];
	$_SESSION['LOGIN_FUNC_ID_STR'] = $rs_a[0]['FUNC_ID_STR'];
	$_SESSION['LOGIN_USER_MOBILE']	=	$rs_a[0]['MOBIL_NO'];
	$_SESSION['LEFT_MENU']		=	$rs_a[0]['leftmenu'];
	$_SESSION['RIGHT_MENU']		=	$rs_a[0]['rightmenu'];
	$_SESSION[SMTPServerIP]= $rs_a[0][SMTPServerIP];
	$_SESSION[EmailAddress]= $rs_a[0][EmailAddress];
	$_SESSION[EmailPassword]= $rs_a[0][EmailPassword];
		
	$DEPT_ID=$rs_a[0]['DEPT_ID'];
	$sql="select DEPT_NAME,bundleStore from ".$表前缀."department where DEPT_ID='$DEPT_ID'";
	//print $sql;
	$rs_d=$db->Execute($sql);
	$DEPT_NAME=$rs_d->fields['DEPT_NAME'];
	$STORE_PRIV=$rs_d->fields['bundleStore'];
	if($STORE_PRIV!='' && substr($STORE_PRIV,-1)==',')
		$STORE_PRIV=substr($STORE_PRIV,0,strlen($STORE_PRIV)-1);
	$USER_PRIV=$rs_a[0]['USER_PRIV'];
	$sql="select PRIV_NAME from ".$表前缀."user_priv where USER_PRIV='$USER_PRIV'";
	//print $sql;
	$rs_u=$db->Execute($sql);
	$PRIV_NAME=$rs_u->fields['PRIV_NAME'];
	$_SESSION['LOGIN_DEPT_NAME']	=	$DEPT_NAME;
	
	$sql="select ROWID from ".$表前缀."stock where user_id like '".$_SESSION['LOGIN_USER_ID'].",%' or user_id like '%,".$_SESSION['LOGIN_USER_ID'].",%'";
	//print $sql;
	$rs_d=$db->Execute($sql);
	foreach($rs_d as $row)
	{
		if($STORE_PRIV=='')
			$STORE_PRIV=$row['ROWID'];
		else
			$STORE_PRIV.=",".$row['ROWID'];
	}
	if($STORE_PRIV<>'')
		$_SESSION['STORE_PRIV']	=	$STORE_PRIV;
	else
		$_SESSION['STORE_PRIV']='0';
	$_SESSION[$SUNSHINE_USER_DEPT_NAME_VAR]=$DEPT_NAME;
	$_SESSION[$SUNSHINE_USER_PRIV_NAME_VAR]=$PRIV_NAME;
	//print $SUNSHINE_USER_AVATAR_VAR;

	$goalfile = "../Interface/Framework/global_config.ini";
	@$ini_file = @parse_ini_file( $goalfile );
	$_SESSION['SmsServerIP']=$ini_file[SmsServerIP];
	$_SESSION['SmsLoginID']=$ini_file[SmsLoginID];
	$_SESSION['SmsLoginPWD']=$ini_file[SmsLoginPWD];
	$_SESSION['limitEditDel']=$ini_file[limitEditDel];
	$_SESSION['ModifyPrice']=$ini_file[ModifyPrice];
	
	
	//精度
	$_SESSION['deptid']=1;
	$sql="select * from ".$表前缀."unit where id=".$_SESSION['deptid'];
	//print $sql;
	$rs_d=$db->Execute($sql);
	$_SESSION['numzero']=$rs_d->fields['numzero'];
	$_SESSION['UNIT_NAME']=$rs_d->fields['UNIT_NAME'];
	$_SESSION['TEL_NO']=$rs_d->fields['TEL_NO'];
	$_SESSION['ADDRESS']=$rs_d->fields['ADDRESS'];
	$_SESSION['shortname']=$rs_d->fields['shortname'];
	//print_R($_SESSION);print_R($_GET);exit;
	$MENU_TYPE = 0;
	
	//退货率
	@$global_config_ini_file = @parse_ini_file(DOCUMENT_ROOT.'general/ERP/Interface/Framework/global_config.ini',true);
	$_SESSION["TuiHuoRate"]=floatval($global_config_ini_file['section']['TuiHuoRate']);
	
	//日志记录
	system_log_input('登录成功',$_SESSION['LOGIN_USER_ID']);
	
	
	if($_GET['urllogin']=='1')
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=../Framework/index.php'>\n";
	else
		echo 'ok';

	//echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=Framework/index.php'>\n";
}
else	{
	system_log_input('登录失败',$_SESSION['LOGIN_USER_ID']);
	//echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=notchecked.php'>\n";
	echo $errmsg;

}
?>
