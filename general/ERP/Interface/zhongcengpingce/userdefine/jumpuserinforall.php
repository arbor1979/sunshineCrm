<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�û��Զ������ͣ��������Ӻͱ༭����ʱ
function jumpuserinforall_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldValue = $fields['value'][$fieldname];
	$showtext  = $html_etc[$tablename][$fieldname];
	$fieldnameID = $fieldname."_ID";

	$fieldValueArray = explode(',',$fieldValue);
	for($i=0;$i<sizeof($fieldValueArray);$i++)		{
		$fieldValueID .= returntablefield("user","USER_NAME",$fieldValueArray[$i],"USER_ID").",";
	}
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"".$fields['other']['inputcols']."\">\n";
	print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValueID\">\n";

	print "<textarea cols=40 name=\"$fieldname\" rows=6 class=\"BigStatic\" wrap=\"yes\" readonly>$fieldValue</textarea>
        &nbsp;<input type=\"button\" value=\"�� ��\" class=\"SmallButton\" onClick=\"SelectUser('','$fieldnameID','$fieldname')\" title=\"ѡ����Ա\" name=\"button\">
        &nbsp;<input type=\"button\" value=\"�� ��\" class=\"SmallButton\" onClick=\"ClearUser('$fieldnameID','$fieldname')\" title=\"�����Ա\" name=\"button\">\n";
	print $addtext = FilterFieldAddText($addtext,$fieldname);
	print "</TD></TR>\n";
}

?>