<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
$jumpclassroominfor = "ѡ�����пͻ�������";
function jumpkehuinfor_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$notnull=trim($fields['null'][$i]['inputtype']);
	$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
	$fieldname = $fields['name'][$i];
	$fieldValue = $fields['value'][$fieldname];
	$showtext  = $html_etc[$tablename][$fieldname];
	$fieldnameID = $fieldname."_ID";
	$customername=returntablefield("customer", "rowid", $fields['value'][$fieldname], "supplyname");
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"".$fields['other']['inputcols']."\">\n";
	print "<input type='hidden' name='$fieldname' value='".$fields['value'][$fieldname]."' >";
	print "<textarea name='$fieldnameID' class=\"SmallInput\" rows=".$fields['textarea'][$fieldname]["rows"]." cols=".$fields['textarea'][$fieldname]["cols"].">$customername</textarea>";
	print "&nbsp;".$notnulltext."<br>";    
	print "<a href='#' onClick=\"SelectAllInforSingle('../../Enginee/Module/kehu_select_multi/index.php','','$fieldnameID', '$fieldname')\"><u>�ͻ���ϵ��</u></a>\n";
    print "&nbsp;<a href='#' onClick=\"SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','$fieldnameID', '$fieldname')\"><u>��Ӧ����ϵ��</u></a>\n";
	print "</TD></TR>\n";
	//SelectUserSingle
}

?>