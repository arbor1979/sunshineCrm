<?php
require_once('../../include.inc.php');
global $db;
if($_GET['action']="showdatas"&&$_GET['value']!="")
{	
	$tablename = "dict_countrycode";
	$field_value = "countryCode";
	$field_name = "countryName";
	switch($add)	{
		case 'provinces':
			$sql = "select $field_name,$field_value from $tablename where countryCode like '$searchText' order by $field_value";
			$searchText = $_GET['value']."%00";
			break;
		case 'city':
			$searchText = $_GET['value']."%";
			$sql = "select $field_name,$field_value from $tablename where countryCode like '$searchText' order by $field_value";
			break;
		default:
			$sql = "select $field_name,$field_value from $tablename where countryCode like '$searchText'";
			$searchText = $_GET['value']."%00 order by $field_value";
			break;
	}
	$newarray = array();
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$newarray1[$i]=$rs_a[$i][$field_name];
		$newarray2[$i]=$rs_a[$i][$field_value];
	}
	array_shift($newarray1);
	array_shift($newarray2);
	print join(',',$newarray1);
	print ";";
	print join(',',$newarray2);
}
else		{
	print "没有数据";
}
?>
