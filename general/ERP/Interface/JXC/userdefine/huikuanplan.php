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

function huikuanplan_value($fieldvalue, $fields, $i)
{
		
				switch ( $fieldvalue )
				{
				case "δ�ؿ�" :
								$color = "red";
								break;
				case "�ѻؿ�" :
								$color = "green";
				}
				$Text="<font color=$color>".$fieldvalue."</font>";
				return $Text;
}
function huikuanplan_value_PRIV( $fieldvalue, $fields, $i )
{

				switch ( $fieldvalue )
				{
				case "δ�ؿ�" :
						$SYSTEM_STOP_ROW['flow_priv'] = 0;
								
								break;
				case "�ѻؿ�" :
						$SYSTEM_STOP_ROW['flow_priv'] = 1;
						$SYSTEM_STOP_ROW['edit_priv'] = 1;
						$SYSTEM_STOP_ROW['del_priv'] = 1;
								
				}
				return $SYSTEM_STOP_ROW;
}
?>
