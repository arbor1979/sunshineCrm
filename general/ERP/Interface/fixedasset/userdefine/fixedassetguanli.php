<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�ʲ����������ʲ�״̬�Ĳ�����Ϣ�趨��
//#########################################################
$fixedassetguanli = "���ʲ��б���ͼ���ֹ������״̬���ʲ�";
function fixedassetguanli_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$����״̬ = strip_tags($fields['value'][$i]['����״̬']);
	$�ʲ���� = strip_tags($fields['value'][$i]['�ʲ����']);
	$�ʲ����� = strip_tags($fields['value'][$i]['�ʲ�����']);
	$�ʲ���� = strip_tags($fields['value'][$i]['�ʲ����']);
	$�ɹ���ʶ = strip_tags($fields['value'][$i]['�ɹ���ʶ']);
	$�������� = strip_tags($fields['value'][$i]['��������']);
	$Text .= $����״̬."(";

	if($����״̬!="�ʲ��ѷ���"&&$����״̬!="�ʲ��ѱ���") $Text .= "<a class=OrgAdd href=\"fixedassetout_newai.php?".base64_encode("action=add_default&�ʲ����=$�ʲ����&�ʲ����_NAME=�ʲ����&�ʲ����_disabled=disabled&�ʲ�����=$�ʲ�����&�ʲ�����_NAME=�ʲ�����&�ʲ�����_disabled=disabled&��������=$��������&��������_NAME=DEPT_NAME&��������_disabled=disabled&��׼��=".$_SESSION['LOGIN_USER_NAME']."&ff=ff")."\">����</a> ";

	if($����״̬=="�ʲ��ѷ���") $Text .= "<a class=OrgAdd href=\"fixedassettui_newai.php?".base64_encode("action=add_default&�ʲ����=$�ʲ����&�ʲ����_NAME=�ʲ����&�ʲ����_disabled=disabled&�ʲ�����=$�ʲ�����&�ʲ�����_NAME=�ʲ�����&�ʲ�����_disabled=disabled&��������=$��������&��������_NAME=DEPT_NAME&��������_disabled=disabled")."\">�黹</a> ";

	//if($����״̬=="�ʲ��ѷ���") $Text .= " <font color=green title='�黹��������������ϸ->������ϸ�н���һ��һ�Ĳ���'>�黹</font> ";

	if($����״̬!="�ʲ��ѱ���") $Text .= "<a class=OrgAdd href=\"fixedassetin_newai.php?".base64_encode("action=add_default&�ʲ����=$�ʲ����&�ʲ����_NAME=�ʲ����&�ʲ����_disabled=disabled&�ʲ�����=$�ʲ�����&�ʲ�����_NAME=�ʲ�����&�ʲ�����_disabled=disabled&��������=$��������&��������_NAME=DEPT_NAME&��������_disabled=disabled&�ɹ���ʶ=$�ɹ���ʶ&�ʲ����=$�ʲ����&��׼��=".$_SESSION['LOGIN_USER_NAME']."&ff=ff")."\">�ɹ�</a> ";

	if($����״̬!="�ʲ��ѱ���") $Text .= "<a class=OrgAdd href=\"fixedassettiaoku_newai.php?".base64_encode("action=add_default&�ʲ����=$�ʲ����&�ʲ����_NAME=�ʲ����&�ʲ����_disabled=disabled&�ʲ�����=$�ʲ�����&�ʲ�����_NAME=�ʲ�����&�ʲ�����_disabled=disabled&ԭ����������=$��������&ԭ����������_NAME=DEPT_NAME&ԭ����������_disabled=disabled&��׼��=".$_SESSION['LOGIN_USER_NAME']."&ff=ff")."\">����</a> ";

	if($����״̬!="�ʲ��ѱ���") $Text .= "<a class=OrgAdd href=\"fixedassetweixiu_newai.php?".base64_encode("action=add_default&�ʲ����=$�ʲ����&�ʲ����_NAME=�ʲ����&�ʲ����_disabled=disabled&�ʲ�����=$�ʲ�����&�ʲ�����_NAME=�ʲ�����&�ʲ�����_disabled=disabled&��������=$��������&��������_NAME=DEPT_NAME&��������_disabled=disabled&��׼��=".$_SESSION['LOGIN_USER_NAME']."&ff=ff")."\">ά��</a> ";

	if($����״̬!="�ʲ��ѱ���"&&$����״̬!="�ʲ��ѷ���") $Text .= "<a class=OrgAdd href=\"fixedassetbaofei_newai.php?".base64_encode("action=add_default&�ʲ����=$�ʲ����&�ʲ����_NAME=�ʲ����&�ʲ����_disabled=disabled&�ʲ�����=$�ʲ�����&�ʲ�����_NAME=�ʲ�����&�ʲ�����_disabled=disabled&��������=$��������&��������_NAME=DEPT_NAME&��������_disabled=disabled&����������=".$_SESSION['LOGIN_USER_NAME']."&ff=ff")."\">����</a>";

	if($����״̬!="�ʲ��ѱ���"&&$����״̬=="�ʲ��ѷ���") $Text .= " <font color=green title='���ϲ���֮ǰ,�����ȹ黹�豸,�ٽ��б���'>����</font> ";

	if($����״̬=="�ʲ��ѱ���") $Text .= "<font color=green>���ʲ��Ѿ������ڱ���״̬</font>";

	$Text .= ")";


	return $Text;
}
?>