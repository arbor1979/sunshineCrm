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

function customerDays_value( $fieldvalue, $fields, $i )
{
		$lasttime=$fieldvalue;
		
		$fieldvalue='��δ';
		if(!empty($lasttime))
		{
			
			$lasttime=strtotime($lasttime);
			$nowdate=strtotime(date("Y-m-d h:i:s")); 
		
			$days=round(($nowdate-$lasttime)/3600/24);
			if($days==0)
				$days=0;
			$fieldvalue=$days."��";
		}
		
		return $fieldvalue;
}
function customerDays_view($fields, $i )
{
		$lasttime=$fields[value][lasttracetime];
		
		$fieldvalue='��δ';
		if(!empty($lasttime))
		{
			
			$lasttime=strtotime($lasttime);
			$nowdate=strtotime(date("Y-m-d h:i:s")); 
		
			$days=round(($nowdate-$lasttime)/3600/24);
			if($days==0)
				$days=0;
			$fieldvalue=$days."��";
		}
		
		return $fieldvalue;
}

?>
