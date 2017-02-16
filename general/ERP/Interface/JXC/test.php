<?php
ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	//require_once('lib.inc.php');
	//$GLOBAL_SESSION=returnsession();
	//phpinfo();
	require_once('../../adodb/adodb.inc.php');
	require_once('../../config.inc.php');
	require_once('../../setting.inc.php');
	
try 
{

	$db->BeginTrans();
	$sql1="insert into test (id,name,sex) values(NULL,'test1','0')";
	$sql2="insert into test (did,name,sex) values(NULL,'test1','0')";
	$res1=$db->Execute($sql1); 
	$res2=$db->Execute($sql2);
	if($res1 && $res2)
	{
		$db->CommitTrans();
		echo "³É¹¦£¡";
	}
	else 
	{
		$db->RollbackTrans();
		echo "Ê§°Ü£¡";
	}
	
	
	
}
catch (Exception $e) 
{
	echo "´íÎó£º".$e->getMessage();
}
?>