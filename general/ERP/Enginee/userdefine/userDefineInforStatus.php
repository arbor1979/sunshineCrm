<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时
function userDefineInforStatus_add($fields,$i)		{
	global $db;	
	global $tablename,$html_etc,$common_html;
	
	$fieldname_Apply = $fields['name'][$i-1];

	$fieldname = $fields['name'][$i];
	$fieldName1 = $fields['name'][$i+1];

	$fieldvalue = $fields['value'][$fieldname];
	$fieldValue1 = $fields['value'][$fieldName1];

	$fieldname_Apply_Value = $fields['value'][$fieldname_Apply];

	$fieldHtml  = $html_etc[$tablename][$fieldname];
	$fieldHtml1 = $html_etc[$tablename][$fieldName1];

	
	$fieldHtml_ALL  = $html_etc[$tablename]['inforstatusmanagement'];
	
	print "<TR>\n";
    print "<TD class=TableContent noWrap width=20%>".$fieldHtml_ALL.":</TD>\n";
    print "<TD class=TableData noWrap colspan=\"$colspan\">\n";

	if($fieldname_Apply_Value=="on"||$fieldname_Apply_Value==1)		{
		$Apply_Check = "";
		$title = "该客户已申请报备";
	}
	else	{
		$Apply_Check = "disabled";
		$title = "该客户未申请报备";
	}

	if($fieldvalue=="on")	$checked = "checked";
	else	$checked = "";
	$TableInfor['Content'][$fieldHtml]  = "		<input type=checkbox name=$fieldname title='$title' $checked $Apply_Check>	  ";

	if($fieldValue1=="on")	$checked = "checked";
	else	$checked = "";
	$TableInfor['Content'][$fieldHtml1] = "		<input type=checkbox name=$fieldName1 $checked>　　";

	$TableInfor['cols'][$fieldHtml]  = "1";
	$TableInfor['cols'][$fieldHtml1] = "1";

	TableInforOutPut($TableInfor,"40%");
	print "</TD>\n";
	print "</TR>\n";
}

//提供用户自定义类型：用于查阅数据时
function userDefineInforStatus_view($fields,$i)		{
	global $db;	
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldName1 = $fields['name'][$i+1];

	$fieldvalue = $fields['value'][$fieldname];
	$fieldValue1 = $fields['value'][$fieldName1];

	$fieldHtml  = $html_etc[$tablename][$fieldname];
	$fieldHtml1 = $html_etc[$tablename][$fieldName1];

	
	$fieldHtml_ALL  = $html_etc[$tablename]['inforstatusmanagement'];
	
	print "<TR>\n";
    print "<TD class=TableContent noWrap width=20%>".$fieldHtml_ALL.":</TD>\n";
    print "<TD class=TableData noWrap colspan=\"$colspan\">\n";

	if($fieldvalue=="on")	$checked = "checked";
	else	$checked = "";
	$TableInfor['Content'][$fieldHtml]  = "		<input type=checkbox name=$fieldname disabled $checked>　";

	if($fieldValue1=="on")	$checked = "checked";
	else	$checked = "";
	$TableInfor['Content'][$fieldHtml1] = "		<input type=checkbox name=$fieldName1 disabled $checked>　";

	$TableInfor['cols'][$fieldHtml]  = "1";
	$TableInfor['cols'][$fieldHtml1] = "1";

	TableInforOutPut($TableInfor,"40%");
	print "</TD>\n";
	print "</TR>\n";
}


function userDefineInforStatus_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	return $fieldvalue;
}
?>