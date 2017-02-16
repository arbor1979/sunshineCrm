<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$status_tiaoban = "调班状态分析";
function status_tiaoban_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;

	//print $i;
	//用户类型限制条件##########################结束
	//print $fieldvalue;
	$审核状态	= $fieldvalue;
	if($审核状态==0||$审核状态==''||$审核状态=='否')		return '否';

	$人员	= strip_tags($fields['value'][$i]['人员']);
	$人员用户名	= strip_tags($fields['value'][$i]['人员用户名']);

	$原上班时间	= strip_tags($fields['value'][$i]['原上班时间']);
	$原班次		= strip_tags($fields['value'][$i]['原班次']);
	$新上班时间	= strip_tags($fields['value'][$i]['新上班时间']);
	$新班次		= strip_tags($fields['value'][$i]['新班次']);
	$学期		= strip_tags($fields['value'][$i]['学期']);
	$审核状态	= strip_tags($fields['value'][$i]['审核状态']);

	$TEXT = '';

	$sql = "select 编号 from edu_xingzheng_kaoqinmingxi where 人员='$人员' and 人员用户名='$人员用户名' and 班次='$原班次' and 日期='$原上班时间'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$原调班编号 = $rs->fields['编号'];

	$sql = "select 编号 from edu_xingzheng_kaoqinmingxi where 人员='$人员' and 人员用户名='$人员用户名' and 班次='$新班次' and 日期='$新上班时间'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$新调班编号 = $rs->fields['编号'];


	if($审核状态==1)										{
		if($原调班编号!="")			{
			执行删除某人某天考勤信息($学期,$人员,$人员用户名,$原上班时间,$原班次);;
		}
		if($新调班编号=="")			{
			执行插入某人某天考勤信息($学期,$人员,$人员用户名,$新上班时间,$新班次);;
			$TEXT = "<font color=red title='调班成功'>调班数据补充成功</font><BR>";
		}
		$TEXT .= " <font color=green>调班成功</font>";
	}
	else	{
		$TEXT = " <font color=red>审核不通过</font>";
	}





	return $TEXT;
}
//require_once('lib.xiaoli.inc.php');
//修正人员相互调课异常操作信息();
?>