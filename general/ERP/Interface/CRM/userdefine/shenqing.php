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
$shenqing = "�������ʱ�Ա༭��ɾ�����п���";
function shenqing_value( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				global $SYSTEM_PRIV_ROW;

				return $fieldvalue;
}

function shenqing_value_PRIV( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				//print_R($fields['value'][$i]['�Ƿ����']);
				$FieldValue = $fields['value'][$i]['�Ƿ����'];
				//$tablecode = $fields['value'][$i]['tablecode'];
				//$tableNo = returntablefield( "stockoutmain", "tablecode", $tablecode, "tableNo" );

				switch ( $FieldValue )
					{
						case 	"2" :
						case 	"3" :
								$SYSTEM_STOP_ROW['edit_priv'] = 1;
								$SYSTEM_STOP_ROW['delete_priv'] = 1;
								break;
						case 	"1" :
						default :
								$SYSTEM_STOP_ROW['edit_priv'] = 0;
								$SYSTEM_STOP_ROW['delete_priv'] = 0;
								if($_SESSION['LOGIN_USER_ID']!=$fields['value'][$i]['¼��Ա'])
								{
									$SYSTEM_STOP_ROW['delete_priv'] = 1;
								}

								break;
					}

				//print_R($SYSTEM_STOP_ROW);
				return $SYSTEM_STOP_ROW;
}

?>
