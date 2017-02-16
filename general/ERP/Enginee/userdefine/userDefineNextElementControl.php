<?php
//##########################################################
//格式：_add _view _Value				说明性表述方式
//userDefineNextElementControl_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineNextElementControl_view		查阅视图函数说明
//userDefineNextElementControl_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时
function userDefineNextElementControl_add($fields,$i)		{
	global $db;	
	global $tablename,$html_etc,$common_html;
	
	$fieldname = $fields['name'][$i];
	$fieldName1 = $fields['name'][$i+1];

	$fieldvalue = $fields['value'][$fieldname];
	$fieldValue1 = $fields['value'][$fieldName1];

	$fieldHtml  = $html_etc[$tablename][$fieldname];
	$fieldHtml1 = $html_etc[$tablename][$fieldName1];

	
	print "<TR>\n";
    print "<TD class=TableContent noWrap width=20%>".$fieldHtml.":</TD>\n";
    print "<TD class=TableData colspan=$colspan>";
	if($fieldvalue==1||$fieldvalue=="on")	{
		print "<label>";
		print "<input type=\"radio\" class=Smallradio name=$fieldname value=\"1\" checked onClick=\"javasrcipt:document.form1.$fieldName1.disabled=false;\">".$common_html['common_html']['yes']."\n";
		print "<input type=\"radio\" name=$fieldname value=\"0\" onClick=\"javasrcipt:document.form1.$fieldName1.disabled=true;\">".$common_html['common_html']['no']."\n";
		print "</label>";

	}else	{
		print "<label>";
		print "<input type=\"radio\" class=Smallradio name=$fieldname value=\"1\" onClick=\"javasrcipt:document.form1.$fieldName1.disabled=false;\">".$common_html['common_html']['yes']."\n";
		print "<input type=\"radio\" name=$fieldname  checked  value=\"0\" onClick=\"javasrcipt:document.form1.$fieldName1.disabled=true;\">".$common_html['common_html']['no']."\n";
		print "</label>";
	}
	print $addtext;
	print "</TD>\n";
	print "</TR>\n";
}

//提供用户自定义类型：用于查阅数据时
function userDefineNextElementControl_view($fields,$i)		{
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


function userDefineNextElementControl_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	return $fieldvalue;
}
?>