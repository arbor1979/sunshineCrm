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

function stockchangestate_value( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				global $SYSTEM_PRIV_ROW;
				$Text = "";
				switch ( $fieldvalue )
				{
				case "1" :
								$color = "red";
								break;
				case "2" :
								$color = "orange";
								break;
				case "3" :
								$color = "blue";
								break;
				case "4" :
								$color = "green";
								break;
			
				}
				$Text = returntablefield( "stockchangestate", "id", $fieldvalue, "name" );
				$Text = "<font color='{$color}'>{$Text}</font>";
				return $Text;
}

function stockchangestate_value_PRIV( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
				$SYSTEM_STOP_ROW['flow_priv'] = 0;
				$SYSTEM_STOP_ROW['delete_priv'] = 0;
				$SYSTEM_STOP_ROW['edit_priv'] = 0;
				switch ( $fieldvalue )
				{
				case "1" :
						$SYSTEM_STOP_ROW['flow_priv'] = 1;
						$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
						break;
				case "2" :
						//$SYSTEM_STOP_ROW['edit_priv'] = 1;
						$SYSTEM_STOP_ROW['flow_priv'] = 1;
						/*
						$storeid = returntablefield( "stockchangemain", "billid", $fields['value'][$i]['billid'], "outstoreid" );
						$userid = returntablefield( "stock", "rowid", $storeid, "user_id" );
						$useridArray=explode(",", $userid);
						
						if(!in_array($_SESSION['LOGIN_USER_ID'], $useridArray))
						*/
							$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
						break;
				case "3" :
						$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
						$SYSTEM_STOP_ROW['flow_priv'] = 1;
						$SYSTEM_STOP_ROW['edit_priv'] = 1;
						$SYSTEM_STOP_ROW['delete_priv'] = 1;
						
						
						break;
				case "4" :
						$SYSTEM_STOP_ROW['edit_priv'] = 1;
						$SYSTEM_STOP_ROW['flow_priv'] = 1;
						$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
						$SYSTEM_STOP_ROW['delete_priv'] = 1;
						break;	
				case "5" :
						$SYSTEM_STOP_ROW['edit_priv'] = 1;
						$SYSTEM_STOP_ROW['flow_priv'] = 1;
						$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
						$SYSTEM_STOP_ROW['delete_priv'] = 0;
						
						break;	
				}
				return $SYSTEM_STOP_ROW;
}

?>
