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

function feiyongpriv_value( $fieldvalue, $fields, $i )
{
				return $fieldvalue;
}

function feiyongpriv_value_PRIV( $fieldvalue, $fields, $i )
{
				global $db;
				$iflock=returntablefield("feiyongtype", "id", $fields['value'][$i]['typeid'], "iflock");
				
				switch ( $iflock )
				{
				case "0" :
						if($fields['value'][$i]['createman']==$_SESSION['LOGIN_USER_ID'])
							$SYSTEM_STOP_ROW['delete_priv'] = 0;
						else 
							$SYSTEM_STOP_ROW['delete_priv'] = 1;		
						break;
				case "1" :
						$SYSTEM_STOP_ROW['delete_priv'] = 1;
								
				}
				return $SYSTEM_STOP_ROW;
}

?>
