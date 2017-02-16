<?php
/*
设置空房管理页面的管理操作模块
*/

function kehuguanli_Value($fieldvalue,$fields,$i)		{

    global $db;
	global $tablename,$html_etc,$common_html;
	$编号     = strip_tags($fields['value'][$i]['编号']);
	$房间代码 = strip_tags($fields['value'][$i]['房间代码']);
	$区域名称 = strip_tags($fields['value'][$i]['区域名称']);
	$大楼名称 = strip_tags($fields['value'][$i]['大楼名称']);

	$房间号码 = strip_tags($fields['value'][$i]['房间号码']);
	$业主姓名 = strip_tags($fields['value'][$i]['业主姓名']);
	$业主电话 = strip_tags($fields['value'][$i]['业主电话']);

	$单元号   = strip_tags($fields['value'][$i]['单元号']);
	$楼层号   = strip_tags($fields['value'][$i]['楼层号']);
	$房间号   = strip_tags($fields['value'][$i]['房间号']);
	$单元状态a = strip_tags($fields['value'][$i]['单元状态']);
    
	$单元编号 = $大楼名称."-".$单元号."-".$楼层号.$房间号;
	$房间号码 = $大楼名称."-".$单元号."-".$楼层号.$房间号;
    
    $sql = "select * from wu_housingowner where 房间代码='$房间代码' and 单元编号='$单元编号'";
	$result = $db->Execute($sql);
	$rs_a = $result->GetArray();
	$业主姓名 = $rs_a[0]['业主姓名'];
	$手机号码 = $rs_a[0]['手机'];
	$电话号码 = $rs_a[0]['电话'];

	$业主电话 = $手机号码."或".$电话号码; 

    //echo $业主电话;

	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\">未使用&nbsp;<</font>";

	if($单元状态a == "空")
	$Text .= "<a class=OrgAdd href=\"wu_housingowner_newai.php?".base64_encode("action=add_default&房间代码=$房间代码&房间代码_NAME=$房间代码&房间代码_disabled=disabled&单元编号=$单元编号&单元编号_NAME=$单元编号&单元编号_disabled=disabled")."\">新增客户</a> ";
	 
	if($业主姓名 != ""){

		$sql = "update wu_housingresources set 房间号码='$房间号码',业主姓名='$业主姓名',业主电话='$业主电话' where 房间代码='$房间代码' and 区域名称='$区域名称' and 大楼名称='$大楼名称'";
        
		$db->Execute($sql);

		$Text .= "<a class=OrgAdd href=\"wu_housingresources_newai.php?".base64_encode("action=edit_default&编号=$编号&编号_NAME=$编号&编号_disabled=disabled&房间代码=$房间代码&房间代码_NAME=$房间代码&房间代码_disabled=disabled&区域名称=$区域名称&区域名称_NAME=$区域名称&区域名称_disabled=disabled&大楼名称=$大楼名称&大楼名称_NAME=$大楼名称&大楼名称_disabled=disabled&房间号码=$房间号码&房间号码_NAME=$房间号码&房间号码_disabled=disabled&业主姓名=$业主姓名&业主姓名_NAME=$业主姓名&业主姓名_disabled=disabled&业主电话=$业主电话&业主电话_NAME=$业主电话&业主电话_disabled=disabled&单元号=$单元号&单元号_NAME=$单元号&单元号_disabled=disabled&楼层号=$楼层号&楼层号_NAME=$楼层号&楼层号_disabled=disabled&房间号=$房间号&房间号_NAME=$房间号&房间号_disabled=disabled")."\">新增房间管理</a> ";
    }
	$Text .= "<font size=\"2\" color=\"red\">></font>";
	return $Text;

}
?>