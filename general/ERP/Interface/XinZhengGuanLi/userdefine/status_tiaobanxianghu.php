<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
$status_tiaobanxianghu = "�໥����״̬����";
function status_tiaobanxianghu_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;

	//print $i;
	//�û�������������##########################����
	//print $fieldvalue;

	$ԭ��Ա			= strip_tags($fields['value'][$i]['ԭ��Ա']);
	$ԭ��Ա�û���	= strip_tags($fields['value'][$i]['ԭ��Ա�û���']);
	$����Ա			= strip_tags($fields['value'][$i]['����Ա']);
	$����Ա�û���	= strip_tags($fields['value'][$i]['����Ա�û���']);

	$ԭ�ϰ�ʱ��	= strip_tags($fields['value'][$i]['ԭ�ϰ�ʱ��']);
	$���ϰ�ʱ��	= strip_tags($fields['value'][$i]['���ϰ�ʱ��']);
	$ԭ���		= strip_tags($fields['value'][$i]['ԭ���']);
	$�°��		= strip_tags($fields['value'][$i]['�°��']);

	$ѧ��		= strip_tags($fields['value'][$i]['ѧ��']);

	$���״̬ 	= strip_tags($fields['value'][$i]['���״̬']);

	$TEXT = '';

	if($���״̬==1)			{
		ִ��ɾ��ĳ��ĳ�쿼����Ϣ($ѧ��,$ԭ��Ա,$ԭ��Ա�û���,$ԭ�ϰ�ʱ��,$ԭ���);;
		ִ�в���ĳ��ĳ�쿼����Ϣ($ѧ��,$ԭ��Ա,$ԭ��Ա�û���,$���ϰ�ʱ��,$�°��);;

		ִ��ɾ��ĳ��ĳ�쿼����Ϣ($ѧ��,$����Ա,$����Ա�û���,$���ϰ�ʱ��,$�°��);;
		ִ�в���ĳ��ĳ�쿼����Ϣ($ѧ��,$����Ա,$����Ա�û���,$ԭ�ϰ�ʱ��,$ԭ���);;

		$TEXT = "<font color=red title='�໥���ദ��ɹ�'>�໥���ദ��ɹ�</font><BR>";
	}
	else	{
		$TEXT = "<font color=green>��˲�ͨ��</font>";
	}

	return $TEXT;
}
?>