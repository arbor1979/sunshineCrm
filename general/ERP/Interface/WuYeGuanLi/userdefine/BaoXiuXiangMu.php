<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
	function BaoXiuXiangMu_Add($fields,$i)
	{
		//*支持宿舍、办公室、教室等属性*//
		$Select = "<Select name='报修项目'>";
		$Select .= "<Option Select>水</Option>";
		$Select .= "<Option>电</Option>";
		$Select .= "<Option>设备</Option>";
		$Select .= "<Option>其他</Option>";
		$Select .= "</Select>";
		print "<Tr class=TableData><Td>报修项目:</Td><Td>".$Select."</Td></Tr>";
	}
?>