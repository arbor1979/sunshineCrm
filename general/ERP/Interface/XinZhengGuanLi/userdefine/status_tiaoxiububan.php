<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
$status_tiaoxiububan = "���ݲ���״̬����";
function status_tiaoxiububan_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;

	//print $i;
	//�û�������������##########################����
	//print $fieldvalue;
	$���״̬	= $fieldvalue;
	if($���״̬==0||$���״̬==''||$���״̬=='��')		return '��';

	$��Ա	= strip_tags($fields['value'][$i]['��Ա']);
	$��Ա�û���	= strip_tags($fields['value'][$i]['��Ա�û���']);

	$����ʱ��	= strip_tags($fields['value'][$i]['����ʱ��']);
	$����ʱ��	= strip_tags($fields['value'][$i]['����ʱ��']);
	$���ݰ��	= strip_tags($fields['value'][$i]['���ݰ��']);
	$������	= strip_tags($fields['value'][$i]['������']);

	$ѧ��	= strip_tags($fields['value'][$i]['ѧ��']);

	$�������״̬	= strip_tags($fields['value'][$i]['�������״̬']);
	$�������״̬	= strip_tags($fields['value'][$i]['�������״̬']);

	$TEXT = '';

	$sql = "select ��� from edu_xingzheng_kaoqinmingxi where ��Ա='$��Ա' and ��Ա�û���='$��Ա�û���' and ���='$���ݰ��' and ����='$����ʱ��'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$���ݱ�� = $rs->fields['���'];

	$sql = "select ��� from edu_xingzheng_kaoqinmingxi where ��Ա='$��Ա' and ��Ա�û���='$��Ա�û���' and ���='$������' and ����='$����ʱ��'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$������ = $rs->fields['���'];

	if($�������״̬==1&&$���ݱ��!='')			{
		$sql = "update edu_xingzheng_kaoqinmingxi set ����='0000-00-00' where ��Ա='$��Ա' and ��Ա�û���='$��Ա�û���' and ���='$���ݰ��' and ����='$����ʱ��'";
		//print $sql."<BR>";
		$rs = $db->Execute($sql);
		$TEXT = "<font color=red title='���ݳɹ�'>�������ݴ���ɹ�</font><BR>";
	}
	else	{
		$TEXT = "<font color=green>������������</font>";
	}

	if($�������״̬==1&&$������=='')			{
		//Ѱ������Դ
		$sql = "select ��� from edu_xingzheng_kaoqinmingxi where ��Ա='$��Ա' and ��Ա�û���='$��Ա�û���' and ���='$���ݰ��' and ����='0000-00-00'";
		$rs = $db->Execute($sql);
		$Ѱ������Դ_��� = $rs->fields['���'];
		if($Ѱ������Դ_���!="")			{
			$sql = "update edu_xingzheng_kaoqinmingxi set ����='$����ʱ��',���='$������' where ���='$Ѱ������Դ_���'";
			$db->Execute($sql);
			//print $sql."<BR>";
		}
		else	{
			ִ�в���ĳ��ĳ�쿼����Ϣ($ѧ��,$��Ա,$��Ա�û���,$����ʱ��,$������);;
		}
		$TEXT .= " <font color=red title='������Ϣ������,����ɹ�'>������Ϣ������,����ɹ�</font><BR>";
	}
	else	{
		$TEXT .= " <font color=green>������������</font>";
	}





	return $TEXT;
}
//require_once('lib.xiaoli.inc.php');
//������Ա�໥�����쳣������Ϣ();
?>