<?php
//##########################################################
//��ʽ��_add _view _Value				˵���Ա�����ʽ
//userDefineNextElementControl_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineNextElementControl_view		������ͼ����˵��
//userDefineNextElementControl_Value	�б���ͼ˵��
//#########################################################
//�ṩ�û��Զ������ͣ��������Ӻͱ༭����ʱ
function userDefineNextElementControl_add($fields,$i)		{
	global $db;	
	global $tablename,$html_etc,$common_html;
	
	$fieldname = $fields['name'][$i];
	$fieldName1 = $fields['name'][$i+1];

	$fieldvalue = $fields['value'][$fieldname];
	$fieldValue1 = $fields['value'][$fieldName1];

	$fieldHtml  = $html_etc[$tablename][$fieldname];
	$fieldHtml1 = $html_etc[$tablename][$fieldName1];

	
	print "<TR>\n";
    print "<TD class=TableContent noWrap width=20%>".$fieldHtml.":</TD>\n";
    print "<TD class=TableData colspan=$colspan>";
	if($fieldvalue==1||$fieldvalue=="on")	{
		print "<label>";
		print "<input type=\"radio\" class=Smallradio name=$fieldname value=\"1\" checked onClick=\"javasrcipt:document.form1.$fieldName1.disabled=false;\">".$common_html['common_html']['yes']."\n";
		print "<input type=\"radio\" name=$fieldname value=\"0\" onClick=\"javasrcipt:document.form1.$fieldName1.disabled=true;\">".$common_html['common_html']['no']."\n";
		print "</label>";

	}else	{
		print "<label>";
		print "<input type=\"radio\" class=Smallradio name=$fieldname value=\"1\" onClick=\"javasrcipt:document.form1.$fieldName1.disabled=false;\">".$common_html['common_html']['yes']."\n";
		print "<input type=\"radio\" name=$fieldname  checked  value=\"0\" onClick=\"javasrcipt:document.form1.$fieldName1.disabled=true;\">".$common_html['common_html']['no']."\n";
		print "</label>";
	}
	print $addtext;
	print "</TD>\n";
	print "</TR>\n";
}

//�ṩ�û��Զ������ͣ����ڲ�������ʱ
function userDefineNextElementControl_view($fields,$i)		{
	global $db;	
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldName1 = $fields['name'][$i+1];

	$fieldvalue = $fields['value'][$fieldname];
	$fieldValue1 = $fields['value'][$fieldName1];

	$fieldHtml  = $html_etc[$tablename][$fieldname];
	$fieldHtml1 = $html_etc[$tablename][$fieldName1];

	
	$fieldHtml_ALL  = $html_etc[$tablename]['inforstatusmanagement'];
	
	print "<TR>\n";
    print "<TD class=TableContent noWrap width=20%>".$fieldHtml_ALL.":</TD>\n";
    print "<TD class=TableData noWrap colspan=\"$colspan\">\n";

	if($fieldvalue=="on")	$checked = "checked";
	else	$checked = "";
	$TableInfor['Content'][$fieldHtml]  = "		<input type=checkbox name=$fieldname disabled $checked>��";

	if($fieldValue1=="on")	$checked = "checked";
	else	$checked = "";
	$TableInfor['Content'][$fieldHtml1] = "		<input type=checkbox name=$fieldName1 disabled $checked>��";

	$TableInfor['cols'][$fieldHtml]  = "1";
	$TableInfor['cols'][$fieldHtml1] = "1";

	TableInforOutPut($TableInfor,"40%");
	print "</TD>\n";
	print "</TR>\n";
}


function userDefineNextElementControl_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	return $fieldvalue;
}
?>