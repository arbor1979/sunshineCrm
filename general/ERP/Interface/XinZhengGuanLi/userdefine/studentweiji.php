<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
$studentweiji = "学生违纪查询";
//#########################################################
function studentweiji_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$学生姓名 = $fields['value'][$i]['学生姓名'];
	$学生学号 = $fields['value'][$i]['学生学号'];

	$学生基本信息 = returntablefield("edu_student","学号",$学生学号,"父亲姓名,父亲电话,母亲姓名,母亲电话");
	$父亲姓名	= $学生基本信息['父亲姓名'];
	$父亲电话	= $学生基本信息['父亲电话'];
	$母亲姓名	= $学生基本信息['母亲姓名'];
	$母亲电话	= $学生基本信息['母亲电话'];

	$TEXT = "$学生姓名 父亲:$父亲姓名 $父亲电话 母亲:$母亲姓名 $母亲电话";

	return $工作流ID号;
}
?>