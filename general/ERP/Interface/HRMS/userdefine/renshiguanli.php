<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供资产管理部分中资产状态的部分信息设定。
//#########################################################
$renshiguanli = "注视";
function renshiguanli_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$工作状态 = strip_tags($fields['value'][$i]['工作状态']);
	$工号 = strip_tags($fields['value'][$i]['工号']);
	$姓名 = strip_tags($fields['value'][$i]['姓名']);
	$所属部门  = strip_tags($fields['value'][$i]['所属部门']);
	$性别 = strip_tags($fields['value'][$i]['性别']);
	$民族 = strip_tags($fields['value'][$i]['民族']);
	$学历 = strip_tags($fields['value'][$i]['学历']);
	$出生年月 = strip_tags($fields['value'][$i]['出生年月']);
		$电话 = strip_tags($fields['value'][$i]['电话']);



	$Text .= $工作状态."(";

	if($工作状态=="在职") {$Text .= "<a class=OrgAdd href=\"hrms_file_lizhi_newai.php?".base64_encode("action=add_default&工号=$工号&工号_NAME=工号&工号_disabled=disabled&姓名=$姓名&姓名_NAME=姓名&姓名_disabled=disabled&所属部门=$所属部门&所属部门_NAME=所属部门&所属部门_disabled=disabled&性别=$性别&性别_NAME=性别&性别_disabled=disabled&民族=$民族&民族_NAME=民族&民族_disabled=disabled&学历=$学历&学历_NAME=学历&学历_disabled=disabled&出生年月=$出生年月&出生年月_NAME=出生年月&出生年月_disabled=disabled&电话=$电话&电话_NAME=电话&电话_disabled=disabled")."\">离职</a> ";




	$Text .= "<a class=OrgAdd href=\"hrms_worker_hetong_newai.php?".base64_encode("action=add_default&工号=$工号&工号_NAME=工号&工号_disabled=disabled&姓名=$姓名&姓名_NAME=姓名&姓名_disabled=disabled&所属部门=$所属部门&所属部门_NAME=所属部门&所属部门_disabled=disabled")."\">合同</a> ";

	$Text .= "<a class=OrgAdd href=\"hrms_reward_punishment_newai.php?".base64_encode("action=add_default&工号=$工号&工号_NAME=工号&工号_disabled=disabled&姓名=$姓名&姓名_NAME=姓名&姓名_disabled=disabled&所属部门=$所属部门&所属部门_NAME=所属部门&所属部门_disabled=disabled")."\">奖惩</a> ";



	$Text .= "<a class=OrgAdd href=\"hrms_worker_zhengzhao_newai.php?".base64_encode("action=add_default&工号=$工号&工号_NAME=工号&工号_disabled=disabled&姓名=$姓名&姓名_NAME=姓名&姓名_disabled=disabled&所属部门=$所属部门&所属部门_NAME=所属部门&所属部门_disabled=disabled")."\">证照</a> ";


	$Text .= "<a class=OrgAdd href=\"hrms_transfer_newai.php?".base64_encode("action=add_default&工号=$工号&工号_NAME=工号&工号_disabled=disabled&姓名=$姓名&姓名_NAME=姓名&姓名_disabled=disabled&所属部门=$所属部门&所属部门_NAME=所属部门&所属部门_disabled=disabled")."\">调动</a> ";


	$Text .= "<a class=OrgAdd href=\"hrms_worker_zhicheng_newai.php?".base64_encode("action=add_default&工号=$工号&工号_NAME=工号&工号_disabled=disabled&姓名=$姓名&姓名_NAME=姓名&姓名_disabled=disabled&所属部门=$所属部门&所属部门_NAME=所属部门&所属部门_disabled=disabled")."\">职称</a> ";

	/*
   学习经历  工作经历  劳动技能   社会关系
	*/
   $Text .= "<a class=OrgAdd href=\"hrms_educationalexperience_newai.php?".base64_encode("action=add_default&工号=$工号&工号_NAME=工号&工号_disabled=disabled&姓名=$姓名&姓名_NAME=姓名&姓名_disabled=disabled&所属部门=$所属部门&所属部门_NAME=所属部门&所属部门_disabled=disabled")."\">学习经历</a> ";

    $Text .= "<a class=OrgAdd href=\"hrms_workexperience_newai.php?".base64_encode("action=add_default&工号=$工号&工号_NAME=工号&工号_disabled=disabled&姓名=$姓名&姓名_NAME=姓名&姓名_disabled=disabled&所属部门=$所属部门&所属部门_NAME=所属部门&所属部门_disabled=disabled")."\">工作经历</a> ";


    $Text .= "<a class=OrgAdd href=\"hrms_laboringskill_newai.php?".base64_encode("action=add_default&工号=$工号&工号_NAME=工号&工号_disabled=disabled&姓名=$姓名&姓名_NAME=姓名&姓名_disabled=disabled&所属部门=$所属部门&所属部门_NAME=所属部门&所属部门_disabled=disabled")."\">劳动技能</a> ";


	$Text .= "<a class=OrgAdd href=\"hrms_socialrelation_newai.php?".base64_encode("action=add_default&工号=$工号&工号_NAME=工号&工号_disabled=disabled&姓名=$姓名&姓名_NAME=姓名&姓名_disabled=disabled&所属部门=$所属部门&所属部门_NAME=所属部门&所属部门_disabled=disabled")."\">社会关系</a> ";

	}

if($工作状态=="离职") $Text .= "<a class=OrgAdd href=\"hrms_file_fuzhi_newai.php?".base64_encode("action=add_default&工号=$工号&工号_NAME=工号&工号_disabled=disabled&姓名=$姓名&姓名_NAME=姓名&姓名_disabled=disabled&所属部门=$所属部门&所属部门_NAME=所属部门&所属部门_disabled=disabled&性别=$性别&性别_NAME=性别&性别_disabled=disabled&民族=$民族&民族_NAME=民族&民族_disabled=disabled&学历=$学历&学历_NAME=学历&学历_disabled=disabled&出生年月=$出生年月&出生年月_NAME=出生年月&出生年月_disabled=disabled&电话=$电话&电话_NAME=电话&电话_disabled=disabled")."\">复职</a> ";



	$Text .= ")";


	return $Text;
}

?>