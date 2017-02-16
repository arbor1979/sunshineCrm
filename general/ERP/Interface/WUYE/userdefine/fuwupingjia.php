
<?php
function fuwupingjia_Value($fieldvalue,$fields,$i)		{

    global $db;
	global $tablename,$html_etc,$common_html;
	$编号       = strip_tags($fields['value'][$i]['编号']);
	$楼房地址   = strip_tags($fields['value'][$i]['楼房地址']);
	$报修项目   = strip_tags($fields['value'][$i]['报修项目']);
    $报修人     = strip_tags($fields['value'][$i]['报修人']);
	$业主姓名   = strip_tags($fields['value'][$i]['业主姓名']);
    $维修人员   = strip_tags($fields['value'][$i]['维修人员']);
	$是否受理   = strip_tags($fields['value'][$i]['是否受理']);
	$维修状态   = strip_tags($fields['value'][$i]['维修状态']);
	$是否评价   = strip_tags($fields['value'][$i]['是否评价']);

	$Text = "";
    if($维修状态 == "是" and $是否评价 == ""){

	$Text .= "<font size=\"2\" color=\"red\"><</font>";
	$Text .= "<a class=OrgAdd href=\"my6_wu_maintenancemanagement_newai.php?".base64_encode("action=edit_default&编号=$编号&编号_NAME=$编号&编号_disabled=disabled&楼房地址=$楼房地址&楼房地址_NAME=$楼房地址&楼房地址_disabled=disabled&报修项目=$报修项目&报修项目_NAME=$报修项目&报修项目_disabled=disabled&报修人=$报修人&报修人_NAME=$报修人&报修人_disabled=disabled&业主姓名=$业主姓名&业主姓名_NAME=$业主姓名&业主姓名_disabled=disabled&维修人员=$维修人员&维修人员_NAME=$维修人员&维修人员_disabled=disabled&是否受理=$是否受理&是否受理_NAME=$是否受理&是否受理_disabled=disabled&维修状态=$维修状态&维修状态_NAME=$维修状态&维修状态_disabled=disabled")."\">是否评价</a> ";
    $Text .= "<font size=\"2\" color=\"red\">></font>";  
	}else if($维修状态 == "否" and $是否评价 == ""){
    $Text .= "<font size=\"2\" color=\"green\">不能评价</font>";
	}if($维修状态 == "是" and $是否评价 == "是"){
    $Text .= "<font size=\"2\" color=\"red\">已经评价过</font>";
	}		
	return $Text;
}
?>