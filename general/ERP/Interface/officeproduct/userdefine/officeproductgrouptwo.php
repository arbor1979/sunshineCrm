<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供资产管理部分中资产状态的部分信息设定。
//#########################################################

function officeproductgrouptwo_Add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;

	$notnull=trim($fields['null'][$i]['inputtype']);
	$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
	$fieldname = $fields['name'][$i];
	$fieldValue = $fields['value'][$fieldname];
	$showtext  = $html_etc[$tablename][$fieldname];
	$fieldnameID = $fieldname."_ID";
	$fieldValueName = returntablefield("officeproductgroup", "编号",$fieldValue , "名称");
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
    print "<input type=\"text\" name=\"$fieldnameID\" value=\"$fieldValueName\" readonly class=\"SmallStatic\" size=\"20\">\n";
	print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectAllInforSingle('./Module','','$fieldname', '$fieldnameID')\">选择</a>&nbsp;\n";
	print $notnulltext;
	print "</TD></TR>\n";
	

}
?>