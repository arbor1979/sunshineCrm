<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供资产管理部分中资产状态的部分信息设定。###############
//#########################################################
function chaxun_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$区域名称 = strip_tags($fields['value'][$i]['区域名称']);
	$编号	= strip_tags($fields['value'][$i]['编号']);
	//$姓名 = strip_tags($fields['value'][$i]['姓名']);
	$Text .= "&nbsp;";

	$Text .= "<a class=OrgAdd href=\"wu_managementdistrict_newai.php?"."action=view_default&编号=$编号&区域名称=$区域名称&区域名称_NAME=区域名称&区域名称_disabled=disabled"."\">$区域名称</a> ";


	return $Text;
}
?>