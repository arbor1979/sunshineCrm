<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
$password = "�û��б������ж�";
//#########################################################
function password_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";

	if (crypt('', $fieldvalue) == $fieldvalue) {
	   $Text .= "&nbsp<font color=red>����Ϊ��</font>&nbsp&nbsp;";
	}
	else	{
		$Text .= "&nbsp<font color=green>��������</font>&nbsp&nbsp;";
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