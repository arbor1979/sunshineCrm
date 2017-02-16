<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//学生调班部分。
//#########################################################

function banzuchengyuan_add($fields,$i)		{
	$组员名称 = $fields['value']['组员名称'];
	$组员名称Array = explode(',',$组员名称);
	for($i=0;$i<sizeof($组员名称Array);$i++)		{
		$组员名称TEXT = $组员名称Array[$i];
		if($组员名称TEXT!="")			{
			$USER_NAME_TEXT	.= returntablefield("user","USER_ID",$组员名称TEXT,"USER_NAME").",";
			$USER_ID_TEXT	.= $组员名称TEXT.",";
		}
		if($USER_NAME_TEXT=="")		{
			$USER_ID_TEXT	.= returntablefield("user","USER_NAME",$组员名称TEXT,"USER_ID").",";
			$USER_NAME_TEXT	.= $组员名称TEXT.",";
		}
	}
	//print $USER_ID_TEXT;
	//print $USER_NAME_TEXT;
	if($USER_ID_TEXT==",") $USER_ID_TEXT = '';
	if($USER_NAME_TEXT==",") $USER_NAME_TEXT = '';
	print "<tr>
		  <td nowrap class='TableData' align='center'>授权范围：<br>（人员）</td>
		  <td class='TableData' colspan=2>
			<input type='hidden' name='COPY_TO_ID' value='$USER_ID_TEXT'>
			<textarea cols=40 name='COPY_TO_NAME' rows=6 class='BigStatic' wrap='yes' readonly>".$USER_NAME_TEXT."</textarea>
			&nbsp;<input type='button' value='添 加' class='SmallButton' onClick=\"SelectUser('','COPY_TO_ID','COPY_TO_NAME')\" title='选择人员' name='button'>
			&nbsp;<input type='button' value='清 空' class='SmallButton' onClick=\"ClearUser('COPY_TO_ID','COPY_TO_NAME')\" title='清空人员' name='button'>
		  </td>
	   </tr>";
}

?>