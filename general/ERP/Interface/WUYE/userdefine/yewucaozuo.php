
<?php
function yewucaozuo_Value($fieldvalue,$fields,$i)		{
    //
    global $db;
	global $tablename,$html_etc,$common_html;
	$¥����ַ = strip_tags($fields['value'][$i]['�������']);
	$ҵ������ = strip_tags($fields['value'][$i]['ҵ������']);
    $��ϵ��ʽ = strip_tags($fields['value'][$i]['ҵ���绰']);
	$������� = strip_tags($fields['value'][$i]['�������']);
	$ʹ����� = strip_tags($fields['value'][$i]['�������']);
	$��̯��� = strip_tags($fields['value'][$i]['��̯���']);
	$��Ԫ��; = strip_tags($fields['value'][$i]['��Ԫ��;']);
	$��Ԫ�˿� = strip_tags($fields['value'][$i]['����']);

	$��ǰ���·� = date("Y-m",mktime(1,1,1,date("m")-1,date("d"),date("Y")));
    //$ǰһ����   = date("Y-m",mktime(1,1,1,date("m")-2,date("d"),date("Y")));

	//echo $��ǰ���·�;
    
	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\"><</font>";
	$Text .= "<a class=OrgAdd href=\" wu_wpgfeesdetails_newai.php?".base64_encode("action=add_default&��Ԫ���=$¥����ַ&��Ԫ���_NAME=$¥����ַ&��Ԫ���_disabled=disabled&ҵ������=$ҵ������&ҵ������_NAME=$ҵ������&ҵ������_disabled=disabled&��ϵ��ʽ=$��ϵ��ʽ&��ϵ��ʽ_NAME=$��ϵ��ʽ&��ϵ��ʽ_disabled=disabled&�������·�=$��ǰ���·�&�������·�_NAME=$��ǰ���·�&�������·�_disabled=disabled&�������=$�������&�������_NAME=$�������&�������_disabled=disabled&ʹ�����=$ʹ�����&ʹ�����_NAME=$ʹ�����&ʹ�����_disabled=disabled&��Ԫ��;=$��Ԫ��;&��Ԫ��;_NAME=$��Ԫ��;&��Ԫ��;_disabled=disabled&��Ԫ�˿�=$��Ԫ�˿�&��Ԫ�˿�_NAME=$��Ԫ�˿�&��Ԫ�˿�_disabled=disabled")."\">ˮ�����ѹ���</a> ";


	$Text .= "<a class=OrgAdd href=\" wu1_wpgfeesdetails_newai.php?".base64_encode("action=add_default&��Ԫ���=$¥����ַ&��Ԫ���_NAME=$¥����ַ&��Ԫ���_disabled=disabled&ҵ������=$ҵ������&ҵ������_NAME=$ҵ������&ҵ������_disabled=disabled&��ϵ��ʽ=$��ϵ��ʽ&��ϵ��ʽ_NAME=$��ϵ��ʽ&��ϵ��ʽ_disabled=disabled&�������·�=$��ǰ���·�&�������·�_NAME=$��ǰ���·�&�������·�_disabled=disabled&�������=$�������&�������_NAME=$�������&�������_disabled=disabled&ʹ�����=$ʹ�����&ʹ�����_NAME=$ʹ�����&ʹ�����_disabled=disabled&��̯���=$��̯���&��̯���_NAME=$��̯���&��̯���_disabled=disabled&��Ԫ��;=$��Ԫ��;&��Ԫ��;_NAME=$��Ԫ��;&��Ԫ��;_disabled=disabled&��Ԫ�˿�=$��Ԫ�˿�&��Ԫ�˿�_NAME=$��Ԫ�˿�&��Ԫ�˿�_disabled=disabled")."\">��ҵ�ѹ���</a> ";


	$Text .= "<a class=OrgAdd href=\"my1_wu_maintenancemanagement_newai.php?".base64_encode("action=add_default&¥����ַ=$¥����ַ&¥����ַ_NAME=$¥����ַ&¥����ַ_disabled=disabled&ҵ������=$ҵ������&ҵ������_NAME=$ҵ������&ҵ������_disabled=disabled&��ϵ��ʽ=$��ϵ��ʽ&��ϵ��ʽ_NAME=$��ϵ��ʽ&��ϵ��ʽ_disabled=disabled")."\">���޹���</a> ";

    $Text .= "<a class=OrgAdd href=\"wu_usercomplaints_newai.php?".base64_encode("action=add_default&��Ԫ���=$¥����ַ&��Ԫ���_NAME=$¥����ַ&��Ԫ���_disabled=disabled&Ͷ����=$ҵ������&Ͷ����_NAME=$ҵ������&Ͷ����_disabled=disabled&Ͷ���˵绰=$��ϵ��ʽ&Ͷ���˵绰_NAME=$��ϵ��ʽ&Ͷ���˵绰_disabled=disabled")."\">Ͷ�߹���</a> ";

    
    $sql = "select * from wuye_wuyetingchechangguanli where �������='$¥����ַ' and ҵ��='$ҵ������'";
	$result = $db->Execute($sql);
	$rs_a = $result->GetArray();
	$���     = $rs_a[0]['���'];
	$ʹ��״̬ = $rs_a[0]['��λ״̬'];

	$ͣ����   = $rs_a[0]['ͣ����'];
	$ͣ��λ   = $rs_a[0]['ͣ��λ'];
	$�������� = $rs_a[0]['��������'];
	$����     = $rs_a[0]['����'];
	$������� = $rs_a[0]['�������'];
	$������ɫ = $rs_a[0]['������ɫ'];
	$����     = $rs_a[0]['����'];
	$�Ƿ�ɷ� = $rs_a[0]['�Ƿ�ɷ�'];
	$��ע = "��������ֻ��Ϊ��ʼ��ʹ��!";

	if($ʹ��״̬ == "���۳�"){
          
         
         if($�Ƿ�ɷ� == 0){
		 $Text .= "<a class=OrgAdd href=\"wuye_wuyetingchechangguanli_newai.php?".base64_encode("action=edit_default&���=$���&���_NAME=$���&���_disabled=disabled")."\">����ɷ�</a> ";
		 }else{
		 $Text .= "<a class=OrgAdd href=\"#\" onClick=\"return confirm('��ҵ����λ���ѹ���!')\">��λ����</a> ";
         }
	}else if($ʹ��״̬ == "�����"){
         
		 if($�Ƿ�ɷ� == 0){

		 $��ǰ���·� = date("Y-m",mktime(1,1,1,date("m"),date("d"),date("Y")));
		 $Text .= "<a class=OrgAdd href=\"wuye1_wuyetingchechangguanli_newai.php?".base64_encode("action=add_default&���ɷ��·�=$��ǰ���·�&���ɷ��·�_NAME=$��ǰ���·�&���ɷ��·�_disabled=disabled&ͣ����=$ͣ����&ͣ����_NAME=$ͣ����&ͣ����_disabled=disabled&ͣ��λ=$ͣ��λ&ͣ��λ_NAME=$ͣ��λ&ͣ��λ_disabled=disabled&��������=$��������&��������_NAME=$��������&��������_disabled=disabled&����=$����&����_NAME=$����&����_disabled=disabled&�������=$�������&�������_NAME=$�������&�������_disabled=disabled&������ɫ=$������ɫ&������ɫ_NAME=$������ɫ&������ɫ_disabled=disabled&����=$����&����_NAME=$����&����_disabled=disabled&�������=$¥����ַ&�������_NAME=$¥����ַ&�������_disabled=disabled&ҵ��=$ҵ������&ҵ��_NAME=$ҵ������&ҵ��_disabled=disabled&��ϵ�绰=$��ϵ��ʽ&��ϵ�绰_NAME=$��ϵ��ʽ&��ϵ�绰_disabled=disabled")."\">����ɷ�</a>";
         }else{
		 $Text .= "<a class=OrgAdd href=\"#\" onClick=\"return confirm('�����ó�λ���·����Ѿ��ɹ�!')\">��λ����</a> ";
		 }
	
	}else if($ʹ��״̬ == ""){
        
		
		$Text .= "<a class=OrgAdd href=\"wuye2_wuyetingchechangguanli_newai.php?".base64_encode("action=add_default&�������=$¥����ַ&�������_NAME=$¥����ַ&�������_disabled=disabled&ҵ��=$ҵ������&ҵ��_NAME=$ҵ������&ҵ��_disabled=disabled&��ϵ�绰=$��ϵ��ʽ&��ϵ�绰_NAME=$��ϵ��ʽ&��ϵ�绰_disabled=disabled&��ע=$��ע&��ע_NAME=$��ע&��ע_disabled=disabled")."\">��λ����</a> ";
    }
	$Text .= "<font size=\"2\" color=\"red\">></font>";
	return $Text;

}
?>