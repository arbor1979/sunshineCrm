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
function fahuodansupply_value( $fieldvalue, $fields, $i )
{
	$value=$fieldvalue;
	$color=setColorByName($value);
	
	$fahuoinfo=returntablefield("fahuodan", "billid", $fields['value'][$i]['billid'], "outtype,customerid");
	$outtype=$fahuoinfo['outtype'];
	$customerid=$fahuoinfo['customerid'];
	
		if($outtype=="���۳���")
		{		
			$supplyname=returntablefield("customer", "rowid", $customerid, "supplyname");
			$color=setColorByName($supplyname);
			$fieldvalue="<a style='color:$color' href='customer_newai.php?".base64_encode("action=view_default&ROWID=".$customerid)."' target='_blank'>".$supplyname."</a>";

		}
		else if($outtype=='��������')
		{
			$supplyname=returntablefield("supply", "rowid", $customerid, "supplyname");
			$color=setColorByName($supplyname);
			$fieldvalue="<a style='color:$color' href='supply_newai.php?".base64_encode("action=view_default&ROWID=".$customerid)."' target='_blank'>".$supplyname."</a>";
			
		}

	return $fieldvalue;
}
function fahuodansupply_view($fields, $i )
{
	$fieldvalue=$fields['value']['customerid'];
	$tmparray=array();
	$tmparray['value'][$i]=$fields['value'];
	$fieldvalue=fahuodansupply_value($fieldvalue,$tmparray, $i);

	
	$fieldvalue="<TD class=TableContent noWrap>�ͻ�/��Ӧ��:</TD><td class=TableData noWrap colspan=2>$fieldvalue</td>";	
	return $fieldvalue;

}

?>
