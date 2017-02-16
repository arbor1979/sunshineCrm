<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供资产管理部分中资产状态的部分信息设定。
//#########################################################
$officeproductgroup = "用于办公用品分类部分设置,支持无限制父级目录";
function officeproductgroup_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$现有库存 = $fields['value'][$i]['库存管理'];
	$办公用品编号 = $fields['value'][$i]['办公用品编号'];
	$办公用品名称 = $fields['value'][$i]['办公用品名称'];
	
	$sql = "select SUM(入库数量) 入库数量总计 from officeproductin where 办公用品编号='$办公用品编号'";
	$rs = $db->Execute($sql);
	$入库数量总计 = $rs->fields['入库数量总计'];

	

	return $Text;
}


function officeproductgroup_Add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$上级分类		= $fields['value']['上级分类'];
	$名称CX		= $fields['value']['名称'];
	
	$sql = "select 名称 from officeproductgroup where 上级分类=''";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	
	$selectText .= "<select name=上级分类 class=SmallSelect>";
	if($上级分类=="")	$selectText .= "<option value=\"\" selected>一级分类</option>";
	else				$selectText .= "<option value=\"\" >一级分类</option>";
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$名称 = $rs_a[$i]['名称'];
		if($上级分类==$名称)	$selected = "selected";
		else					$selected = "";
		if($名称CX!=$名称)  $selectText .= "<option value=\"$名称\" $selected>$名称</option>";
	}
	$selectText .= "</select>";
	
	print "<tr class=TableData><td>选择上级分类</td><td>$selectText</td></tr>";
	

}
?>