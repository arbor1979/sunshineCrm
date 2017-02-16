<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时
function jumpuserinforall_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldValue = $fields['value'][$fieldname];
	$showtext  = $html_etc[$tablename][$fieldname];
	$fieldnameID = $fieldname."_ID";

	$fieldValueArray = explode(',',$fieldValue);
	for($i=0;$i<sizeof($fieldValueArray);$i++)		{
		$fieldValueID .= returntablefield("user","USER_NAME",$fieldValueArray[$i],"USER_ID").",";
	}
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"".$fields['other']['inputcols']."\">\n";
	print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValueID\">\n";

	print "<textarea cols=40 name=\"$fieldname\" rows=6 class=\"BigStatic\" wrap=\"yes\" readonly>$fieldValue</textarea>
        &nbsp;<input type=\"button\" value=\"添 加\" class=\"SmallButton\" onClick=\"SelectUser('','$fieldnameID','$fieldname')\" title=\"选择人员\" name=\"button\">
        &nbsp;<input type=\"button\" value=\"清 空\" class=\"SmallButton\" onClick=\"ClearUser('$fieldnameID','$fieldname')\" title=\"清空人员\" name=\"button\">\n";
	print $addtext = FilterFieldAddText($addtext,$fieldname);
	print "</TD></TR>\n";
}

?>