<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$jumpclassroominfor = "选择所有客户弹出框";
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
	print "<a href='#' onClick=\"SelectAllInforSingle('../../Enginee/Module/kehu_select_multi/index.php','','$fieldnameID', '$fieldname')\"><u>客户联系人</u></a>\n";
    print "&nbsp;<a href='#' onClick=\"SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','$fieldnameID', '$fieldname')\"><u>供应商联系人</u></a>\n";
	print "</TD></TR>\n";
	//SelectUserSingle
}

?>