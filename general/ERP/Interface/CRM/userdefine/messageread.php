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
$shenqing = "������Ϣ״̬";
function messageread_value( $fieldvalue, $fields, $i )
{
	if($fieldvalue==0)
		return "<font color=red>��</font>";
	else 
		return "<font color=green>��</font>";
}

function messageread_value_PRIV( $fieldvalue, $fields, $i )
{
				global $db;
		
				$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;
				switch ( $fieldvalue )
					{
						case 	"0" :
								$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
								break;
						case 	"1" :
								$SYSTEM_STOP_ROW['flow_priv'] = 0;
								break;
					}

				//print_R($SYSTEM_STOP_ROW);
				return $SYSTEM_STOP_ROW;
}

?>
