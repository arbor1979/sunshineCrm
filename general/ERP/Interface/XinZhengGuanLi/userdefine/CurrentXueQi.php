<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
$CurrentXueQi = "�ṩ��ǰѧ�ڵ�INPUT�����";
function CurrentXueQi_Add($fields,$i)
{
		global $db;
		$sql = "select ѧ������ from edu_xueqiexec where ��ǰѧ��='1'";
		$rs = $db -> Execute($sql);
		$�ֶ����� = $fields['name'][$i];

		$��ǰѧ�� = $rs -> fields['ѧ������'];
		print "<Tr class=TableData><Td>��ǰѧ��:</Td><Td colspan=2><Input class='SmallStatic' size=20 readonly='readonly' Name='$�ֶ�����' value=".$��ǰѧ��."></Td></Tr>";
}

?>