<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�ʲ����������ʲ�״̬�Ĳ�����Ϣ�趨��
//#########################################################

function officeproductkucun_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$���п�� = $fields['value'][$i]['������'];
	$�칫��Ʒ��� = strip_tags($fields['value'][$i]['�칫��Ʒ���']);
	$�칫��Ʒ���� = strip_tags($fields['value'][$i]['�칫��Ʒ����']);

	$sql = "select SUM(�������) ��������ܼ� from officeproductin where �칫��Ʒ���='$�칫��Ʒ���'";
	$rs = $db->Execute($sql);
	$��������ܼ� = $rs->fields['��������ܼ�'];

	if($���п��=='') $���п�� = $��������ܼ�;


	$Text .= "(";

	if($���п��>0)	$Text .= "<a class=OrgAdd href=\"officeproductout_newai.php?".base64_encode("action=add_default&�칫��Ʒ���=$�칫��Ʒ���&�칫��Ʒ���_NAME=�칫��Ʒ���&�칫��Ʒ���_disabled=disabled&�칫��Ʒ����=$�칫��Ʒ����&�칫��Ʒ����_NAME=�칫��Ʒ����&�칫��Ʒ����_disabled=disabled&��������=����")."\">����</a> ";

	if($���п��>0)	$Text .= "<a class=OrgAdd href=\"officeproductout_newai.php?".base64_encode("action=add_default&�칫��Ʒ���=$�칫��Ʒ���&�칫��Ʒ���_NAME=�칫��Ʒ���&�칫��Ʒ���_disabled=disabled&�칫��Ʒ����=$�칫��Ʒ����&�칫��Ʒ����_NAME=�칫��Ʒ����&�칫��Ʒ����_disabled=disabled&��������=����")."\">����</a> ";

	if($���п��>0)	$Text .= "<a class=OrgAdd href=\"officeproducttui_newai.php?".base64_encode("action=add_default&�칫��Ʒ���=$�칫��Ʒ���&�칫��Ʒ���_NAME=�칫��Ʒ���&�칫��Ʒ���_disabled=disabled&�칫��Ʒ����=$�칫��Ʒ����&�칫��Ʒ����_NAME=�칫��Ʒ����&�칫��Ʒ����_disabled=disabled")."\">�黹</a> ";

	$Text .= "<a class=OrgAdd href=\"officeproductin_newai.php?".base64_encode("action=add_default&�칫��Ʒ���=$�칫��Ʒ���&�칫��Ʒ���_NAME=�칫��Ʒ���&�칫��Ʒ���_disabled=disabled&�칫��Ʒ����=$�칫��Ʒ����&�칫��Ʒ����_NAME=�칫��Ʒ����&�칫��Ʒ����_disabled=disabled")."\">���</a> ";

	if($���п��>0)	$Text .= "<a class=OrgAdd href=\"officeproducttiaoku_newai.php?".base64_encode("action=add_default&�칫��Ʒ���=$�칫��Ʒ���&�칫��Ʒ���_NAME=�칫��Ʒ���&�칫��Ʒ���_disabled=disabled&�칫��Ʒ����=$�칫��Ʒ����&�칫��Ʒ����_NAME=�칫��Ʒ����&�칫��Ʒ����_disabled=disabled")."\">����</a> ";

	if($���п��>0)	$Text .= "<a class=OrgAdd href=\"officeproductbaofei_newai.php?".base64_encode("action=add_default&�칫��Ʒ���=$�칫��Ʒ���&�칫��Ʒ���_NAME=�칫��Ʒ���&�칫��Ʒ���_disabled=disabled&�칫��Ʒ����=$�칫��Ʒ����&�칫��Ʒ����_NAME=�칫��Ʒ����&�칫��Ʒ����_disabled=disabled")."\">����</a>";

	$Text .= ")";


	return $fieldvalue;
}
function officeproductkucun_value_PRIV( $fieldvalue, $fields, $i )
{
		$SYSTEM_STOP_ROW['flow_priv'] = 1;
		$SYSTEM_STOP_ROW['delete_priv'] = 1;
		$SYSTEM_STOP_ROW['edit_priv'] = 1;
		$SYSTEM_STOP_ROW['view_priv'] = 1;
		$SYSTEM_STOP_ROW['next_priv'] = 0;
		global $db;
		$storeid = $fields['value'][$i]['��ŵص�'];
		$userid = returntablefield( "officeproductcangku", "���", $storeid, "�ֿ⸺����" );
		$useridArray=explode(",", $userid);	
		if(in_array($_SESSION['LOGIN_USER_ID'], $useridArray))
		{
			$SYSTEM_STOP_ROW['flow_priv']=0;	
			$SYSTEM_STOP_ROW['edit_priv'] = 0;
			$SYSTEM_STOP_ROW['view_priv'] = 0;
		}
		if($fields['value'][$i]['����']==0 && in_array($_SESSION['LOGIN_USER_ID'], $useridArray))
		{
			$id = returntablefield( "officeproductout", "�������", '2', "���","�Ƿ�黹",'1',"�칫��Ʒ���",$fields['value'][$i]['�칫��Ʒ���']);
			if($id=='')
				$SYSTEM_STOP_ROW['delete_priv']=0;
		}
		if($fields['value'][$i]['����']<=0)
			$SYSTEM_STOP_ROW['next_priv'] = 1;
		return $SYSTEM_STOP_ROW;
}
?>