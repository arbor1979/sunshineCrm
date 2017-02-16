<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供资产管理部分中资产状态的部分信息设定。
//#########################################################
function fixedassetguanli_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$所属状态 = strip_tags($fields['value'][$i]['所属状态']);
	$资产编号 = strip_tags($fields['value'][$i]['资产编号']);
	$资产名称 = strip_tags($fields['value'][$i]['资产名称']);
	$资产类别 = strip_tags($fields['value'][$i]['资产类别']);
	$采购标识 = strip_tags($fields['value'][$i]['采购标识']);
	$所属部门 = strip_tags($fields['value'][$i]['所属部门']);
	
	$Text .= $所属状态."(";
	
	if($所属状态!="资产已分配"&&$所属状态!="资产已报废") $Text .= "<a class=OrgAdd href=\"fixedassetout_newai.php?".base64_encode("action=add_default&资产编号=$资产编号&资产编号_NAME=资产编号&资产编号_disabled=disabled&资产名称=$资产名称&资产名称_NAME=资产名称&资产名称_disabled=disabled&所属部门=$所属部门&所属部门_NAME=DEPT_NAME&所属部门_disabled=disabled")."\">借领</a> ";

	if($所属状态=="资产已分配") $Text .= "<a class=OrgAdd href=\"fixedassettui_newai.php?".base64_encode("action=add_default&资产编号=$资产编号&资产编号_NAME=资产编号&资产编号_disabled=disabled&资产名称=$资产名称&资产名称_NAME=资产名称&资产名称_disabled=disabled&所属部门=$所属部门&所属部门_NAME=DEPT_NAME&所属部门_disabled=disabled")."\">归还</a> ";

	if($所属状态!="资产已报废") $Text .= "<a class=OrgAdd href=\"fixedassetin_newai.php?".base64_encode("action=add_default&资产编号=$资产编号&资产编号_NAME=资产编号&资产编号_disabled=disabled&资产名称=$资产名称&资产名称_NAME=资产名称&资产名称_disabled=disabled&所属部门=$所属部门&所属部门_NAME=DEPT_NAME&所属部门_disabled=disabled&采购标识=$采购标识&资产类别=$资产类别")."\">采购</a> ";
	
	if($所属状态!="资产已报废") $Text .= "<a class=OrgAdd href=\"fixedassettiaoku_newai.php?".base64_encode("action=add_default&资产编号=$资产编号&资产编号_NAME=资产编号&资产编号_disabled=disabled&资产名称=$资产名称&资产名称_NAME=资产名称&资产名称_disabled=disabled&原有所属部门=$所属部门&原有所属部门_NAME=DEPT_NAME&原有所属部门_disabled=disabled")."\">调拨</a> ";

	if($所属状态!="资产已报废") $Text .= "<a class=OrgAdd href=\"fixedassetweixiu_newai.php?".base64_encode("action=add_default&资产编号=$资产编号&资产编号_NAME=资产编号&资产编号_disabled=disabled&资产名称=$资产名称&资产名称_NAME=资产名称&资产名称_disabled=disabled&所属部门=$所属部门&所属部门_NAME=DEPT_NAME&所属部门_disabled=disabled")."\">维修</a> ";

	if($所属状态!="资产已报废") $Text .= "<a class=OrgAdd href=\"fixedassetbaofei_newai.php?".base64_encode("action=add_default&资产编号=$资产编号&资产编号_NAME=资产编号&资产编号_disabled=disabled&资产名称=$资产名称&资产名称_NAME=资产名称&资产名称_disabled=disabled&所属部门=$所属部门&所属部门_NAME=DEPT_NAME&所属部门_disabled=disabled")."\">报废</a>";
	
	if($所属状态=="资产已报废") $Text .= "<font color=green>该资产已经处于报废状态</font>";

	$Text .= ")";


	return $Text;
}
?>