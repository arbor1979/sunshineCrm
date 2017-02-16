<?php 
error_reporting( E_ALL & ~E_NOTICE);
$SYSTEM_THEME = "3";
$SYSTEM_PRIV_ROW = "0";

$MYSQL_SERVER	=	$localhost;
$MYSQL_USER		=	$userdb_name;
$MYSQL_PASS		=	$userdb_pwd;
$MYSQL_DB		=	$userdb;


$LOGIN_THEME = 3;


$SYSTEM_MODE = "1";
$SYSTEM_DEBUG_SQL = "1";
if(!defined(ROOT_DIR))
{
	$baseUrl = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME'])); 
	$baseUrl = empty($baseUrl) ? '/' : '/'.trim($baseUrl,'/').'/';  
	$dirArray=explode("general", $baseUrl);
	define("ROOT_DIR",$dirArray[0]);
	
	$baseUrl=str_replace("\\", "/",dirname(__FILE__))."<br>";
	$dirArray=explode("general", $baseUrl);
	define("DOCUMENT_ROOT",$dirArray[0]);
	
}

//重新初始化变更,应对REGISTER_GLOBALS为OFF时的情况
$_GETKeyArray = @array_keys($_GET);
for($i=0;$i<sizeof($_GETKeyArray);$i++)			{
	$_GETKey	= $_GETKeyArray[$i];
	$$_GETKey	= $_GET[$_GETKey];
}

$_POSTKeyArray = @array_keys($_POST);
for($i=0;$i<sizeof($_POSTKeyArray);$i++)			{
	$_POSTKey	= $_POSTKeyArray[$i];
	$$_POSTKey	= $_POST[$_POSTKey];
}
?>