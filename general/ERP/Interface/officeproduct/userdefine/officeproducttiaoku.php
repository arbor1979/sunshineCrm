<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
$officeproducttiaoku = "���ݲֿ���Ϣͳ�ư칫��Ʒ������";
//#########################################################
function officeproducttiaoku_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$��ע = $fields['value'][$i]['��ע'];
	$�ֿ����� = $fields['value'][$i]['�ֿ�����'];

	$sql = "select SUM(�������) AS ��� from officeproductin where ���ֿ�='$�ֿ�����'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$��� = (int)$rs_a[0]['���'];

	$sql = "select SUM(��������) AS ���� from officeproductout where ����ֿ�='$�ֿ�����'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$���� = (int)$rs_a[0]['����'];

	$sql = "select SUM(�˿�����) AS �˿� from officeproducttui where �˿�ֿ�='$�ֿ�����'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$�˿� = (int)$rs_a[0]['�˿�'];

	$sql = "select SUM(��������) AS ���� from officeproducttui where �����ֿ�='$�ֿ�����'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$���� = (int)$rs_a[0]['����'];
	
	$��� = $���+$�˿�-$����-$����;
	
	$Text = "<font color=red>���:$���</font>	\t\r<font color=green>���:$��� \t\r����:$���� \t\r�˿�:$�˿�</font> $��ע";
	return $Text;
}

function officeproducttiaoku_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	global $_SESSION;
	global $_GET;	
	$FieldName = $fields['name'][$i];
	$Html_etc = $html_etc[$tablename][$FieldName];
	$�칫��Ʒ���� = $_GET['�칫��Ʒ����'];

	$sql = "select SUM(�������) AS ���,���ֿ�,�칫��Ʒ���� from officeproductin group by ���ֿ�,�칫��Ʒ���� having �칫��Ʒ����='$�칫��Ʒ����'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$���ֿ� = $rs_a[$i]['���ֿ�'];
		$NewArray[$���ֿ�] = $rs_a[$i]['���'];
	}
	
	$sql = "select SUM(�˿�����) AS �˿�,�˿�ֿ�,�칫��Ʒ���� from officeproducttui group by �˿�ֿ�,�칫��Ʒ���� having �칫��Ʒ����='$�칫��Ʒ����'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$�˿� = (int)$rs_a[0]['�˿�'];
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$�˿�ֿ� = $rs_a[$i]['�˿�ֿ�'];
		$NewArray[$�˿�ֿ�] += $rs_a[$i]['�˿�'];
	}

	$sql = "select SUM(��������) AS ����,����ֿ�,�칫��Ʒ���� from officeproductout group by ����ֿ�,�칫��Ʒ���� having �칫��Ʒ����='$�칫��Ʒ����'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$���� = (int)$rs_a[0]['����'];
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$����ֿ� = $rs_a[$i]['����ֿ�'];
		$NewArray[$����ֿ�] -= $rs_a[$i]['����'];
	}

	//���ϲֿ�
	$sql = "select SUM(��������) AS ����,�����ֿ�,�칫��Ʒ���� from officeproductbaofei group by �����ֿ�,�칫��Ʒ���� having �칫��Ʒ����='$�칫��Ʒ����'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$���� = (int)$rs_a[0]['����'];
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$�����ֿ� = $rs_a[$i]['�����ֿ�'];
		$NewArray[$�����ֿ�] -= $rs_a[$i]['����'];
	}

	//print_R($NewArray);

	$sql = "select �ֿ����� from officeproductcangku";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();

    print "<TR>";
	print "<TD class=TableData noWrap>$Html_etc:</TD>\n";
	print "<TD class=TableData noWrap colspan=\"2\">";
	for($i=0;$i<sizeof($rs_a);$i++)		{
		if($i==0) $Checked = "Checked"; else $Checked = '';
		$�ֿ����� = $rs_a[$i]['�ֿ�����'];
		print "<input type=\"radio\" name=\"$FieldName\" title='' value=\"$�ֿ�����\" $Checked>".$�ֿ�����."[".(int)$NewArray[$�ֿ�����]."��]</label>";
	}
	print "</TD></TR>\n";

	
}
?>