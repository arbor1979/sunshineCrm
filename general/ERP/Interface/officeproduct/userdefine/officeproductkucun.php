<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供资产管理部分中资产状态的部分信息设定。
//#########################################################

function officeproductkucun_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$现有库存 = $fields['value'][$i]['库存管理'];
	$办公用品编号 = strip_tags($fields['value'][$i]['办公用品编号']);
	$办公用品名称 = strip_tags($fields['value'][$i]['办公用品名称']);

	$sql = "select SUM(入库数量) 入库数量总计 from officeproductin where 办公用品编号='$办公用品编号'";
	$rs = $db->Execute($sql);
	$入库数量总计 = $rs->fields['入库数量总计'];

	if($现有库存=='') $现有库存 = $入库数量总计;


	$Text .= "(";

	if($现有库存>0)	$Text .= "<a class=OrgAdd href=\"officeproductout_newai.php?".base64_encode("action=add_default&办公用品编号=$办公用品编号&办公用品编号_NAME=办公用品编号&办公用品编号_disabled=disabled&办公用品名称=$办公用品名称&办公用品名称_NAME=办公用品名称&办公用品名称_disabled=disabled&出库性质=借用")."\">借用</a> ";

	if($现有库存>0)	$Text .= "<a class=OrgAdd href=\"officeproductout_newai.php?".base64_encode("action=add_default&办公用品编号=$办公用品编号&办公用品编号_NAME=办公用品编号&办公用品编号_disabled=disabled&办公用品名称=$办公用品名称&办公用品名称_NAME=办公用品名称&办公用品名称_disabled=disabled&出库性质=领用")."\">领用</a> ";

	if($现有库存>0)	$Text .= "<a class=OrgAdd href=\"officeproducttui_newai.php?".base64_encode("action=add_default&办公用品编号=$办公用品编号&办公用品编号_NAME=办公用品编号&办公用品编号_disabled=disabled&办公用品名称=$办公用品名称&办公用品名称_NAME=办公用品名称&办公用品名称_disabled=disabled")."\">归还</a> ";

	$Text .= "<a class=OrgAdd href=\"officeproductin_newai.php?".base64_encode("action=add_default&办公用品编号=$办公用品编号&办公用品编号_NAME=办公用品编号&办公用品编号_disabled=disabled&办公用品名称=$办公用品名称&办公用品名称_NAME=办公用品名称&办公用品名称_disabled=disabled")."\">入库</a> ";

	if($现有库存>0)	$Text .= "<a class=OrgAdd href=\"officeproducttiaoku_newai.php?".base64_encode("action=add_default&办公用品编号=$办公用品编号&办公用品编号_NAME=办公用品编号&办公用品编号_disabled=disabled&办公用品名称=$办公用品名称&办公用品名称_NAME=办公用品名称&办公用品名称_disabled=disabled")."\">调拨</a> ";

	if($现有库存>0)	$Text .= "<a class=OrgAdd href=\"officeproductbaofei_newai.php?".base64_encode("action=add_default&办公用品编号=$办公用品编号&办公用品编号_NAME=办公用品编号&办公用品编号_disabled=disabled&办公用品名称=$办公用品名称&办公用品名称_NAME=办公用品名称&办公用品名称_disabled=disabled")."\">报废</a>";

	$Text .= ")";


	return $fieldvalue;
}
function officeproductkucun_value_PRIV( $fieldvalue, $fields, $i )
{
		$SYSTEM_STOP_ROW['flow_priv'] = 1;
		$SYSTEM_STOP_ROW['delete_priv'] = 1;
		$SYSTEM_STOP_ROW['edit_priv'] = 1;
		$SYSTEM_STOP_ROW['view_priv'] = 1;
		$SYSTEM_STOP_ROW['next_priv'] = 0;
		global $db;
		$storeid = $fields['value'][$i]['存放地点'];
		$userid = returntablefield( "officeproductcangku", "编号", $storeid, "仓库负责人" );
		$useridArray=explode(",", $userid);	
		if(in_array($_SESSION['LOGIN_USER_ID'], $useridArray))
		{
			$SYSTEM_STOP_ROW['flow_priv']=0;	
			$SYSTEM_STOP_ROW['edit_priv'] = 0;
			$SYSTEM_STOP_ROW['view_priv'] = 0;
		}
		if($fields['value'][$i]['数量']==0 && in_array($_SESSION['LOGIN_USER_ID'], $useridArray))
		{
			$id = returntablefield( "officeproductout", "否是审核", '2', "编号","是否归还",'1',"办公用品编号",$fields['value'][$i]['办公用品编号']);
			if($id=='')
				$SYSTEM_STOP_ROW['delete_priv']=0;
		}
		if($fields['value'][$i]['数量']<=0)
			$SYSTEM_STOP_ROW['next_priv'] = 1;
		return $SYSTEM_STOP_ROW;
}
?>