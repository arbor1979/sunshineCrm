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

function kucuninit_value( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				global $SYSTEM_PRIV_ROW;
				$Text = "";
				$storeid=$fields['value'][$i]['ROWID'];
				$sql="select count(distinct prodid) as c,sum(num) as n from store where storeid=$storeid";
				$rs=$db->Execute($sql);
				$rs_a = $rs->GetArray();
				if($rs_a[0]['c']==0)
					$Text="�޲�Ʒ";
				else
					$Text=$rs_a[0]['c']."�ֲ�Ʒ����".$rs_a[0]['n']."��";
				return $Text;
}

function kucuninit_value_PRIV( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;
				$SYSTEM_STOP_ROW['delete_priv'] = 1;
				$SYSTEM_STOP_ROW['edit_priv'] = 1;
				$storeid=$fields['value'][$i]['ROWID'];
				$sql="select * from store_init where storeid=$storeid and flag=1";
				$rs=$db->Execute($sql);
				$rs_a = $rs->GetArray();
				$sql="select * from store where storeid=$storeid and num<>0";
				$rs=$db->Execute($sql);
				$rs_b = $rs->GetArray();
				$userid = returntablefield( "stock", "rowid", $storeid, "user_id" );
				$useridArray=explode(",", $userid);
				if(sizeof($rs_a)==0 && sizeof($rs_b)==0 && in_array($_SESSION['LOGIN_USER_ID'], $useridArray))
				{
					$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
					
				}	
				if(sizeof($rs_a)>0)
				{
					$SYSTEM_STOP_ROW['flow_priv'] = 0;
				}
				
				return $SYSTEM_STOP_ROW;
}

?>
