<?php
function wuziguanli_Value($fieldvalue,$fields,$i)		{

    global $db;
	global $tablename,$html_etc,$common_html;
	$���ʱ�� = strip_tags($fields['value'][$i]['���ʱ��']);
	$��Ʒ���� = strip_tags($fields['value'][$i]['��Ʒ����']);
	$�������� = strip_tags($fields['value'][$i]['��������']);
	$���� = strip_tags($fields['value'][$i]['����']);
	//$��Ʒ���� = strip_tags($fields['value'][$i]['��Ʒ����']);
    
	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\">�ڿ�&nbsp;<</font>";
	$Text .= "<a class=OrgAdd href=\"wu_materialsequipmentj_newai.php?".base64_encode("action=add_default&���ʱ��=$���ʱ��&���ʱ��_NAME=$���ʱ��&���ʱ��_disabled=disabled&��Ʒ����=$��Ʒ����&��Ʒ����_NAME=$��Ʒ����&��Ʒ����_disabled=disabled&��������=$��������&��������_NAME=$��������&��������_disabled=disabled&����=$����&����_NAME=$����&����_disabled=disabled")."\">�������</a>";

	$Text .= "<a class=OrgAdd href=\"wu_materialsequipmenth_newai.php?".base64_encode("action=add_default&���ʱ��=$���ʱ��&���ʱ��_NAME=$���ʱ��&���ʱ��_disabled=disabled&��Ʒ����=$��Ʒ����&��Ʒ����_NAME=$��Ʒ����&��Ʒ����_disabled=disabled&��������=$��������&��������_NAME=$��������&��������_disabled=disabled&����=$����&����_NAME=$����&����_disabled=disabled")."\">�黹����</a>";

	$Text .= "<a class=OrgAdd href=\"wu_materialsequipmentx_newai.php?".base64_encode("action=add_default&���ʱ��=$���ʱ��&���ʱ��_NAME=$���ʱ��&���ʱ��_disabled=disabled&��Ʒ����=$��Ʒ����&��Ʒ����_NAME=$��Ʒ����&��Ʒ����_disabled=disabled&��������=$��������&��������_NAME=$��������&��������_disabled=disabled&����=$����&����_NAME=$����&����_disabled=disabled")."\">ά�޹���</a>";

	$Text .= "<a class=OrgAdd href=\"wu_materialsequipmentf_newai.php?".base64_encode("action=add_default&���ʱ��=$���ʱ��&���ʱ��_NAME=$���ʱ��&���ʱ��_disabled=disabled&��Ʒ����=$��Ʒ����&��Ʒ����_NAME=$��Ʒ����&��Ʒ����_disabled=disabled&��������=$��������&��������_NAME=$��������&��������_disabled=disabled&����=$����&����_NAME=$����&����_disabled=disabled")."\">���Ϲ���</a>";

	$Text .= "<font size=\"2\" color=\"red\">></font>";
	return $Text;

}
?>