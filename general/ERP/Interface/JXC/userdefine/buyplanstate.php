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

function buyplanstate_value( $fieldvalue, $fields, $i )
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
								$color = "orange";
								break;
				case "2" :
								$color = "blueviolet";
								break;
				case "3" :
								$color = "red";
								break;
				case "4" :
								$color = "blue";
								break;
				case "5" :
								$color = "green";
				}
				$Text = returntablefield( "buyplanstate", "id", $fieldvalue, "name" );
				$Text = "<font color='{$color}'>{$Text}</font>";
				return $Text;
}

function buyplanstate_value_PRIV( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;
				$SYSTEM_STOP_ROW['delete_priv'] = 1;
				$SYSTEM_STOP_ROW['edit_priv'] = 1;
				$SYSTEM_STOP_ROW['next_priv'] = 1;
				$billinfo = returntablefield( "buyplanmain", "billid", $fields['value'][$i]['billid'], "createman,user_flag" );
				$operid=$billinfo['createman'];
				$user_flag=$billinfo['user_flag'];
				$operRole=getSupplyRoleBySupplyID($operid);
					
				
				switch ( $fieldvalue )
				{
				
				case "1" :
						if($operRole && $user_flag==0)
						{
							$SYSTEM_STOP_ROW['edit_priv'] = 0;
							$SYSTEM_STOP_ROW['delete_priv'] = 0;
							$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
							
						}
						break;
				case "2" :
						if($operRole && $user_flag==0)
						{
							$SYSTEM_STOP_ROW['edit_priv'] = 0;
							$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
							$SYSTEM_STOP_ROW['flow_priv'] = 0;
							$SYSTEM_STOP_ROW['delete_priv'] = 0;
							//$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
						}
						break;
				case "3" :
						
						break;
				case "4" :
						if($operRole)
						{
							$SYSTEM_STOP_ROW['flow_priv'] = 0;
							$SYSTEM_STOP_ROW['next_priv'] = 0;
						}
						break;		
				case "5" :
						
						break;	
				}
				
				if(stristr($fields['value'][$i]['user_flag'],'����'))
				{
					$SYSTEM_STOP_ROW['edit_priv'] = 1;
					$SYSTEM_STOP_ROW['flow_priv'] = 1;
					$SYSTEM_STOP_ROW['delete_priv'] = 1;
					$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
					$SYSTEM_STOP_ROW['next_priv'] = 1;
				}
				
				return $SYSTEM_STOP_ROW;
}


?>
