<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$CurrentXueQi = "提供当前学期的INPUT输入框";
function CurrentXueQi_Add($fields,$i)
{
		global $db;
		$sql = "select 学期名称 from edu_xueqiexec where 当前学期='1'";
		$rs = $db -> Execute($sql);
		$字段名称 = $fields['name'][$i];

		$当前学期 = $rs -> fields['学期名称'];
		print "<Tr class=TableData><Td>当前学期:</Td><Td colspan=2><Input class='SmallStatic' size=20 readonly='readonly' Name='$字段名称' value=".$当前学期."></Td></Tr>";
}

?>