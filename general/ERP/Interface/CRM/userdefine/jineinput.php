<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�û��Զ������ͣ��������Ӻͱ༭����ʱ
$jineinput = "���ڲ�Ʒ����,ִ�����ۼ۸�,��Ӧ�ս��֮���������ϵ,���½��ͱ༭��ͼ";
function jineinput_add($fields,$i)		{
	global $db;	
	global $tablename,$html_etc,$common_html;
	$fieldname	= $fields['name'][$i];
	$��Ʒ����	= '1';
	$ִ�����ۼ۸� = $fields['value']['ִ�����ۼ۸�'];
	$Ӧ�ս��	= $fields['value']['Ӧ�ս��'];
	$showtext  = $html_etc[$tablename][$fieldname];
	print "
	<script>
	function DoItInforJinEr()		{
		var ��Ʒ���� = document.form1.��Ʒ����.value;
		var ִ�����ۼ۸� = document.form1.ִ�����ۼ۸�.value;
		var Ӧ�ս�� = ��Ʒ����*ִ�����ۼ۸�;
		var �����Ӧ�ս�� = Math.round(Ӧ�ս��*100)/100;
		//alert(��Ʒ����);alert(ִ�����ۼ۸�);alert(Ӧ�ս��);
		document.form1.Ӧ�ս��.value = �����Ӧ�ս��;

		var ʵ�ս�� = document.form1.ʵ�ս��.value;
		var �Żݽ�� = document.form1.�Żݽ��.value;
		var ʵ�ս�� = �����Ӧ�ս��-�Żݽ��;
		document.form1.ʵ�ս��.value = ʵ�ս��;
	}
	</script>
<TR>
<TD class=TableData noWrap width=20%>ִ�����ۼ۸�:</TD>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title='' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='7' class=\"SmallInput\"  maxLength=200 size=\"30\" name=\"ִ�����ۼ۸�\" value=\"$ִ�����ۼ۸�\" onkeyup=\"check_input_num('MONEY');DoItInforJinEr();\"
>&nbsp;&nbsp;(��:3.36Ԫ)
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>��Ʒ����:</TD>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title='' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='6' class=\"SmallInput\"  maxLength=200 size=\"30\" name=\"��Ʒ����\" value=\"$��Ʒ����\"  onkeyup=\"value=value.replace(/[^\d]/g,'');DoItInforJinEr();\"  onbeforepaste=\"clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''));DoItInforJinEr();\"  >&nbsp;
(ע:ֻ����������)</TD></TR>

<TR><TD class=TableData noWrap>Ӧ�ս��:</TD>
<TD class=TableData noWrap colspan=\"2\">
<input type=\"text\" name=\"Ӧ�ս��\" value=\"$Ӧ�ս��\" readonly class=\"SmallStatic\" size=\"20\">(�˴��ɲ�Ʒ������ִ�����ۼ۸��Զ�����Ӧ�ս��)
</TD></TR>

<TR><TD class=TableData noWrap>�Żݽ��:</TD>
<TD class=TableData noWrap colspan=\"2\">
<input type=\"text\" name=\"�Żݽ��\" value=\"$�Żݽ��\"  class=\"SmallInput\"
onkeyup=\"value=value.replace(/[^\d]/g,'');DoItInforJinEr();\" 
size=\"20\">
</TD></TR>

<TR><TD class=TableData noWrap>ʵ�ս��:</TD>
<TD class=TableData noWrap colspan=\"2\">
<input type=\"text\" name=\"ʵ�ս��\" value=\"$ʵ�ս��\" readonly class=\"SmallStatic\" size=\"20\">(ʵ�ս��=Ӧ�ս��-�Żݽ��)
</TD></TR>
	";
}

?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>