
<?php
function tousuchuli_Value($fieldvalue,$fields,$i)		{

    global $db;
	global $tablename,$html_etc,$common_html;
	$���       = strip_tags($fields['value'][$i]['���']);
	$Ͷ�����   = strip_tags($fields['value'][$i]['Ͷ�����']);
	$Ͷ�����   = strip_tags($fields['value'][$i]['Ͷ�����']);
    $����       = strip_tags($fields['value'][$i]['����']);
	$��Ԫ���   = strip_tags($fields['value'][$i]['��Ԫ���']);
	$Ͷ����     = strip_tags($fields['value'][$i]['Ͷ����']);
	$Ͷ���˵绰 = strip_tags($fields['value'][$i]['Ͷ���˵绰']);
	$Ͷ��ʱ��   = strip_tags($fields['value'][$i]['Ͷ��ʱ��']);
	$Ͷ������   = strip_tags($fields['value'][$i]['Ͷ������']);
	$��ע       = strip_tags($fields['value'][$i]['��ע']);
	$�Ƿ�����   = strip_tags($fields['value'][$i]['�Ƿ�����']);
	
    $�Ƿ���  = "��";
	$Text = "";
    if($������ == ""){

	$Text .= "<font size=\"2\" color=\"red\"><</font>";
	$Text .= "<a class=OrgAdd href=\"wu2_usercomplaints_newai.php?".base64_encode("action=add_default&���=$���&���_NAME=$���&���_disabled=disabled&Ͷ�����=$Ͷ�����&Ͷ�����_NAME=$Ͷ�����&Ͷ�����_disabled=disabled&Ͷ�����=$Ͷ�����&Ͷ�����_NAME=$Ͷ�����&Ͷ�����_disabled=disabled&����=$����&����_NAME=$����&����_disabled=disabled&��Ԫ���=$��Ԫ���&��Ԫ���_NAME=$��Ԫ���&��Ԫ���_disabled=disabled&Ͷ����=$Ͷ����&Ͷ����_NAME=$Ͷ����&Ͷ����_disabled=disabled&Ͷ���˵绰=$Ͷ���˵绰&Ͷ���˵绰_NAME=$Ͷ���˵绰&Ͷ���˵绰_disabled=disabled&Ͷ��ʱ��=$Ͷ��ʱ��&Ͷ��ʱ��_NAME=$Ͷ��ʱ��&Ͷ��ʱ��_disabled=disabled&Ͷ������=$Ͷ������&Ͷ������_NAME=$Ͷ������&Ͷ������_disabled=disabled&�Ƿ�����=$�Ƿ�����&�Ƿ�����_NAME=$�Ƿ�����&�Ƿ�����_disabled=disabled&�Ƿ���=$�Ƿ���&�Ƿ���_NAME=$�Ƿ���&�Ƿ���_disabled=disabled&��ע=$��ע&��ע_NAME=$��ע&��ע_disabled=disabled")."\">����������</a> ";

    $Text .= "<font size=\"2\" color=\"red\">></font>";
    
	}else{	
    $Text .= "<font size=\"2\" color=\"red\">�Ѿ�����</font>";
	}	
	return $Text;
}
?>