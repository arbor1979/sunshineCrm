<?php
function jielingguihuan_Value($fieldvalue,$fields,$i)		{
    //
    global $db;
	global $tablename,$html_etc,$common_html;
	$物资编号 = strip_tags($fields['value'][$i]['物资编号']);
	$商品名称 = strip_tags($fields['value'][$i]['商品名称']);
	$所属部门 = strip_tags($fields['value'][$i]['所属部门']);
	$单价 = strip_tags($fields['value'][$i]['单价']);
	$数量 = strip_tags($fields['value'][$i]['数量']);
    
	//$sql = "delete from wu_materialsequipment where 物资编号='$物资编号' and 商品名称='$商品名称' and 所属部门='$所属部门' and 出入库类型='借领'";
	//$db->Execute($sql);

	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\"><</font>";
	$Text .= "<a class=OrgAdd href=\"wu_materialsequipmenth_newai.php?"."action=add_default&物资编号=$物资编号&物资编号_NAME=$物资编号&物资编号_disabled=disabled&商品名称=$商品名称&商品名称_NAME=$商品名称&商品名称_disabled=disabled&所属部门=$所属部门&所属部门_NAME=$所属部门&所属部门_disabled=disabled&单价=$单价&单价_NAME=$单价&单价_disabled=disabled&数量=$数量&数量_NAME=$数量&数量_disabled=disabled"."\">归还</a>";

	$Text .= "<font size=\"2\" color=\"red\">></font>";
	return $Text;

}
?>