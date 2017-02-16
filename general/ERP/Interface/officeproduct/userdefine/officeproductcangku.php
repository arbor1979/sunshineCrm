<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供资产管理部分中资产状态的部分信息设定。
//#########################################################

function officeproductcangku_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$sql="select * from officeproductcangku";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	$storelist=array();
	foreach ($rs_a as $row)
	{
		$userArray=explode(",",$row['仓库负责人']);
		if(in_array($_SESSION['LOGIN_USER_ID'], $userArray))
			array_push($storelist, $row);
	}
	$FieldName = $fields['name'][$i];
	$showtext = $html_etc[$tablename][$FieldName];
	$notnull=trim($fields['null'][$i]['inputtype']);
	$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"".$fields['other']['inputcols']."\">\n";
	print "<select name=\"$FieldName\" value=\"\">\n";
	foreach ($storelist as $row)
	{
		if($row!='')
			print "<option value='".$row['编号']."'>".$row['仓库名称']."</option>";
	}
	print "</select>&nbsp;$notnulltext";
	print "</TD></TR>\n";
}
?>