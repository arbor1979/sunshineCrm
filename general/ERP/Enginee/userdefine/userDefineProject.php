<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时
function userDefineProject_add($fields,$i)		{
	global $db;	
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldName1 = $fields['name'][$i+1];
	$fieldName2 = $fields['name'][$i+2];
	$fieldName3 = $fields['name'][$i+3];

	$fieldvalue = $fields['value'][$fieldname];
	$fieldValue1 = $fields['value'][$fieldName1];
	$fieldValue2 = $fields['value'][$fieldName2];
	$fieldValue3 = $fields['value'][$fieldName3];

	$fieldHtml  = $html_etc[$tablename][$fieldname];
	$fieldHtml1 = $html_etc[$tablename][$fieldName1];
	$fieldHtml2 = $html_etc[$tablename][$fieldName2];
	$fieldHtml3 = $html_etc[$tablename][$fieldName3];

	$fieldHtml_ALL  = $html_etc[$tablename][$fieldname."_ALL"];


	 //用户类型限制条件##########################开始
	 global $fields;
	 //print_R($fields['USER_PRIVATE']);
	 if($fields['USER_PRIVATE'][$fieldname]!="")	{
		 $readonly = $fields['USER_PRIVATE'][$fieldname];
		 $class = "SmallStatic";
		 $class2 = "BigStatic";
	 }
	 else	{
		 $readonly = "";
		 $class = "SmallInput";
		 $class2 = "BigInput";
	 }
	 //用户类型限制条件##########################结束


	print "<TR>\n";
    print "<TD class=TableData noWrap width=20%>".$fieldHtml_ALL.":</TD>\n";
    print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	$TableInfor[$fieldHtml] = "		<input type=input size=20 name=$fieldname class=$class $readonly value='".$fieldvalue."'>";
	$TableInfor[$fieldHtml1] = "		<input type=input size=20 name=$fieldName1 $readonly class=$class value='".$fieldValue1."'>";
	$TableInfor[$fieldHtml2] = "		<input type=input size=20 name=$fieldName2 $readonly class=$class value='".$fieldValue2."'>";
	$TableInfor[$fieldHtml3] = "		<input type=input size=20 name=$fieldName3 $readonly class=$class value='".$fieldValue3."'>";
	TableInforOutPut($TableInfor,"80%");
	print "</TD>\n";
	print "</TR>\n";
}

//提供用户自定义类型：用于查阅数据时
function userDefineProject_view($fields,$i)		{
	global $db;
	
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldName1 = $fields['name'][$i+1];
	$fieldName2 = $fields['name'][$i+2];
	$fieldName3 = $fields['name'][$i+3];

	$fieldvalue = $fields['value'][$fieldname];
	$fieldValue1 = $fields['value'][$fieldName1];
	$fieldValue2 = $fields['value'][$fieldName2];
	$fieldValue3 = $fields['value'][$fieldName3];

	$fieldHtml  = $html_etc[$tablename][$fieldname];
	$fieldHtml1 = $html_etc[$tablename][$fieldName1];
	$fieldHtml2 = $html_etc[$tablename][$fieldName2];
	$fieldHtml3 = $html_etc[$tablename][$fieldName3];

	$fieldHtml_ALL  = $html_etc[$tablename][$fieldname."_ALL"];

	
	print "<TR>\n";
    print "<TD class=TableContent noWrap width=20%>".$fieldHtml_ALL.":</TD>\n";
    print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	$TableInfor[$fieldHtml] = $fieldvalue;
	$TableInfor[$fieldHtml1] = $fieldValue1;
	$TableInfor[$fieldHtml2] = $fieldValue2;
	$TableInfor[$fieldHtml3] = $fieldValue3;
	TableInforOutPut($TableInfor,"80%");
	print "</TD>\n";
	print "</TR>\n";
}


function userDefineProject($fieldname,$fieldvalue)		{
	global $db;
	global $fields,$tablename,$html_etc,$common_html;
	print "<TR>\n";
    print "<TD class=TableContent noWrap width=20%>".$html_etc[$tablename][$fieldname]." sss</TD>\n";
    print "<TD class=TableData noWrap colspan=\"$colspan\">".$fieldvalue."</TD>\n";
	print "</TR>\n";
}

function userDefineProject_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	return $fieldvalue;
}
?>