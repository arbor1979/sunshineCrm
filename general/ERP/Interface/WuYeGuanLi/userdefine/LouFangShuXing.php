<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
	function LouFangShuXing_Add($fields,$i)
	{
		//*支持宿舍、办公室、教室等属性*//
		$Select = "<Select name='楼房属性'>";
		$Select .= "<Option Select>宿舍</Option>";
		$Select .= "<Option>教学楼</Option>";
		$Select .= "<Option>办公室</Option>";
		$Select .= "</Select>";
		print "<Tr class=TableData><Td>楼房属性:</Td><Td>".$Select."</Td></Tr>";
	}
?>