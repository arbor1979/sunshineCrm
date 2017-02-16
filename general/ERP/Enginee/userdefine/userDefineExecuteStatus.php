<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//在INIT视图中为其提供值的过滤服务
//此函数个性化需求太强，不可重用
function userDefineExecuteStatus_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$CustomerID = $fields['value'][$i]['CustomerID'];
	$sql = "select * from $tablename where CustomerID='$CustomerID'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$FilterArray = array (
		'CommunicationNeeds'=>"需求沟通",
		'AuthorProgramme'=>"方案撰写",               
		'StylePagesPhase1'=>"风格页阶段",               
		'ContractNegotiations'=>"合同洽谈",               
		'ContractConfirmation'=>"合同确认",               
		'WebsiteAllDesign'=>"网站整体设计",               
		'RecordTransmitted'=>"文案执行",               
		'ProgrameExecute'=>"全案执行",               
		'WebsiteDesign'=>"网站制作",               
		'WebsiteDevelopment'=>"网站开发",               
		'InternalInspection'=>"内部验收",           
		'CustomerAcceptance'=>"客户验收",            
		'WebsiteReleased'=>"网站发布"
		);

	$FilterKeys = array_keys($FilterArray);

	$array_combine = array_combine($FilterKeys);
	$returnColorArray = returnColorArrayTableFilter();

	for($k=0;$k<sizeof($FilterKeys);$k++)			{
		$KeyElement = $FilterKeys[$k];
		if($rs_a[0][$KeyElement]!="")		{
			$fieldvalue = $FilterArray[$KeyElement];
			$KeyElement2 = $FilterKeys[$k+1];

			//得到色彩值
			$Index = $array_combine[$KeyElement];
			$colorIndex = $Index%8;
			$colorValue = $returnColorArray[$colorIndex];

			if($FilterArray[$KeyElement2]=="")	{
				$MarkMEMO = "已经是最后一步：".$FilterArray[$KeyElement];
			}
			else	{
				$MarkMEMO = "下一步：".$FilterArray[$KeyElement2];
			}
		}

	}
	
	//更新数据
	$sql = "update crm_customer set ExecuteStatus = '".$fieldvalue."' where CustomerID='$CustomerID'";
	$db->Execute($sql);
	//print $sql;

	$fieldvalue = "<font color=$colorValue title='$MarkMEMO'>$fieldvalue</font>";	

	return $fieldvalue;
}
?>