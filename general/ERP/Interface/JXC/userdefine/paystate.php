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

function paystate_value( $fieldvalue, $fields, $i )
{
		
		$color = "";
		switch ( $fieldvalue )
		{
		case "0" :
						$color = "orange";
						break;
		case "1" :
						$color = "blue";
						break;
		case "2" :
						$color = "green";
						break;
		}
						
		$fieldvalue=returntablefield( "paystate", "id", $fieldvalue, "name" );
		$Text="<font color=$color>$fieldvalue</font>";
		return $Text;
}

function paystate_view($fields, $i )
{

		$fieldvalue=$fields['value']['ifpay'];
		$fieldvalue=paystate_value($fieldvalue,$fields, $i);
		$shouname="�ؿ�";
		if($fields['value']['supplyid']!='')
			$shouname="����";
		$Text="<TR><TD class=TableContent noWrap>$shouname:</TD>\n
		<TD class=TableContent noWrap>$fieldvalue</TD></TR>\n";
		return $Text;
}
?>
