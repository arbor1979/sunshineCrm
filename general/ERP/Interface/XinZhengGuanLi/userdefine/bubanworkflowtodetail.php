<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
$bubanworkflowtodetail = "������ID�ŵ���������ϸҳ��";
//#########################################################
function bubanworkflowtodetail_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$������ID�� = $fieldvalue;
	$��� = $fields['value'][$i]['���'];
	$��������� = $fields['value'][$i]['���������'];
	$��������� = $fields['value'][$i]['���������'];


	$����״̬ = $fields['value'][$i]['�������״̬'];
	$����=strip_tags($����״̬);
	$�������״̬=trim($����);


	$����״̬ = $fields['value'][$i]['�������״̬'];
	$����=strip_tags($����״̬);
	$�������״̬=trim($����);

	$RUN_ID = $������ID��;
	if($RUN_ID>0)
	{
		$FLOW_ID = returntablefield("flow_run","RUN_ID",$RUN_ID,"FLOW_ID");
		//http://localhost/general/
		//http://localhost/general/workflow/list/flow_view/?RUN_ID=225&FLOW_ID=128
		$������ID�� = "
		<a href=\"../../../workflow/list/print/?RUN_ID=$RUN_ID&FLOW_ID=128\" target=_blank><font color=green>��������</font></a>
		<a href=\"../../../workflow/list/flow_view/?RUN_ID=$RUN_ID&FLOW_ID=128\" target=_blank><font color=green>����ͼ</font></a>";
	}
	else	
	{	
		
		if($��������� == ""&&$��������� == "" )
		{
			//http://localhost/general/EDU/Interface/Teacher/edu_scheduletiaoke_newai.php?actiondele=TiaoKeDelete&���=150
			$������ID�� = 
			"<a href=\"?action=BuBanDelete&���=$���\">ɾ��������¼</a>";	
		}
		else if($��������� != "" ) 
		{
			if($�������״̬ == "��")
			{
				$������ID�� = "<a><font color = red>��������ͨ��</font></a>";
			}
			
			else
			{
				$������ID�� = "<a><font color = gray>��������δͨ��</font></a>";
			}
		}
		else if($��������� == ""&&$��������� != "" &&$�������״̬ == "��" && $�������״̬ == "��")
		{
				$������ID�� = "<a href=\"?action=bubanaction&���=$���\"><font color = blue>���벹��</font></a>";
		}
	}
	return $������ID��;
}
?>