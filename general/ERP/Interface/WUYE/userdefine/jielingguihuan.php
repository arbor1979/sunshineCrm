<?php
function jielingguihuan_Value($fieldvalue,$fields,$i)		{
    //
    global $db;
	global $tablename,$html_etc,$common_html;
	$���ʱ�� = strip_tags($fields['value'][$i]['���ʱ��']);
	$��Ʒ���� = strip_tags($fields['value'][$i]['��Ʒ����']);
	$�������� = strip_tags($fields['value'][$i]['��������']);
	$���� = strip_tags($fields['value'][$i]['����']);
	$���� = strip_tags($fields['value'][$i]['����']);
    
	//$sql = "delete from wu_materialsequipment where ���ʱ��='$���ʱ��' and ��Ʒ����='$��Ʒ����' and ��������='$��������' and ���������='����'";
	//$db->Execute($sql);

	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\"><</font>";
	$Text .= "<a class=OrgAdd href=\"wu_materialsequipmenth_newai.php?"."action=add_default&���ʱ��=$���ʱ��&���ʱ��_NAME=$���ʱ��&���ʱ��_disabled=disabled&��Ʒ����=$��Ʒ����&��Ʒ����_NAME=$��Ʒ����&��Ʒ����_disabled=disabled&��������=$��������&��������_NAME=$��������&��������_disabled=disabled&����=$����&����_NAME=$����&����_disabled=disabled&����=$����&����_NAME=$����&����_disabled=disabled"."\">�黹</a>";

	$Text .= "<font size=\"2\" color=\"red\">></font>";
	return $Text;

}
?>