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

function relatePrice_add($fields, $i )
{
	global $html_etc,$tablename,$db;
	$product_columns=returntablecolumn('product');
	$priceArray=array();
	foreach ($product_columns as $row)
	{
		if(stristr($row,"sellprice")!=false)
		{
			$priceArray[$row]='';
		}
	}
	$sql = "select fieldname,chinese from systemlang where tablename='product'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	foreach ($rs_a as $row){
		if(isset($priceArray[$row['fieldname']])){
			$priceArray[$row['fieldname']] = $row['chinese'];
			
		}
	}
	
	print_array_select('relatePrice',$html_etc[$tablename]['relatePrice'],2,$priceArray,$fields['value']['relatePrice']);

}
function relatePrice_value( $fieldvalue, $fields, $i )
{
	global $db;
	
	$sql = "select fieldname,chinese from systemlang where tablename='product' and fieldname='$fieldvalue'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(sizeof($rs_a)==1)
	{
		$colorValue = setColorByName($rs_a[0]['chinese']);
		$fieldvalue="<font color=$colorValue>".$rs_a[0]['chinese']."</font>";
	}
	else 
		$fieldvalue="";
	return $fieldvalue;
}
function relatePrice_view( $fields,$i)
{
	
	$fieldvalue=$fields['value']['relatePrice'];
	
	$fieldvalue= relatePrice_value( $fieldvalue, $fields,$i);
	$Text="<TD class=TableContent noWrap>���ü۸�:</TD><td class=TableData noWrap>$fieldvalue</td></tr>";
	echo $Text;	
}
?>
