<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
	function BaoXiuXiangMu_Add($fields,$i)
	{
		//*֧�����ᡢ�칫�ҡ����ҵ�����*//
		$Select = "<Select name='������Ŀ'>";
		$Select .= "<Option Select>ˮ</Option>";
		$Select .= "<Option>��</Option>";
		$Select .= "<Option>�豸</Option>";
		$Select .= "<Option>����</Option>";
		$Select .= "</Select>";
		print "<Tr class=TableData><Td>������Ŀ:</Td><Td>".$Select."</Td></Tr>";
	}
?>