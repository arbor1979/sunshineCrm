<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时

function diaoboshenhe_Value($fieldvalue,$fields,$i)			{
	return $fieldvalue;
}
function diaoboshenhe_value_PRIV( $fieldvalue, $fields, $i )
{

		$SYSTEM_STOP_ROW['next_priv'] = 1;
		$shenehren = $fields['value'][$i]['批准人'];
		if($shenehren==$_SESSION['LOGIN_USER_ID'] && $fields['value'][$i]['是否审核']==1)
			$SYSTEM_STOP_ROW['next_priv']=0;	
			
		
		return $SYSTEM_STOP_ROW;
}
?>