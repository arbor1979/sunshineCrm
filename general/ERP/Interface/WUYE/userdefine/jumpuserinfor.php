<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时
$jumpuserinfor = "以弹出对话框的形式来选择用户,支持用户搜索,值为USER_ID";
function jumpuserinfor_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldValue = $fields['value'][$fieldname];
	$showtext  = $html_etc[$tablename][$fieldname];
	$fieldnameID = $fieldname."_ID";
	$fieldValueName = returntablefield("user","USER_ID",$fieldValue,"USER_NAME");
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"".$fields['other']['inputcols']."\">\n";
	print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
    print "<input type=\"text\" name=\"$fieldnameID\" value=\"$fieldValueName\" readonly class=\"SmallStatic\" size=\"20\">\n";
	print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectTeacherSingle('','$fieldname', '$fieldnameID')\">选择</a>\n";
	print $addtext = FilterFieldAddText($addtext,$fieldname);
	print "</TD></TR>\n";
}

?>