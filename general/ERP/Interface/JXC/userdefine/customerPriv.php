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

function customerPriv_value( $fieldvalue, $fields, $i )
{
	return $fieldvalue;
	
}

function customerPriv_value_PRIV( $fieldvalue, $fields, $i )
{
		
				$SYSTEM_STOP_ROW['edit_priv'] = 1;
				$SYSTEM_STOP_ROW['delete_priv'] = 1;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;
												
				if(ifHasRoleCust($fields['value'][$i]['ROWID']))
				{
					$SYSTEM_STOP_ROW['edit_priv'] = 0;
					$SYSTEM_STOP_ROW['delete_priv'] = 0;
					$SYSTEM_STOP_ROW['flow_priv']=0;
				}
				$billid=returntablefield("sellplanmain", "supplyid", $fields['value'][$i]['ROWID'], "billid");
				if($billid!='')
				{
					$SYSTEM_STOP_ROW['delete_priv'] = 1;
				}
				
					
				return $SYSTEM_STOP_ROW;
}

?>
