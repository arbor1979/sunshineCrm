<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�û��Զ������ͣ��������Ӻͱ༭����ʱ

function diaoboshenhe_Value($fieldvalue,$fields,$i)			{
	return $fieldvalue;
}
function diaoboshenhe_value_PRIV( $fieldvalue, $fields, $i )
{

		$SYSTEM_STOP_ROW['next_priv'] = 1;
		$shenehren = $fields['value'][$i]['��׼��'];
		if($shenehren==$_SESSION['LOGIN_USER_ID'] && $fields['value'][$i]['�Ƿ����']==1)
			$SYSTEM_STOP_ROW['next_priv']=0;	
			
		
		return $SYSTEM_STOP_ROW;
}
?>