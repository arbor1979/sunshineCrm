<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
$status_tiaoban = "����״̬����";
function status_tiaoban_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;

	//print $i;
	//�û�������������##########################����
	//print $fieldvalue;
	$���״̬	= $fieldvalue;
	if($���״̬==0||$���״̬==''||$���״̬=='��')		return '��';

	$��Ա	= strip_tags($fields['value'][$i]['��Ա']);
	$��Ա�û���	= strip_tags($fields['value'][$i]['��Ա�û���']);

	$ԭ�ϰ�ʱ��	= strip_tags($fields['value'][$i]['ԭ�ϰ�ʱ��']);
	$ԭ���		= strip_tags($fields['value'][$i]['ԭ���']);
	$���ϰ�ʱ��	= strip_tags($fields['value'][$i]['���ϰ�ʱ��']);
	$�°��		= strip_tags($fields['value'][$i]['�°��']);
	$ѧ��		= strip_tags($fields['value'][$i]['ѧ��']);
	$���״̬	= strip_tags($fields['value'][$i]['���״̬']);

	$TEXT = '';

	$sql = "select ��� from edu_xingzheng_kaoqinmingxi where ��Ա='$��Ա' and ��Ա�û���='$��Ա�û���' and ���='$ԭ���' and ����='$ԭ�ϰ�ʱ��'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$ԭ������ = $rs->fields['���'];

	$sql = "select ��� from edu_xingzheng_kaoqinmingxi where ��Ա='$��Ա' and ��Ա�û���='$��Ա�û���' and ���='$�°��' and ����='$���ϰ�ʱ��'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$�µ����� = $rs->fields['���'];


	if($���״̬==1)										{
		if($ԭ������!="")			{
			ִ��ɾ��ĳ��ĳ�쿼����Ϣ($ѧ��,$��Ա,$��Ա�û���,$ԭ�ϰ�ʱ��,$ԭ���);;
		}
		if($�µ�����=="")			{
			ִ�в���ĳ��ĳ�쿼����Ϣ($ѧ��,$��Ա,$��Ա�û���,$���ϰ�ʱ��,$�°��);;
			$TEXT = "<font color=red title='����ɹ�'>�������ݲ���ɹ�</font><BR>";
		}
		$TEXT .= " <font color=green>����ɹ�</font>";
	}
	else	{
		$TEXT = " <font color=red>��˲�ͨ��</font>";
	}





	return $TEXT;
}
//require_once('lib.xiaoli.inc.php');
//������Ա�໥�����쳣������Ϣ();
?>