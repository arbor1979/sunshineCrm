<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
$user_priv = "�û�Ȩ������";
//#########################################################
function user_priv_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$USER_ID = $fields['value'][$i]['USER_ID'];
	$Text = "<a href=\"?".base64_encode("action=edit_purview&USER_ID=$USER_ID&dd=dd")."\">�˵�����</a>";
	return $Text;
}


?>