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

function workreportshenhe_value( $fieldvalue, $fields, $i )
{
		if($fieldvalue=='δ���')
			$fieldvalue="<font color=red>$fieldvalue</font>";
		else if($fieldvalue=='�����')
			$fieldvalue="<font color=green>$fieldvalue</font>";
		return $fieldvalue;
}

function workreportshenhe_value_PRIV( $fieldvalue, $fields, $i )
{
		
	$createman=returntablefield("workreport", "id", $fields['value'][$i]['id'], "createman");
				$userinfo = returntablefield( "user", "user_id", $createman, "user_id,dept_id,user_priv" );
				$userid=$userinfo['user_id'];
				$deptid=$userinfo['dept_id'];
				$userpriv=$userinfo['user_priv'];
				$subdepts=getSubDeptListByParent($_SESSION['LOGIN_DEPT_ID']);
				$subdepts=str_replace("'", "", $subdepts);
				$subdeptsArray=explode(",", $subdepts);
				$SYSTEM_STOP_ROW['edit_priv'] = 1;
				$SYSTEM_STOP_ROW['delete_priv'] = 1;
				$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;
		
				if($fields['value'][$i]['state']=='δ���')
				{
					if($userid==$_SESSION['LOGIN_USER_ID'])
					{
						$SYSTEM_STOP_ROW['edit_priv'] = 0;
						$SYSTEM_STOP_ROW['delete_priv'] = 0;
					}
				
				}
				
				if ($_SESSION['LOGIN_USER_PRIV']=='1' || ($_SESSION['LOGIN_USER_PRIV']=='2' && (($userpriv=='3' && $deptid==$_SESSION['LOGIN_DEPT_ID']) ||  ($userpriv=='2' && in_array($deptid, $subdeptsArray)))))
				{
					if($fields['value'][$i]['state']=='δ���')
					{
						$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
					}
					
				}
				return $SYSTEM_STOP_ROW;
}

?>
