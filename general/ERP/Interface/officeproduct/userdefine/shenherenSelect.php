<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时

function shenherenSelect_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc;
	$memo = "申请将提交此人审核方能生效";
	$storeid = $_GET['出库仓库'];
	$userid = returntablefield( "officeproductcangku", "编号", $storeid, "仓库负责人" );
	$useridArray=explode(",", $userid);	
	$FieldName = $fields['name'][$i];
	$showtext = $html_etc[$tablename][$FieldName];
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"".$fields['other']['inputcols']."\">\n";
	print "<select name=\"$FieldName\" value=\"\">\n";
	foreach ($useridArray as $row)
	{
		if($row!='')
			print "<option value='$row'>".returntablefield("user", "user_id", $row, "user_name")."</option>";
	}
	print "</select>&nbsp;$memo";
	print "</TD></TR>\n";
}

?>