<?php
/*
���ÿշ�����ҳ��Ĺ������ģ��
*/

function kehuguanli_Value($fieldvalue,$fields,$i)		{

    global $db;
	global $tablename,$html_etc,$common_html;
	$���     = strip_tags($fields['value'][$i]['���']);
	$������� = strip_tags($fields['value'][$i]['�������']);
	$�������� = strip_tags($fields['value'][$i]['��������']);
	$��¥���� = strip_tags($fields['value'][$i]['��¥����']);

	$������� = strip_tags($fields['value'][$i]['�������']);
	$ҵ������ = strip_tags($fields['value'][$i]['ҵ������']);
	$ҵ���绰 = strip_tags($fields['value'][$i]['ҵ���绰']);

	$��Ԫ��   = strip_tags($fields['value'][$i]['��Ԫ��']);
	$¥���   = strip_tags($fields['value'][$i]['¥���']);
	$�����   = strip_tags($fields['value'][$i]['�����']);
	$��Ԫ״̬a = strip_tags($fields['value'][$i]['��Ԫ״̬']);
    
	$��Ԫ��� = $��¥����."-".$��Ԫ��."-".$¥���.$�����;
	$������� = $��¥����."-".$��Ԫ��."-".$¥���.$�����;
    
    $sql = "select * from wu_housingowner where �������='$�������' and ��Ԫ���='$��Ԫ���'";
	$result = $db->Execute($sql);
	$rs_a = $result->GetArray();
	$ҵ������ = $rs_a[0]['ҵ������'];
	$�ֻ����� = $rs_a[0]['�ֻ�'];
	$�绰���� = $rs_a[0]['�绰'];

	$ҵ���绰 = $�ֻ�����."��".$�绰����; 

    //echo $ҵ���绰;

	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\">δʹ��&nbsp;<</font>";

	if($��Ԫ״̬a == "��")
	$Text .= "<a class=OrgAdd href=\"wu_housingowner_newai.php?".base64_encode("action=add_default&�������=$�������&�������_NAME=$�������&�������_disabled=disabled&��Ԫ���=$��Ԫ���&��Ԫ���_NAME=$��Ԫ���&��Ԫ���_disabled=disabled")."\">�����ͻ�</a> ";
	 
	if($ҵ������ != ""){

		$sql = "update wu_housingresources set �������='$�������',ҵ������='$ҵ������',ҵ���绰='$ҵ���绰' where �������='$�������' and ��������='$��������' and ��¥����='$��¥����'";
        
		$db->Execute($sql);

		$Text .= "<a class=OrgAdd href=\"wu_housingresources_newai.php?".base64_encode("action=edit_default&���=$���&���_NAME=$���&���_disabled=disabled&�������=$�������&�������_NAME=$�������&�������_disabled=disabled&��������=$��������&��������_NAME=$��������&��������_disabled=disabled&��¥����=$��¥����&��¥����_NAME=$��¥����&��¥����_disabled=disabled&�������=$�������&�������_NAME=$�������&�������_disabled=disabled&ҵ������=$ҵ������&ҵ������_NAME=$ҵ������&ҵ������_disabled=disabled&ҵ���绰=$ҵ���绰&ҵ���绰_NAME=$ҵ���绰&ҵ���绰_disabled=disabled&��Ԫ��=$��Ԫ��&��Ԫ��_NAME=$��Ԫ��&��Ԫ��_disabled=disabled&¥���=$¥���&¥���_NAME=$¥���&¥���_disabled=disabled&�����=$�����&�����_NAME=$�����&�����_disabled=disabled")."\">�����������</a> ";
    }
	$Text .= "<font size=\"2\" color=\"red\">></font>";
	return $Text;

}
?>