<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�û��Զ������ͣ��������Ӻͱ༭����ʱ

function shenherenSelect_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc;
	$memo = "���뽫�ύ������˷�����Ч";
	$storeid = $_GET['����ֿ�'];
	$userid = returntablefield( "officeproductcangku", "���", $storeid, "�ֿ⸺����" );
	$useridArray=explode(",", $userid);	
	$FieldName = $fields['name'][$i];
	$showtext = $html_etc[$tablename][$FieldName];
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"".$fields['other']['inputcols']."\">\n";
	print "<select name=\"$FieldName\" value=\"\">\n";
	foreach ($useridArray as $row)
	{
		if($row!='')
			print "<option value='$row'>".returntablefield("user", "user_id", $row, "user_name")."</option>";
	}
	print "</select>&nbsp;$memo";
	print "</TD></TR>\n";
}

?>