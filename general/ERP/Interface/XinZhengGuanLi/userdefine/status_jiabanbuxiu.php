<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
$status_jiabanbuxiu = "�Ӱಹ��״̬����";
function status_jiabanbuxiu_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;

	//print $i;
	//�û�������������##########################����
	//print $fieldvalue;
	$���״̬	= $fieldvalue;
	if($���״̬==0||$���״̬==''||$���״̬=='��')		return '��';

	$��Ա	= strip_tags($fields['value'][$i]['��Ա']);
	$��Ա�û���	= strip_tags($fields['value'][$i]['��Ա�û���']);

	$�Ӱ�ʱ��	= strip_tags($fields['value'][$i]['�Ӱ�ʱ��']);
	$����ʱ��	= strip_tags($fields['value'][$i]['����ʱ��']);
	$�Ӱ���	= strip_tags($fields['value'][$i]['�Ӱ���']);
	$���ݰ��	= strip_tags($fields['value'][$i]['���ݰ��']);

	$ѧ��	= strip_tags($fields['value'][$i]['ѧ��']);

	$�Ӱ����״̬	= strip_tags($fields['value'][$i]['�Ӱ����״̬']);
	$�������״̬	= strip_tags($fields['value'][$i]['�������״̬']);

	$TEXT = '';

	$sql = "select ��� from edu_xingzheng_kaoqinmingxi where ��Ա='$��Ա' and ��Ա�û���='$��Ա�û���' and ���='$�Ӱ���' and ����='$�Ӱ�ʱ��'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$�Ӱ��� = $rs->fields['���'];

	$sql = "select ��� from edu_xingzheng_kaoqinmingxi where ��Ա='$��Ա' and ��Ա�û���='$��Ա�û���' and ���='$���ݰ��' and ����='$����ʱ��'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$���ݱ�� = $rs->fields['���'];

	if($�Ӱ����״̬==1&&$�Ӱ���=='')			{
		ִ�в���ĳ��ĳ�쿼����Ϣ($ѧ��,$��Ա,$��Ա�û���,$�Ӱ�ʱ��,$�Ӱ���);;
		$TEXT = "<font color=red title='ԭʼ�Ӱ����ݲ�����,����ɹ�'>ԭʼ�Ӱ����ݲ�����,����ɹ�</font><BR>";
	}
	else	{
		$TEXT = "<font color=green>�Ӱ���������</font>";
	}

	if($�������״̬==1&&$���ݱ��!='')			{
		ִ��ɾ��ĳ��ĳ�쿼����Ϣ($ѧ��,$��Ա,$��Ա�û���,$����ʱ��,$���ݰ��);;
		$TEXT .= " <font color=red title='����ʱ����ڹ�����Ϣ,ɾ���ɹ�'>����ʱ����ڹ�����Ϣ,ɾ���ɹ�</font><BR>";
	}
	else	{
		$TEXT .= " <font color=green>������������</font>";
	}





	return $TEXT;
}
//require_once('lib.xiaoli.inc.php');
//������Ա�໥�����쳣������Ϣ();
?>