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
function fahuodanrefer_value( $fieldvalue, $fields, $i )
{
	$value=$fieldvalue;
	$color=setColorByName($value);
	
	$outtype=returntablefield("fahuodan", "billid", $fields['value'][$i]['billid'], "outtype");

		if($outtype=="���۳���")
		{		
			$billinfo=returntablefield("sellplanmain", "billid", $fieldvalue, "billtype,zhuti");
			$billtype=$billinfo['billtype'];
			$title=$billinfo['zhuti'];
			if($billtype=='1')
				$url="sellcontract_newai.php";
			else if($billtype=='2')
				$url="sellplanmain_newai.php";
			else if($billtype=='3')
				$url="v_sellone_search_newai.php";
			$fieldvalue="<a style='color:$color' href='$url?".base64_encode("action=view_default&billid=".$fieldvalue)."' target='_blank'>".$title."</a>";
			
		}
		else if($outtype=='��������')
		{
			$title=returntablefield("buyplanmain","billid",$fieldvalue,"zhuti");
			$fieldvalue="<a style='color:$color' href='buyplanmain_newai.php?".base64_encode("action=view_default&billid=$fieldvalue")."' target='_blank'>$title</a>";
		}

	return $fieldvalue;
}
function fahuodanrefer_view($fields, $i )
{
	$fieldvalue=$fields['value']['dingdanbillid'];
	$tmparray=array();
	$tmparray['value'][$i]=$fields['value'];
	$fieldvalue=fahuodanrefer_value($fieldvalue,$tmparray, $i);

	
	$fieldvalue="<TD class=TableContent noWrap>��Ӧ����:</TD><td class=TableData noWrap colspan=2>$fieldvalue</td>";	
	return $fieldvalue;

}

?>
