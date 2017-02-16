<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$status_tiaoxiububan = "调休补班状态分析";
function status_tiaoxiububan_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;

	//print $i;
	//用户类型限制条件##########################结束
	//print $fieldvalue;
	$审核状态	= $fieldvalue;
	if($审核状态==0||$审核状态==''||$审核状态=='否')		return '否';

	$人员	= strip_tags($fields['value'][$i]['人员']);
	$人员用户名	= strip_tags($fields['value'][$i]['人员用户名']);

	$调休时间	= strip_tags($fields['value'][$i]['调休时间']);
	$补班时间	= strip_tags($fields['value'][$i]['补班时间']);
	$调休班次	= strip_tags($fields['value'][$i]['调休班次']);
	$补班班次	= strip_tags($fields['value'][$i]['补班班次']);

	$学期	= strip_tags($fields['value'][$i]['学期']);

	$调休审核状态	= strip_tags($fields['value'][$i]['调休审核状态']);
	$补班审核状态	= strip_tags($fields['value'][$i]['补班审核状态']);

	$TEXT = '';

	$sql = "select 编号 from edu_xingzheng_kaoqinmingxi where 人员='$人员' and 人员用户名='$人员用户名' and 班次='$调休班次' and 日期='$调休时间'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$调休编号 = $rs->fields['编号'];

	$sql = "select 编号 from edu_xingzheng_kaoqinmingxi where 人员='$人员' and 人员用户名='$人员用户名' and 班次='$补班班次' and 日期='$补班时间'";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$补班编号 = $rs->fields['编号'];

	if($调休审核状态==1&&$调休编号!='')			{
		$sql = "update edu_xingzheng_kaoqinmingxi set 日期='0000-00-00' where 人员='$人员' and 人员用户名='$人员用户名' and 班次='$调休班次' and 日期='$调休时间'";
		//print $sql."<BR>";
		$rs = $db->Execute($sql);
		$TEXT = "<font color=red title='调休成功'>调休数据处理成功</font><BR>";
	}
	else	{
		$TEXT = "<font color=green>调休数据正常</font>";
	}

	if($补班审核状态==1&&$补班编号=='')			{
		//寻找数据源
		$sql = "select 编号 from edu_xingzheng_kaoqinmingxi where 人员='$人员' and 人员用户名='$人员用户名' and 班次='$调休班次' and 日期='0000-00-00'";
		$rs = $db->Execute($sql);
		$寻找数据源_编号 = $rs->fields['编号'];
		if($寻找数据源_编号!="")			{
			$sql = "update edu_xingzheng_kaoqinmingxi set 日期='$补班时间',班次='$补班班次' where 编号='$寻找数据源_编号'";
			$db->Execute($sql);
			//print $sql."<BR>";
		}
		else	{
			执行插入某人某天考勤信息($学期,$人员,$人员用户名,$补班时间,$补班班次);;
		}
		$TEXT .= " <font color=red title='补班休息不存在,补班成功'>补班休息不存在,补班成功</font><BR>";
	}
	else	{
		$TEXT .= " <font color=green>补班数据正常</font>";
	}





	return $TEXT;
}
//require_once('lib.xiaoli.inc.php');
//修正人员相互调课异常操作信息();
?>