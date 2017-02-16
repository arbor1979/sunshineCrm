<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('allow_call_time_pass_reference',0);
error_reporting(E_WARNING | E_ERROR);

$SYSTEM_EXEC_TIME = time();

//$SYSTEM_DB_TYPE = "MYSQL";
//$SYSTEM_ADD_STRIP = "\"";

$db=NewADOConnection("mysqli");
$db->Connect($localhost,$userdb_name,$userdb_pwd,$userdb);

global $_SESSION,$db;
$SUNSHINE_MYSQL_VERSION = $_SESSION['SUNSHINE_MYSQL_VERSION'];
/*
if($SUNSHINE_MYSQL_VERSION=="")				{
	$ServerInfo = $db->ServerInfo();
	$_SESSION['SUNSHINE_MYSQL_VERSION'] = $ServerInfo['version'];
	$SUNSHINE_MYSQL_VERSION = $_SESSION['SUNSHINE_MYSQL_VERSION'];
}//得到MYSQL VERSION的值
if($SUNSHINE_MYSQL_VERSION>='5.0.0')				{
	//MYSQL 4版本,不能执行SET NAMES GBK等操作
	$db->Execute("set names gbk");
}
*/
//$db->Execute("set names EUC_CN");
$db->Execute("set names gbk;");
$db->Execute("SET sql_mode='';");

$uploadsfilesize=2000000;
$ADODB_FETCH_MODE=ADODB_FETCH_ASSOC;


$SUNSHINE_USER_ID_VAR='SUNSHINE_USER_ID';
$SUNSHINE_USER_NAME_VAR='SUNSHINE_USER_NAME';
$SUNSHINE_USER_DEPT_VAR='SUNSHINE_USER_DEPT';
$SUNSHINE_USER_PRIV_VAR='SUNSHINE_USER_PRIV';
$SUNSHINE_USER_PRIV_NAME_VAR='SUNSHINE_USER_PRIV_NAME';
$SUNSHINE_USER_DEPT_NAME_VAR='SUNSHINE_USER_DEPT_NAME';
$SUNSHINE_USER_NICK_NAME_VAR='SUNSHINE_USER_NICK_NAME';
$SUNSHINE_USER_AVATAR_VAR='SUNSHINE_USER_AVATAR';
$SUNSHINE_USER_LANG_VAR='SUNSHINE_USER_LANG';
$SUNSHINE_USER_SMS_ON_VAR='SUNSHINE_USER_SMS_ON';
$SUNSHINE_USER_MENU_HIDE_VAR='SUNSHINE_USER_MENU_HIDE';


//重新初始化变更,应对REGISTER_GLOBALS为OFF时的情况
$_GETKeyArray = @array_keys($_GET);
for($i=0;$i<sizeof($_GETKeyArray);$i++)				{
	$_GETKey	= $_GETKeyArray[$i];
	$$_GETKey	= $_GET[$_GETKey];
}

$_POSTKeyArray = @array_keys($_POST);
for($i=0;$i<sizeof($_POSTKeyArray);$i++)			{
	$_POSTKey	= $_POSTKeyArray[$i];
	$$_POSTKey	= $_POST[$_POSTKey];
}

$LOGIN_THEME		= $_SESSION['LOGIN_THEME'];
$LOGIN_USER_ID		= $_SESSION['LOGIN_USER_ID'];
$LOGIN_USER_NAME	= $_SESSION['LOGIN_USER_NAME'];
$LOGIN_DEPT_ID		= $_SESSION['LOGIN_DEPT_ID'];
$LOGIN_USER_PRIV	= $_SESSION['LOGIN_USER_PRIV'];


?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>