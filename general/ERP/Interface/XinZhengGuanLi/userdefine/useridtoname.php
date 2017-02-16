<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$useridtoname = "批量把用户ID转换为NAME";
//#########################################################
function useridtoname_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$组员名称 = $fieldvalue;
	$USER_NAME_TEXT = '';
	$组员名称Array = explode(',',$组员名称);
	for($i=0;$i<sizeof($组员名称Array);$i++)		{
		if($组员名称Array[$i]!="")
			$USER_NAME_TEXT	.= returntablefield("user","USER_ID",$组员名称Array[$i],"USER_NAME").",";
	}
	return substr_cut($USER_NAME_TEXT,120);
}



function useridtoname_view($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldValue = $fields['value'][$fieldname];
	$showtext  = $html_etc[$tablename][$fieldname];

	$组员名称 = $fieldValue;
	$USER_NAME_TEXT = '';
	$组员名称Array = explode(',',$组员名称);
	for($i=0;$i<sizeof($组员名称Array);$i++)		{
		if($组员名称Array[$i]!="")
			$USER_NAME_TEXT	.= returntablefield("user","USER_ID",$组员名称Array[$i],"USER_NAME").",";
	}

	print "<TR>";
	print "<TD class=TableContent noWrap>".$showtext.":</TD>\n";
	print "<TD class=TableData colspan=\"2\">\n";
	print "";
	print $USER_NAME_TEXT;
	print "</TD></TR>\n";

}


?>