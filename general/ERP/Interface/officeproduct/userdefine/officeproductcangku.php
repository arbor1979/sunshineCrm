<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�ʲ����������ʲ�״̬�Ĳ�����Ϣ�趨��
//#########################################################

function officeproductcangku_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$sql="select * from officeproductcangku";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	$storelist=array();
	foreach ($rs_a as $row)
	{
		$userArray=explode(",",$row['�ֿ⸺����']);
		if(in_array($_SESSION['LOGIN_USER_ID'], $userArray))
			array_push($storelist, $row);
	}
	$FieldName = $fields['name'][$i];
	$showtext = $html_etc[$tablename][$FieldName];
	$notnull=trim($fields['null'][$i]['inputtype']);
	$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"".$fields['other']['inputcols']."\">\n";
	print "<select name=\"$FieldName\" value=\"\">\n";
	foreach ($storelist as $row)
	{
		if($row!='')
			print "<option value='".$row['���']."'>".$row['�ֿ�����']."</option>";
	}
	print "</select>&nbsp;$notnulltext";
	print "</TD></TR>\n";
}
?>