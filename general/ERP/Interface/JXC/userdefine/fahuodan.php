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

function fahuodan_value( $fieldvalue, $fields, $i )
{
				if($fieldvalue=="δ����")
					$fieldvalue="<font color=red>δ����</font>";
				else if  ($fieldvalue=="�ѷ���")
					$fieldvalue="<font color=green>�ѷ���</font>";
				return $fieldvalue;
}

function fahuodan_value_PRIV( $fieldvalue, $fields, $i )
{
				global $db;
				$SYSTEM_STOP_ROW['edit_priv'] = 1;
				$SYSTEM_STOP_ROW['delete_priv'] = 1;
				$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;
				switch ( $fieldvalue )
				{
				case "δ����" :
						$SYSTEM_STOP_ROW['flow_priv'] = 0;
						
								
								break;
				case "�ѷ���" :
						$SYSTEM_STOP_ROW['flow_priv'] = 1;
						$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
								
				}
				return $SYSTEM_STOP_ROW;
}

?>
