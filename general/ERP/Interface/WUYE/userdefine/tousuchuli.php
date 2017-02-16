
<?php
function tousuchuli_Value($fieldvalue,$fields,$i)		{

    global $db;
	global $tablename,$html_etc,$common_html;
	$编号       = strip_tags($fields['value'][$i]['编号']);
	$投诉序号   = strip_tags($fields['value'][$i]['投诉序号']);
	$投诉类别   = strip_tags($fields['value'][$i]['投诉类别']);
    $标题       = strip_tags($fields['value'][$i]['标题']);
	$单元编号   = strip_tags($fields['value'][$i]['单元编号']);
	$投诉人     = strip_tags($fields['value'][$i]['投诉人']);
	$投诉人电话 = strip_tags($fields['value'][$i]['投诉人电话']);
	$投诉时间   = strip_tags($fields['value'][$i]['投诉时间']);
	$投诉内容   = strip_tags($fields['value'][$i]['投诉内容']);
	$备注       = strip_tags($fields['value'][$i]['备注']);
	$是否受理   = strip_tags($fields['value'][$i]['是否受理']);
	
    $是否处理  = "是";
	$Text = "";
    if($处理结果 == ""){

	$Text .= "<font size=\"2\" color=\"red\"><</font>";
	$Text .= "<a class=OrgAdd href=\"wu2_usercomplaints_newai.php?".base64_encode("action=add_default&编号=$编号&编号_NAME=$编号&编号_disabled=disabled&投诉序号=$投诉序号&投诉序号_NAME=$投诉序号&投诉序号_disabled=disabled&投诉类别=$投诉类别&投诉类别_NAME=$投诉类别&投诉类别_disabled=disabled&标题=$标题&标题_NAME=$标题&标题_disabled=disabled&单元编号=$单元编号&单元编号_NAME=$单元编号&单元编号_disabled=disabled&投诉人=$投诉人&投诉人_NAME=$投诉人&投诉人_disabled=disabled&投诉人电话=$投诉人电话&投诉人电话_NAME=$投诉人电话&投诉人电话_disabled=disabled&投诉时间=$投诉时间&投诉时间_NAME=$投诉时间&投诉时间_disabled=disabled&投诉内容=$投诉内容&投诉内容_NAME=$投诉内容&投诉内容_disabled=disabled&是否受理=$是否受理&是否受理_NAME=$是否受理&是否受理_disabled=disabled&是否处理=$是否处理&是否处理_NAME=$是否处理&是否处理_disabled=disabled&备注=$备注&备注_NAME=$备注&备注_disabled=disabled")."\">处理结果操作</a> ";

    $Text .= "<font size=\"2\" color=\"red\">></font>";
    
	}else{	
    $Text .= "<font size=\"2\" color=\"red\">已经处理</font>";
	}	
	return $Text;
}
?>