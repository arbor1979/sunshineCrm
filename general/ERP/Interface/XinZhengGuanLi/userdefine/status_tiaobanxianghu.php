<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$status_tiaobanxianghu = "相互调班状态分析";
function status_tiaobanxianghu_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;

	//print $i;
	//用户类型限制条件##########################结束
	//print $fieldvalue;

	$原人员			= strip_tags($fields['value'][$i]['原人员']);
	$原人员用户名	= strip_tags($fields['value'][$i]['原人员用户名']);
	$新人员			= strip_tags($fields['value'][$i]['新人员']);
	$新人员用户名	= strip_tags($fields['value'][$i]['新人员用户名']);

	$原上班时间	= strip_tags($fields['value'][$i]['原上班时间']);
	$新上班时间	= strip_tags($fields['value'][$i]['新上班时间']);
	$原班次		= strip_tags($fields['value'][$i]['原班次']);
	$新班次		= strip_tags($fields['value'][$i]['新班次']);

	$学期		= strip_tags($fields['value'][$i]['学期']);

	$审核状态 	= strip_tags($fields['value'][$i]['审核状态']);

	$TEXT = '';

	if($审核状态==1)			{
		执行删除某人某天考勤信息($学期,$原人员,$原人员用户名,$原上班时间,$原班次);;
		执行插入某人某天考勤信息($学期,$原人员,$原人员用户名,$新上班时间,$新班次);;

		执行删除某人某天考勤信息($学期,$新人员,$新人员用户名,$新上班时间,$新班次);;
		执行插入某人某天考勤信息($学期,$新人员,$新人员用户名,$原上班时间,$原班次);;

		$TEXT = "<font color=red title='相互调班处理成功'>相互调班处理成功</font><BR>";
	}
	else	{
		$TEXT = "<font color=green>审核不通过</font>";
	}

	return $TEXT;
}
?>