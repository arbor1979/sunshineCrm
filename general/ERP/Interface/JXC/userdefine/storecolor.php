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

function storecolor_value( $fieldvalue, $fields, $i )
{
	$storeinfo=returntablefield("store", "id", $fields['value'][$i]['id'], "prodid,storeid");
	$prodid=$storeinfo['prodid'];
	$storeid=$storeinfo['storeid'];
	
		$ifcolor=returntablefield("product", "productid",$prodid, "hascolor");
	
		if($ifcolor=="��")
		{
			$imgurl=ROOT_DIR."general/ERP/Framework/images/sepan.gif";
			$imggrayurl=ROOT_DIR."general/ERP/Framework/images/sepangray.gif";
			global $db;
			$sql="select sum(num) as allnum from store_color where id in (select id from store where prodid='$prodid' and storeid=$storeid)";
			$rs=$db->Execute($sql);
			$rs_a=$rs->GetArray();
			if(intval($rs_a[0]['allnum'])!=intval($fieldvalue))
				$imgurl=$imggrayurl;
        	$fieldvalue.= "<a href=\"javascript:ShowIframe('��ɫ����','colorinput.php?tablename=store_color&id=".$fields['value'][$i]['id']."',600,200);\" title='��ɫ����'><img src=$imgurl></a>";
		
		}
		return $fieldvalue;
}

?>
