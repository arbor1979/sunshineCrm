<?php
/*
�����������ҳ��Ĺ������ģ��
*/

function fangjiancaozuo_Value($fieldvalue,$fields,$i)		{

     
	global $db;
	global $tablename,$html_etc,$common_html;
	$��������  = strip_tags($fields['value'][$i]['��������']);
	$��¥����  = strip_tags($fields['value'][$i]['��¥����']);

	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\">�ѽ���<</font>";
	$Text .= "<a class=OrgAdd href=\"wu1_housingresources_newai.php?".base64_encode("action=add_default&��������=$��������&��������_NAME=$��������&��������_disabled=disabled&��¥����=$��¥����&��¥����_NAME=$��¥����&��¥����_disabled=disabled")."\">�������</a> ";
	$Text .= "<font size=\"2\" color=\"red\">></font>";
	return $Text;
}
?>