<?php
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
*/

function sellonePriv_value( $fieldvalue, $fields, $i )
{
		$Text = "";
		switch ( $fieldvalue )
		{
		case "-1" :
						$color = "red";
						break;
		case "0" :
						$color = "orange";
						break;
		case "1" :
						$color = "blue";
						break;
		case "2" :
						$color = "green";
						break;
						
		}
		$fieldvalue=returntablefield( "sellplanstate", "id", $fieldvalue, "name" );
		$Text="<font color=$color>$fieldvalue</font>";
		return $Text;
	
}

function sellonePriv_value_PRIV( $fieldvalue, $fields, $i )
{
	global $db;
				
	$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
	$SYSTEM_STOP_ROW['flow_priv'] = 0;
	$SYSTEM_STOP_ROW['delete_priv'] = 0;
	$SYSTEM_STOP_ROW['edit_priv'] = 0;
	$SYSTEM_STOP_ROW['next_priv'] = 1;
	
	if(floatvalue($fields['value'][$i]['totalmoney'])==0)
	{
		$SYSTEM_STOP_ROW['flow_priv'] = 1;
	}
	if($fields['value'][$i]['user_flag']>0)
	{
		$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
		$SYSTEM_STOP_ROW['flow_priv'] = 1;
		$SYSTEM_STOP_ROW['edit_priv'] = 1;
		$SYSTEM_STOP_ROW['delete_priv'] = 1;
		$SYSTEM_STOP_ROW['next_priv'] = 0;
	
	}
	if($fields['value'][$i]['user_flag']<0)
	{
		$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
		$SYSTEM_STOP_ROW['flow_priv'] = 1;
		$SYSTEM_STOP_ROW['edit_priv'] = 1;
		$SYSTEM_STOP_ROW['delete_priv'] = 1;
	}
	
	return $SYSTEM_STOP_ROW;
				
}

?>
