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

function workplanstate_value( $fieldvalue, $fields, $i )
{
	$color="";
	if($fieldvalue=='0')
		$color="red";
	else if($fieldvalue=='1')
		$color="blue";
	else if($fieldvalue=='2')
		$color="green";
	$fieldvalue=returntablefield("workplanstate", "id", $fieldvalue,"name");
	return "<font color=$color>".$fieldvalue."</font>";
}

function workplanstate_value_PRIV( $fieldvalue, $fields, $i )
{
		
	
				$userinfo = returntablefield( "user", "user_id", $fields['value2'][$i]['createman'], "user_id,dept_id,user_priv" );
				$userid=$userinfo['user_id'];
				$deptid=$userinfo['dept_id'];
				$userpriv=$userinfo['user_priv'];
				
				$SYSTEM_STOP_ROW['edit_priv'] = 1;
				$SYSTEM_STOP_ROW['delete_priv'] = 1;
				$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;
				
				
				if($userid==$_SESSION['LOGIN_USER_ID'])
				{
					$detailid=returntablefield("workplanmain_detail", "mainrowid", $fields['value'][$i]['id'], "id");
					
					if($detailid=='')
						$SYSTEM_STOP_ROW['edit_priv'] = 0;
					$SYSTEM_STOP_ROW['delete_priv'] = 0;
					if ($fields['value2'][$i]['state']==2)
					{
						$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
					}
				}
				
				if( $fields['value2'][$i]['shenchastate']!='')
				{
					$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
					$SYSTEM_STOP_ROW['delete_priv'] = 1;
				}
				$zhixingrenArray=explode(",", $fields['value'][$i]['zhixingren']);
				if(in_array($_SESSION['LOGIN_USER_ID'], $zhixingrenArray) && $fields['value2'][$i]['state']<2)
					$SYSTEM_STOP_ROW['flow_priv'] = 0;
				return $SYSTEM_STOP_ROW;
}

?>
