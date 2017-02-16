<?php
//判断是否为BASE64编码
//$isBase64 = isBase64();
//进行_GET变量转换
//$isBase64==1?CheckBase64():exit;


require_once('../../include.inc.php');

global $db;
if($_GET['action']="ajax"&&$_GET['tablename']!=""&&$_GET['updateField']!=""&&$_GET['primaryKey']!=""&&$_GET['newValue']!="")
{	
	$tablename = $_GET['tablename'];
	$updateField = $_GET['updateField'];
	$primarykeyValue = $_GET['primarykeyValue'];
	$primaryKey = $_GET['primaryKey'];
	$newValue = $_GET['newValue'];
	$sql = "update $tablename set $updateField='$newValue' where $primaryKey='$primarykeyValue'";
	//print $sql;exit;
	$rs=$db->Execute($sql);
}
else		{

}
?>
