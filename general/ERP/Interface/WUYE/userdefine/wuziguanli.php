<?php
function wuziguanli_Value($fieldvalue,$fields,$i)		{

    global $db;
	global $tablename,$html_etc,$common_html;
	$物资编号 = strip_tags($fields['value'][$i]['物资编号']);
	$商品名称 = strip_tags($fields['value'][$i]['商品名称']);
	$所属部门 = strip_tags($fields['value'][$i]['所属部门']);
	$单价 = strip_tags($fields['value'][$i]['单价']);
	//$商品名称 = strip_tags($fields['value'][$i]['商品名称']);
    
	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\">在库&nbsp;<</font>";
	$Text .= "<a class=OrgAdd href=\"wu_materialsequipmentj_newai.php?".base64_encode("action=add_default&物资编号=$物资编号&物资编号_NAME=$物资编号&物资编号_disabled=disabled&商品名称=$商品名称&商品名称_NAME=$商品名称&商品名称_disabled=disabled&所属部门=$所属部门&所属部门_NAME=$所属部门&所属部门_disabled=disabled&单价=$单价&单价_NAME=$单价&单价_disabled=disabled")."\">借领管理</a>";

	$Text .= "<a class=OrgAdd href=\"wu_materialsequipmenth_newai.php?".base64_encode("action=add_default&物资编号=$物资编号&物资编号_NAME=$物资编号&物资编号_disabled=disabled&商品名称=$商品名称&商品名称_NAME=$商品名称&商品名称_disabled=disabled&所属部门=$所属部门&所属部门_NAME=$所属部门&所属部门_disabled=disabled&单价=$单价&单价_NAME=$单价&单价_disabled=disabled")."\">归还管理</a>";

	$Text .= "<a class=OrgAdd href=\"wu_materialsequipmentx_newai.php?".base64_encode("action=add_default&物资编号=$物资编号&物资编号_NAME=$物资编号&物资编号_disabled=disabled&商品名称=$商品名称&商品名称_NAME=$商品名称&商品名称_disabled=disabled&所属部门=$所属部门&所属部门_NAME=$所属部门&所属部门_disabled=disabled&单价=$单价&单价_NAME=$单价&单价_disabled=disabled")."\">维修管理</a>";

	$Text .= "<a class=OrgAdd href=\"wu_materialsequipmentf_newai.php?".base64_encode("action=add_default&物资编号=$物资编号&物资编号_NAME=$物资编号&物资编号_disabled=disabled&商品名称=$商品名称&商品名称_NAME=$商品名称&商品名称_disabled=disabled&所属部门=$所属部门&所属部门_NAME=$所属部门&所属部门_disabled=disabled&单价=$单价&单价_NAME=$单价&单价_disabled=disabled")."\">报废管理</a>";

	$Text .= "<font size=\"2\" color=\"red\">></font>";
	return $Text;

}
?>