<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�û��Զ������ͣ��������Ӻͱ༭����ʱ
$jineinput = "��������,����,����֮���������ϵ,���½��ͱ༭��ͼ,��������";
function jineinput_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$���� = $fields['value']['����'];
	$���� = $fields['value']['����'];
	$��� = $fields['value']['���'];
	$showtext  = $html_etc[$tablename][$fieldname];
	if($����=='') $���� = 1;
	print "
	<script>
	function DoItInforJinEr()		{
		var ���� = document.form1.����.value;
		var ���� = document.form1.����.value;
		var ��� = ����*����;
		var ������� = Math.round(���*100)/100;
		//alert(����);alert(����);alert(���);
		document.form1.���.value = �������;
	}
	</script>
<TR>
<TD class=TableData noWrap width=20%>����:</TD>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title='' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='7' class=\"SmallInput\"  maxLength=200 size=\"30\" name=\"����\" value=\"$����\" onkeypress=\"check_input_num('MONEY');\" onkeyup=\"DoItInforJinEr();\"
>&nbsp;
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>����:</TD>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title='' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='6' class=\"SmallStatic\" readonly  maxLength=200 size=\"30\" name=\"����\" value=\"$����\"  onkeyup=\"value=value.replace(/[^\d]/g,'');DoItInforJinEr();\"  onbeforepaste=\"clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''));DoItInforJinEr();\"  >&nbsp;
<BR>�½�ʱ����ֻ����1,�糬��1,��ִ�вɹ���������;<BR>һ����Ϣ��Ϊһ������������һ���˵Ľ��ú͹黹��¼;</TD></TR>

<TR><TD class=TableData noWrap>���:</TD>
<TD class=TableData noWrap colspan=\"2\">
<input type=\"hidden\" name=\"\" value=\"\">
<input type=\"text\" name=\"���\" value=\"$���\" readonly class=\"SmallStatic\" size=\"20\">(�˴��������͵����Զ����ɽ��)
</TD></TR>
	";
}

?>