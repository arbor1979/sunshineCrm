<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�ʲ����������ʲ�״̬�Ĳ�����Ϣ�趨��
//#########################################################
$customerlink = "�ͻ���ϵ���������ӵ���������";
function customerlink_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$�ͻ����� = strip_tags($fields['value'][$i]['�ͻ�����']);
	$�ͻ���� = strip_tags($fields['value'][$i]['�ͻ����']);

	$Text .= $�ͻ����."(";

	$Text .= "<a class=OrgAdd href=\"crm_expense_newai.php?".base64_encode("action=add_default&�ͻ�����=$�ͻ�����&�ͻ�����_NAME=�ͻ�����&�ͻ�����_disabled=disabled")."\">����</a> ";
	$Text .= "<a class=OrgAdd href=\"crm_service_newai.php?".base64_encode("action=add_default&�ͻ�����=$�ͻ�����&�ͻ�����_NAME=�ͻ�����&�ͻ�����_disabled=disabled")."\">����</a> ";
	$Text .= "<a class=OrgAdd href=\"crm_order_newai.php?".base64_encode("action=add_default&�ͻ�����=$�ͻ�����&�ͻ�����_NAME=�ͻ�����&�ͻ�����_disabled=disabled")."\">����</a> ";
	$Text .= "<a class=OrgAdd href=\"crm_contract_newai.php?".base64_encode("action=add_default&�ͻ�����=$�ͻ�����&�ͻ�����_NAME=�ͻ�����&�ͻ�����_disabled=disabled")."\">��ͬ</a> ";



	$Text .= ")";


	return $Text;
}
?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>