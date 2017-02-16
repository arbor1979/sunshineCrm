<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$password = "用户列表密码判断";
//#########################################################
function password_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";

	if (crypt('', $fieldvalue) == $fieldvalue) {
	   $Text .= "&nbsp<font color=red>密码为空</font>&nbsp&nbsp;";
	}
	else	{
		$Text .= "&nbsp<font color=green>存在密码</font>&nbsp&nbsp;";
	}
	return $Text;
}

function password_Value_PRIV($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$USER_ID = $fields['value'][$i]['USER_ID'];
	switch($USER_ID)		{
		case 'admin':
			$SYSTEM_STOP_ROW['edit_priv'] = 0;
			$SYSTEM_STOP_ROW['delete_priv'] = 1;
			break;
	}
	return $SYSTEM_STOP_ROW;
}

?>