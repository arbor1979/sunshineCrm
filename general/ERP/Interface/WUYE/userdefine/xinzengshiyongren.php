<?php

function xinzengshiyongren_Value($fieldvalue,$fields,$i)		{
    //
    global $db;
	global $tablename,$html_etc,$common_html;
	$������� = strip_tags($fields['value'][$i]['�������']);
	$��Ԫ��� = strip_tags($fields['value'][$i]['��Ԫ���']);
	$ҵ������ = strip_tags($fields['value'][$i]['ҵ������']);

    $sql = "select * from wu_housinguser where ��Ԫ���='$��Ԫ���'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();

	if(sizeof($rs_a)==0){
	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\">$ҵ������&nbsp;</font><";
	$Text .= "<a class=OrgAdd href=\"wu_housinguser_newai.php?".base64_encode("action=add_default&�������=$�������&�������_NAME=$�������&�������_disabled=disabled&��Ԫ���=$��Ԫ���&��Ԫ���_NAME=$��Ԫ���&��Ԫ���_disabled=disabled&ҵ������=$ҵ������&ҵ������_NAME=$ҵ������&ҵ������_disabled=disabled")."\">����ʹ����</a> ";
	$Text .= ">";
    }else{
	$Text .= "<font size=\"2\" color=\"red\">$ҵ������</font>";
	}
	return $Text;
}
?>