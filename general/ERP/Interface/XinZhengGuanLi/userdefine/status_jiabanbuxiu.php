<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$status_jiabanbuxiu = "加班补休状态分析";
function status_jiabanbuxiu_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;

	//print $i;
	//用户类型限制条件##########################结束
	//print $fieldvalue;
	$审核状态	= $fieldvalue;
	if($审核状态==0||$审核状态==''||$审核状态=='否')		return '否';

	$人员	= strip_tags($fields['value'][$i]['人员']);
	$人员用户名	= strip_tags($fields['value'][$i]['人员用户名']);

	$加班时间	= strip_tags($fields['value'][$i]['加班时间']);
	$补休时间	= strip_tags($fields['value'][$i]['补休时间']);
	$加班班次	= strip_tags($fields['value'][$i]['加班班次']);
	$补休班次	= strip_tags($fields['value'][$i]['补休班次']);

	$学期	= strip_tags($fields['value'][$i]['学期']);

	$加班审核状态	= strip_tags($fields['value'][$i]['加班审核状态']);
	$补休审核状态	= strip_tags($fields['value'][$i]['补休审核状态']);

	$TEXT = '';

	$sql = "select 编号 from edu_xingzheng_kaoqinmingxi where 人员='$人员' and 人员用户名='$人员用户名' and 班次='$加班班次' and 日期='$加班时间'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$加班编号 = $rs->fields['编号'];

	$sql = "select 编号 from edu_xingzheng_kaoqinmingxi where 人员='$人员' and 人员用户名='$人员用户名' and 班次='$补休班次' and 日期='$补休时间'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$补休编号 = $rs->fields['编号'];

	if($加班审核状态==1&&$加班编号=='')			{
		执行插入某人某天考勤信息($学期,$人员,$人员用户名,$加班时间,$加班班次);;
		$TEXT = "<font color=red title='原始加班数据不存在,插入成功'>原始加班数据不存在,插入成功</font><BR>";
	}
	else	{
		$TEXT = "<font color=green>加班数据正常</font>";
	}

	if($补休审核状态==1&&$补休编号!='')			{
		执行删除某人某天考勤信息($学期,$人员,$人员用户名,$补休时间,$补休班次);;
		$TEXT .= " <font color=red title='补休时间存在工作信息,删除成功'>补休时间存在工作信息,删除成功</font><BR>";
	}
	else	{
		$TEXT .= " <font color=green>补休数据正常</font>";
	}





	return $TEXT;
}
//require_once('lib.xiaoli.inc.php');
//修正人员相互调课异常操作信息();
?>