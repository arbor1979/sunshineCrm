<?php
/*
��Ȩ����:֣�ݵ���Ƽ��������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ��������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ������������������������������в�������ĸ�У����������������СѧУ���������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ����������ͷ���;

��������:����Ƽ��������������Լܹ�ƽ̨,�Լ��������֮����չ���κ���������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ����,��������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э������,GPLV3Э�����������뵽�ٶ�����;
��������:������ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
*/

function accesspreshou_value( $fieldvalue, $fields, $i )
{
	
		$id=$fields['value'][$i]['id'];
		$opertype = returntablefield( "accesspreshou", "id", $id, "opertype" );
		if($opertype=='������ȡ' || $opertype=='Ƿ����ȡ' || $opertype=='��Ѻ��')
		{
			$billinfo = returntablefield( "sellplanmain", "billid", $fieldvalue, "zhuti,billid,billtype" );
			if($billinfo['billtype']==1)
			{
				$fieldvalue="<a href='sellcontract_newai.php?action=view_default&billid=".$billinfo['billid']."' target='_blank'>".$billinfo['zhuti']."</a>";
			}
			else if($billinfo['billtype']==2)
			{
				$fieldvalue="<a href='sellplanmain_newai.php?action=view_default&billid=".$billinfo['billid']."' target='_blank'>".$billinfo['zhuti']."</a>";
			}	
			else 
				$fieldvalue="<a href='v_sellone_search_newai.php?action=view_default&billid=".$billinfo['billid']."' target='_blank'>".$billinfo['zhuti']."</a>";
		}
		else 	
			$fieldvalue='';
			
		return $fieldvalue;
}

function accesspreshou_value_PRIV( $fieldvalue, $fields, $i )
{
	$SYSTEM_STOP_ROW['delete_priv']=0;

	if(stripos($fields['value'][$i]['opertype'],'������ȡ') || stripos($fields['value'][$i]['opertype'],'���ֶһ�'))			
	{
		$SYSTEM_STOP_ROW['delete_priv'] = 1;
	}
	return $SYSTEM_STOP_ROW;			
}

?>