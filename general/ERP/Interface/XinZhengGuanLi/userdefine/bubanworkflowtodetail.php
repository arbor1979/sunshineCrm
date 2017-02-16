<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$bubanworkflowtodetail = "工作流ID号到工作流明细页面";
//#########################################################
function bubanworkflowtodetail_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$工作流ID号 = $fieldvalue;
	$编号 = $fields['value'][$i]['编号'];
	$调休审核人 = $fields['value'][$i]['调休审核人'];
	$补班审核人 = $fields['value'][$i]['补班审核人'];


	$调休状态 = $fields['value'][$i]['调休审核状态'];
	$调休=strip_tags($调休状态);
	$调休审核状态=trim($调休);


	$补班状态 = $fields['value'][$i]['补班审核状态'];
	$补班=strip_tags($补班状态);
	$补班审核状态=trim($补班);

	$RUN_ID = $工作流ID号;
	if($RUN_ID>0)
	{
		$FLOW_ID = returntablefield("flow_run","RUN_ID",$RUN_ID,"FLOW_ID");
		//http://localhost/general/
		//http://localhost/general/workflow/list/flow_view/?RUN_ID=225&FLOW_ID=128
		$工作流ID号 = "
		<a href=\"../../../workflow/list/print/?RUN_ID=$RUN_ID&FLOW_ID=128\" target=_blank><font color=green>查阅详情</font></a>
		<a href=\"../../../workflow/list/flow_view/?RUN_ID=$RUN_ID&FLOW_ID=128\" target=_blank><font color=green>流程图</font></a>";
	}
	else	
	{	
		
		if($调休审核人 == ""&&$补班审核人 == "" )
		{
			//http://localhost/general/EDU/Interface/Teacher/edu_scheduletiaoke_newai.php?actiondele=TiaoKeDelete&编号=150
			$工作流ID号 = 
			"<a href=\"?action=BuBanDelete&编号=$编号\">删除此条记录</a>";	
		}
		else if($补班审核人 != "" ) 
		{
			if($补班审核状态 == "是")
			{
				$工作流ID号 = "<a><font color = red>补班申请通过</font></a>";
			}
			
			else
			{
				$工作流ID号 = "<a><font color = gray>补班申请未通过</font></a>";
			}
		}
		else if($补班审核人 == ""&&$调休审核人 != "" &&$补班审核状态 == "否" && $调休审核状态 == "是")
		{
				$工作流ID号 = "<a href=\"?action=bubanaction&编号=$编号\"><font color = blue>申请补班</font></a>";
		}
	}
	return $工作流ID号;
}
?>