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

function JiaoFuPriv_value( $fieldvalue, $fields, $i )
{
	
	$zhuti = returntablefield( "sellplanmain", "billid", $fieldvalue, "zhuti" );
	$user_flag = returntablefield( "sellplanmain", "billid", $fieldvalue, "user_flag" );
	$img="";
	$title='';
	if($user_flag=="1")
	{
		$img="proc.gif";
		$title='ִ����';
	}
	else if($user_flag=="2")
	{
		$img="over.gif";
		$title='���';
	}
	else if($user_flag=="0")
	{
		$img="time.gif";
		$title='��ʱ��';
	}
	else if($user_flag=="-1")
	{
		$img="exit.gif";
		$title='��ʱ��';
	}
	return "<a href='sellcontract_newai.php?".base64_encode("action=view_default&billid=".$fieldvalue)."' target='_blank'>".$zhuti."</a><img src='../../Framework/images/".$img."' title='$title'>";
	
}

function JiaoFuPriv_value_PRIV( $fieldvalue, $fields, $i )
{
		
		$SYSTEM_STOP_ROW['edit_priv'] = 0;
		$SYSTEM_STOP_ROW['delete_priv'] = 0;
		$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
		$SYSTEM_STOP_ROW['flow_priv'] = 0;
		if($fields['value'][$i]['chukunum']>=$fields['value'][$i]['num'])
		{
			$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
			$SYSTEM_STOP_ROW['edit_priv'] = 1;
			$SYSTEM_STOP_ROW['delete_priv'] = 1;
			$SYSTEM_STOP_ROW['flow_priv'] = 1;
		}
		else if($fields['value'][$i]['chukunum']>0)
		{
			$SYSTEM_STOP_ROW['delete_priv'] = 1;
		}
			
		return $SYSTEM_STOP_ROW;
}

?>
