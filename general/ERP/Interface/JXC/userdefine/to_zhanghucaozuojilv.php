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

function to_zhanghucaozuojilv_value( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				global $SYSTEM_PRIV_ROW;
				$Text = "";
				$Text = returntablefield( "user", "USER_ID", $fieldvalue, "USER_NAME" );
				$date = date("Y-m-d",strtotime($_GET['createtime_��ʼʱ��']));
				$par = '?������='.$fieldvalue.'&����ʱ��_��ʼʱ��='.$date.'&����ʱ��_����ʱ��='.$date.' 23:59:59&actionadv=exportadv_default';
				$Text = "<a href='v_accessbank_newai.php".$par."'>{$Text}</a>";
				return $Text;
}

function to_zhanghucaozuojilv_value_PRIV( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;
				$SYSTEM_STOP_ROW['delete_priv'] = 1;
				$SYSTEM_STOP_ROW['edit_priv'] = 1;
				$operid = returntablefield( "buyplanmain", "billid", $fields['value'][$i]['billid'], "createman" );
				
				$operRole=getSupplyRoleBySupplyID($operid);
					
				
				switch ( $fieldvalue )
				{
				case "1" :
						if($operRole)
						{
							$SYSTEM_STOP_ROW['edit_priv'] = 0;
							$SYSTEM_STOP_ROW['delete_priv'] = 0;
							$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
						}
						break;
				case "2" :
						if($operRole )
						{
							$SYSTEM_STOP_ROW['edit_priv'] = 0;
							$SYSTEM_STOP_ROW['flow_priv'] = 0;
							$SYSTEM_STOP_ROW['delete_priv'] = 0;
							$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
						}
						break;
				case "3" :
						
						break;
				case "4" :
						if($operRole)
						{
							$SYSTEM_STOP_ROW['flow_priv'] = 0;
						}
						break;		
				case "5" :
						
						break;	
				}
				return $SYSTEM_STOP_ROW;
}

?>
