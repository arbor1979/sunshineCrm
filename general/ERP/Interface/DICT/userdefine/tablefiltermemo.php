<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�û��Զ������ͣ��������Ӻͱ༭����ʱ
$tablefiltermemo = "��Ϣ�������������ֶ���ʾ�б�";
function tablefiltermemo_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$���� = $fields['value']['����'];
	$���� = $fields['value']['����'];
	$��� = $fields['value']['���'];
	$showtext  = $html_etc[$tablename][$fieldname];

?>
	<script>
	//�趨�ͻ�����Ϣ
	function GetResultClass(str)
	{
		var oBao = new ActiveXObject("Microsoft.XMLHTTP");
		oBao.open("GET","XmlHttpServerTableField.php?action=showdatas&TableName="+str,false);
		oBao.send();
		//�������˴����ص��Ǿ���escape������ַ���.
		//ͨ��XMLHTTP��������,��ʼ����Select.
		//alert(unescape(oBao.responseText));
		var stringValue = unescape(oBao.responseText);
		Arraystr = stringValue.split(";");
		FieldDetail.innerHTML = "<font color=green>"+Arraystr[0]+"</font>";
		document.form1.��������ģ��.value	= Arraystr[1];
	}
	</script>
<TR>
<TD class=TableData noWrap width=20%>���Ѷ�������Դ:</TD>
<TD class=TableData noWrap colspan="2">
<?php
$sql = "select ����,���� from crm_clendar_object";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
print "<select class=\"SmallSelect\" onChange=\"GetResultClass(this.value);\" name=\"���ݶ���\" >";
print "<option value=\"\" >��ѡ������Դ</option>";
for($i=0;$i<sizeof($rs_a);$i++)				{
	print "<option value=\"".$rs_a[$i]['����']."\" >".$rs_a[$i]['����']."[".$rs_a[$i]['����']."]</option>";
}
print "</select>";
print "
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>�ö����ֶ���ϸ:</TD>
<TD class=TableData colspan=\"2\"><span id='FieldDetail'><font color=green>��û��ѡ������Դ</font></span></TD></TR>

	";
}

?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>