<?php
/*
设置区域管理页面的管理操作模块
*/

function quyuguanli_Value($fieldvalue,$fields,$i)		{    
	global $db;
	global $tablename,$html_etc,$common_html;
	$区域名称  = strip_tags($fields['value'][$i]['区域名称']);

	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\">已交付&nbsp;<</font>";
	$Text .= "<a class=OrgAdd href=\"wu_buildinginformation_newai.php?".base64_encode("action=add_default&区域名称=$区域名称&区域名称_NAME=$区域名称&区域名称_disabled=disabled")."\">管理大楼</a> ";
	$Text .= "<font size=\"2\" color=\"red\">></font>";
	return $Text;
}
?>