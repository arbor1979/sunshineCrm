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

function kaipiaostate_value( $fieldvalue, $fields, $i )
{
		$Text = "";
		switch ( $fieldvalue )
		{
		case "0" :
			
						$color = "orange";
						break;
	
		case "3" :
						$color = "blue";
						break;
		case "4" :
						$color = "green";
						break;
						
		}
		$fieldvalue=returntablefield( "kaipiaostate", "id", $fieldvalue, "name" );
		$Text="<font color=$color>$fieldvalue</font>";
		return $Text;
		
}
function kaipiaostate_view($fields, $i )
{
		$fieldvalue=$fields['value']['kaipiaostate'];
		$fieldvalue=kaipiaostate_value($fieldvalue,$fields, $i);
		$shouwname="��Ʊ";
		if($fields['value']['supplyid']!='')
			$shouname="��Ʊ";
		$Text="<TR><TD class=TableContent noWrap>$shouname:</TD><td class=TableContent noWrap>$fieldvalue</td></tr>";
		return $Text;
}

?>
