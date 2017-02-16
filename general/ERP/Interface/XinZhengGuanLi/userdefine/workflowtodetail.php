<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$workflowtodetail = "工作流ID号到工作流明细页面";
//#########################################################
function workflowtodetail_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$工作流ID号 = $fieldvalue;
	$RUN_ID = $工作流ID号;
	if($RUN_ID>0)			{
		$FLOW_ID = returntablefield("flow_run","RUN_ID",$RUN_ID,"FLOW_ID");
		//http://localhost/general/
		//http://localhost/general/workflow/list/flow_view/?RUN_ID=225&FLOW_ID=128
		$工作流ID号 = "
		<a href=\"../../../workflow/list/print/?RUN_ID=$RUN_ID&FLOW_ID=128\" target=_blank><font color=green>查阅详情</font></a>
		<a href=\"../../../workflow/list/flow_view/?RUN_ID=$RUN_ID&FLOW_ID=128\" target=_blank><font color=green>流程图</font></a>";
	}
	else		{
		$工作流ID号 = '';
	}
	return $工作流ID号;
}


?>