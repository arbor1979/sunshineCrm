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
$emailkehulist = "�ʼ��еĿͻ��б�";
function emailkehulist_value( $fieldvalue, $fields, $i )
{
		$customeridArray=explode(",", $fieldvalue);
		$customerName='';
		for($i=0;$i<count($customeridArray);$i++)
		{
			if($customeridArray[$i]!='')
				$customerName=$customerName.returntablefield("linkman", "rowid", $customeridArray[$i],"linkmanname").",";
		}
		if(strlen($customerName)>20)
			$customerName=substr($customerName, 0,20)."...";
		return $customerName;
}
function emailkehulist_view($fields, $i )
{
		
		$fieldvalue=$fields['value']['customers'];
		
		$customeridArray=explode(",", $fieldvalue);
		$customerName='';
		for($i=0;$i<count($customeridArray);$i++)
		{
			if($customeridArray[$i]!='')
				$customerName=$customerName.returntablefield("linkman", "rowid", $customeridArray[$i],"linkmanname").",";
		}
		if(strlen($customerName)>20)
			$customerName=substr($customerName, 0,20)."...";
		return "<tr><td class=TableContent noWrap>�ռ��ͻ�</td><td class=TableData noWrap colspan=5>$customerName</td></tr>";
}

?>
