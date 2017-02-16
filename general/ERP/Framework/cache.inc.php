<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
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
if(!defined(IE_TITLE))
{
	
	$fileParse = parse_ini_file(DOCUMENT_ROOT."general/ERP/Interface/Framework/system_config.ini" );
	$LoginTitle = $fileParse['LoginTitle'];
	$IETitle = $fileParse['IETitle'];
	$CompanyName = $fileParse['CompanyName'];
	$status_bar = $fileParse['status_bar'];
	define(IE_TITLE, $IETitle);
	define(LOGIN_TITLE, $LoginTitle);
	define(MAIN_TITLE, $CompanyName);
	define(STATUS_BAR, $status_bar);
}
$ADODB_CACHE_DIR ='../cache';

$IE_TITLE		= IE_TITLE;
$BANNER = LOGIN_TITLE;


?>