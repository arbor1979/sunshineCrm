<?php

function xinzengshiyongren_Value($fieldvalue,$fields,$i)		{
    //
    global $db;
	global $tablename,$html_etc,$common_html;
	$房间代码 = strip_tags($fields['value'][$i]['房间代码']);
	$单元编号 = strip_tags($fields['value'][$i]['单元编号']);
	$业主姓名 = strip_tags($fields['value'][$i]['业主姓名']);

    $sql = "select * from wu_housinguser where 单元编号='$单元编号'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();

	if(sizeof($rs_a)==0){
	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\">$业主姓名&nbsp;</font><";
	$Text .= "<a class=OrgAdd href=\"wu_housinguser_newai.php?".base64_encode("action=add_default&房间代码=$房间代码&房间代码_NAME=$房间代码&房间代码_disabled=disabled&单元编号=$单元编号&单元编号_NAME=$单元编号&单元编号_disabled=disabled&业主姓名=$业主姓名&业主姓名_NAME=$业主姓名&业主姓名_disabled=disabled")."\">新增使用人</a> ";
	$Text .= ">";
    }else{
	$Text .= "<font size=\"2\" color=\"red\">$业主姓名</font>";
	}
	return $Text;
}
?>