<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�ʲ����������ʲ�״̬�Ĳ�����Ϣ�趨��
//#########################################################
$officeproductgroup = "���ڰ칫��Ʒ���ಿ������,֧�������Ƹ���Ŀ¼";
function officeproductgroup_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$���п�� = $fields['value'][$i]['������'];
	$�칫��Ʒ��� = $fields['value'][$i]['�칫��Ʒ���'];
	$�칫��Ʒ���� = $fields['value'][$i]['�칫��Ʒ����'];
	
	$sql = "select SUM(�������) ��������ܼ� from officeproductin where �칫��Ʒ���='$�칫��Ʒ���'";
	$rs = $db->Execute($sql);
	$��������ܼ� = $rs->fields['��������ܼ�'];

	

	return $Text;
}


function officeproductgroup_Add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$�ϼ�����		= $fields['value']['�ϼ�����'];
	$����CX		= $fields['value']['����'];
	
	$sql = "select ���� from officeproductgroup where �ϼ�����=''";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	
	$selectText .= "<select name=�ϼ����� class=SmallSelect>";
	if($�ϼ�����=="")	$selectText .= "<option value=\"\" selected>һ������</option>";
	else				$selectText .= "<option value=\"\" >һ������</option>";
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$���� = $rs_a[$i]['����'];
		if($�ϼ�����==$����)	$selected = "selected";
		else					$selected = "";
		if($����CX!=$����)  $selectText .= "<option value=\"$����\" $selected>$����</option>";
	}
	$selectText .= "</select>";
	
	print "<tr class=TableData><td>ѡ���ϼ�����</td><td>$selectText</td></tr>";
	

}
?>