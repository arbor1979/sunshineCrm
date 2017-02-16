<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

header("Content-Type:text/html;charset=gbk");
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();

global $db;

///*以下为旧版处理方式,新版本从教学计划中获取对应信息
if($_GET['action']=="showdatas"&&$_GET['TableName']!="")
{
	$MetaColumnNames = $db->MetaColumnNames($_GET['TableName']);
	$MetaColumnNames = @array_keys($MetaColumnNames);

	$sql	= "SHOW TABLE STATUS FROM $MYSQL_DB LIKE '".$_GET['TableName']."%'";
	$rs		= $db->CacheExecute(150,$sql);
	$表备注 = $rs->fields['Comment'];

	print join(',',$MetaColumnNames);
	print ";";
	//您好,您有新的办公用品入库信息,办公用品名称:{办公用品名称},办公用品编号:{办公用品名称编号},入库仓库:{入库仓库},入库数量:{入库数量},经手人:{经手人},批准人:{批准人},备注:{备注},创建人:{创建人},单价:{单价},数量:{数量},金额:{金额}
	$ElementArray = array();
	array_shift($MetaColumnNames);
	for($i=0;$i<sizeof($MetaColumnNames);$i++)			{
		$字段 = $MetaColumnNames[$i];
		$ElementArray[] .= $字段.":{".$字段."}";
	}
	print "您有的新的".$表备注."信息,".join(',',$ElementArray)."";
	exit;
}


?>
