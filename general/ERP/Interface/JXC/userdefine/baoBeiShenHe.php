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

function baoBeiShenHe_value( $fieldvalue, $fields, $i )
{
				return $fieldvalue;
}

function baoBeiShenHe_value_PRIV( $fieldvalue, $fields, $i )
{
		
//print_R($fields['value'][$i]);
				$userinfo = returntablefield( "user", "user_id", $fields['value'][$i]['createman'], "user_id,dept_id,user_priv" );
				$userid=$userinfo['user_id'];
				$deptid=$userinfo['dept_id'];
				$userpriv=$userinfo['user_priv'];
				
				$SYSTEM_STOP_ROW['edit_priv'] = 1;
				$SYSTEM_STOP_ROW['delete_priv'] = 1;
				$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;
				
				if($fields['value'][$i]['state']==1)
				{
					if($userid==$_SESSION['LOGIN_USER_ID'])
					{
						$SYSTEM_STOP_ROW['edit_priv'] = 0;
						$SYSTEM_STOP_ROW['delete_priv'] = 0;
					}
				
				}
				if ($_SESSION['LOGIN_USER_PRIV']=='1' || ($deptid==$_SESSION['LOGIN_DEPT_ID'] && $_SESSION['LOGIN_USER_PRIV']<$userpriv))
				{
					if($fields['value'][$i]['state']==1)
					{
						$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
					}
					else
						$SYSTEM_STOP_ROW['flow_priv'] = 0;
					
				}
				return $SYSTEM_STOP_ROW;
}

?>
