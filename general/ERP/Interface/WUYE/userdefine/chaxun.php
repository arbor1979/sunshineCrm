<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�ʲ����������ʲ�״̬�Ĳ�����Ϣ�趨��###############
//#########################################################
function chaxun_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$�������� = strip_tags($fields['value'][$i]['��������']);
	$���	= strip_tags($fields['value'][$i]['���']);
	//$���� = strip_tags($fields['value'][$i]['����']);
	$Text .= "&nbsp;";

	$Text .= "<a class=OrgAdd href=\"wu_managementdistrict_newai.php?"."action=view_default&���=$���&��������=$��������&��������_NAME=��������&��������_disabled=disabled"."\">$��������</a> ";


	return $Text;
}
?>