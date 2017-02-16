<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$jumpclassroominfor = "选择所有大楼弹出框";
function jumpdalouinfor_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldValue = $fields['value'][$fieldname];
	$showtext  = $html_etc[$tablename][$fieldname];
	$fieldnameID = $fieldname."_ID";
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"".$fields['other']['inputcols']."\">\n";
	print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
    print "<input type=\"text\" name=\"$fieldnameID\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"20\">\n";
	print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectAllInforSingle('../../Enginee/Module/dalou_select_single/index.php','','$fieldname', '$fieldnameID')\">选择</a>\n";
	print "<a href=\"#\" class=\"orgClear\" onClick=\"ClearUser('$fieldname', '$fieldnameID')\" title=\"清空\">清空</a>";
	print $addtext = FilterFieldAddText($addtext,$fieldname);
	print "</TD></TR>\n";
	//SelectUserSingle
}
?>