
<?php
function fuwupingjia_Value($fieldvalue,$fields,$i)		{

    global $db;
	global $tablename,$html_etc,$common_html;
	$���       = strip_tags($fields['value'][$i]['���']);
	$¥����ַ   = strip_tags($fields['value'][$i]['¥����ַ']);
	$������Ŀ   = strip_tags($fields['value'][$i]['������Ŀ']);
    $������     = strip_tags($fields['value'][$i]['������']);
	$ҵ������   = strip_tags($fields['value'][$i]['ҵ������']);
    $ά����Ա   = strip_tags($fields['value'][$i]['ά����Ա']);
	$�Ƿ�����   = strip_tags($fields['value'][$i]['�Ƿ�����']);
	$ά��״̬   = strip_tags($fields['value'][$i]['ά��״̬']);
	$�Ƿ�����   = strip_tags($fields['value'][$i]['�Ƿ�����']);

	$Text = "";
    if($ά��״̬ == "��" and $�Ƿ����� == ""){

	$Text .= "<font size=\"2\" color=\"red\"><</font>";
	$Text .= "<a class=OrgAdd href=\"my6_wu_maintenancemanagement_newai.php?".base64_encode("action=edit_default&���=$���&���_NAME=$���&���_disabled=disabled&¥����ַ=$¥����ַ&¥����ַ_NAME=$¥����ַ&¥����ַ_disabled=disabled&������Ŀ=$������Ŀ&������Ŀ_NAME=$������Ŀ&������Ŀ_disabled=disabled&������=$������&������_NAME=$������&������_disabled=disabled&ҵ������=$ҵ������&ҵ������_NAME=$ҵ������&ҵ������_disabled=disabled&ά����Ա=$ά����Ա&ά����Ա_NAME=$ά����Ա&ά����Ա_disabled=disabled&�Ƿ�����=$�Ƿ�����&�Ƿ�����_NAME=$�Ƿ�����&�Ƿ�����_disabled=disabled&ά��״̬=$ά��״̬&ά��״̬_NAME=$ά��״̬&ά��״̬_disabled=disabled")."\">�Ƿ�����</a> ";
    $Text .= "<font size=\"2\" color=\"red\">></font>";  
	}else if($ά��״̬ == "��" and $�Ƿ����� == ""){
    $Text .= "<font size=\"2\" color=\"green\">��������</font>";
	}if($ά��״̬ == "��" and $�Ƿ����� == "��"){
    $Text .= "<font size=\"2\" color=\"red\">�Ѿ����۹�</font>";
	}		
	return $Text;
}
?>