<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时
$jumpuserinfor3 = "以弹出对话框的形式来选择用户,同时得到字段联系电话的值，支持用户搜索,值为USER_NAME";
function jumpuserinfor3_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldValue = $fields['value'][$fieldname];
	$showtext  = $html_etc[$tablename][$fieldname];
	$fieldnameID = $fieldname."_ID";
	$fieldValueName =  $fields['value']['教师用户名'];
	if($fieldValueName=='')	{
		$fieldValueName = returntablefield("user","USER_NAME",$fieldValue,"USER_ID");
	}
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"".$fields['other']['inputcols']."\">\n";
	print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValueName\">\n";
    print "<input type=\"text\" name=\"$fieldname\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"20\">\n";
	print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectTeacherSingle2('联系电话','$fieldnameID', '$fieldname')\">选择</a>\n";
	print $addtext = FilterFieldAddText($addtext,$fieldname);
	print "</TD></TR>\n";
}

?>