<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$user_priv = "用户权限链接";
//#########################################################
function user_priv_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$USER_ID = $fields['value'][$i]['USER_ID'];
	$Text = "<a href=\"?".base64_encode("action=edit_purview&USER_ID=$USER_ID&dd=dd")."\">菜单功能</a>";
	return $Text;
}


?>