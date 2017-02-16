<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
function userDefineProvince_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldvalue = $fields['value'][$fieldname];
	switch(strlen($fieldvalue))			{
		case '2':
			$fieldvalue = $fieldvalue."0000";
			break;
		case '4':
			$fieldvalue = $fieldvalue."00";
			break;
		case '6':
			break;
	}
	$sql = "select countryName from dict_countrycode where countryCode = '$fieldvalue'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$fieldvalue = $rs_a[0]['countryName'];
	print "<TR>\n";
    print "<TD class=TableContent noWrap width=20%>".$html_etc[$tablename][$fieldname]." </TD>\n";
    print "<TD class=TableData noWrap colspan=\"$colspan\">".$fieldvalue."</TD>\n";
	print "</TR>\n";
}

function userDefineProvince_view($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldvalue = $fields['value'][$fieldname];
	switch(strlen($fieldvalue))			{
		case '2':
			$fieldvalue = $fieldvalue."0000";
			break;
		case '4':
			$fieldvalue = $fieldvalue."00";
			break;
		case '6':
			break;
	}
	$sql = "select countryName from dict_countrycode where countryCode = '$fieldvalue'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$fieldvalue = $rs_a[0]['countryName'];
	print "<TR>\n";
    print "<TD class=TableContent noWrap width=20%>".$html_etc[$tablename][$fieldname]." </TD>\n";
    print "<TD class=TableData noWrap colspan=\"$colspan\">".$fieldvalue."</TD>\n";
	print "</TR>\n";
}

function userDefineProvince_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	switch(strlen($fieldvalue))			{
		case '2':
			$fieldvalue = $fieldvalue."0000";
			break;
		case '4':
			$fieldvalue = $fieldvalue."00";
			break;
		case '6':
			break;
	}
	$sql = "select countryName from dict_countrycode where countryCode = '$fieldvalue'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$fieldvalue = $rs_a[0]['countryName'];
	return $fieldvalue;
}
?>