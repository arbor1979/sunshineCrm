<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
$status_qingjia = "���״̬����";
function status_qingjia_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;

	//print $i;
	//�û�������������##########################����
	//print $fieldvalue;
	$���״̬	= $fieldvalue;
	if($���״̬==0||$���״̬==''||$���״̬=='��')		return '��';

	$��Ա	= strip_tags($fields['value'][$i]['��Ա']);
	$��Ա�û���	= strip_tags($fields['value'][$i]['��Ա�û���']);

	$ʱ��		= strip_tags($fields['value'][$i]['ʱ��']);
	$���		= strip_tags($fields['value'][$i]['���']);
	$ѧ��		= strip_tags($fields['value'][$i]['ѧ��']);
	$���״̬	= strip_tags($fields['value'][$i]['���״̬']);

	$TEXT = '';

	$sql = "select ��� from edu_xingzheng_kaoqinmingxi where ��Ա='$��Ա' and ��Ա�û���='$��Ա�û���' and ���='$���' and ����='$ʱ��'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$��ٱ�� = $rs->fields['���'];


	if($���״̬==1)					{
		if($��ٱ��=='')			{
			ִ�в���ĳ��ĳ�쿼����Ϣ($ѧ��,$��Ա,$��Ա�û���,$ʱ��,$���);;
			$TEXT = "<font color=red title='��ٳɹ�'>������ݲ���ɹ�</font><BR>";
		}

		$sql = "update  edu_xingzheng_kaoqinmingxi
			set
			�ϰ�ʵ��ˢ��='������',
			�ϰ࿼��״̬='������',
			�°�ʵ��ˢ��='������',
			�°࿼��״̬='������'
			where
			��Ա�û���='$��Ա�û���'
			and ���='$���'
			and ����='$ʱ��'
			and ѧ��='$ѧ��'";
		$db->Execute($sql);
		$TEXT .= " <font color=green>��ٳɹ�</font>";
	}
	else	{
		$TEXT = " <font color=red>��˲�ͨ��</font>";
	}





	return $TEXT;
}
//require_once('lib.xiaoli.inc.php');
//������Ա�໥�����쳣������Ϣ();
?>