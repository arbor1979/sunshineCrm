<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
	function LouFangShuXing_Add($fields,$i)
	{
		//*֧�����ᡢ�칫�ҡ����ҵ�����*//
		$Select = "<Select name='¥������'>";
		$Select .= "<Option Select>����</Option>";
		$Select .= "<Option>��ѧ¥</Option>";
		$Select .= "<Option>�칫��</Option>";
		$Select .= "</Select>";
		print "<Tr class=TableData><Td>¥������:</Td><Td>".$Select."</Td></Tr>";
	}
?>