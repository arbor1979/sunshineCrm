<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�û��Զ������ͣ��������Ӻͱ༭����ʱ
function jumpuserinfor2_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldValue = $fields['value'][$fieldname];
	$showtext  = $html_etc[$tablename][$fieldname];
	$fieldnameID = $fieldname."_ID";
	$fieldValueName =  $fields['value']['��ʦ�û���'];
	if($fieldValueName=='')	{
		$fieldValueName = returntablefield("user","USER_NAME",$fieldValue,"USER_ID");
	}
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"".$fields['other']['inputcols']."\">\n";
	print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValue\">\n";
    print "<input type=\"text\" name=\"$fieldname\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"20\">\n";
	print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectTeacherSingle('','$fieldnameID', '$fieldname')\">ѡ��</a>\n";
	print $addtext = FilterFieldAddText($addtext,$fieldname);
	print "</TD></TR>\n";
}


?>