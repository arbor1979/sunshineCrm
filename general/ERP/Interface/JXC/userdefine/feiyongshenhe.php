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

function feiyongshenhe_value( $fieldvalue, $fields, $i )
{
		if($fieldvalue=='δ���')
			$fieldvalue="<font color=blue>$fieldvalue</font>";
		else if($fieldvalue=='ͬ��')
			$fieldvalue="<font color=green>$fieldvalue</font>";
		else if($fieldvalue=='���')
			$fieldvalue="<font color=red>$fieldvalue</font>";
		return $fieldvalue;
}

function feiyongshenhe_value_PRIV( $fieldvalue, $fields, $i )
{
	
		$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
		$SYSTEM_STOP_ROW['delete_priv'] = 1;
		$feiyongInfo=returntablefield("v_feiyongrecord","billid",$fields['value'][$i]['billid'],"typeid,createman");
		$typeid=$feiyongInfo['typeid'];
		$createman=$feiyongInfo['createman'];
		$iflock=returntablefield("feiyongtype", "id", $typeid, "iflock");
				switch ( $iflock )
				{
				case "0" :
						if($createman==$_SESSION['LOGIN_USER_ID'] && $fields['value'][$i]['shenhestate']=='δ���')
							$SYSTEM_STOP_ROW['delete_priv'] = 0;
						else 
							$SYSTEM_STOP_ROW['delete_priv'] = 1;		
						break;
				case "1" :
						$SYSTEM_STOP_ROW['delete_priv'] = 1;
								
				}
				
				
				if ($_SESSION['LOGIN_USER_PRIV']=='1' && $fields['value'][$i]['shenhestate']=='δ���')
				{
					$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
					
				}
				return $SYSTEM_STOP_ROW;
}

?>
