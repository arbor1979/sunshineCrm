<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//�ṩ�û��Զ������ͣ��������Ӻͱ༭����ʱ
$caigoubiaoshi = "�ɹ���ʶ,�������ڲɹ��ʲ���������1ʱʹ��,��û�в���,ֱ�Ӳ��������ʲ����Ƶķ�ʽ";
function caigoubiaoshi_add($fields,$i)		{
	global $db;	
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldValue = $fields['value'][$fieldname];
	$�ɹ���ʶ = $_GET['�ʲ�����'];
	print "<TR>";
	print "<TD class=TableData noWrap>�ɹ���ʶ:</TD>\n";
	print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	print "<input type=\"hidden\" name=\"�ʲ����\" value=\"".$_GET['�ʲ����']."\">\n";
    print "<input type=\"text\" name=\"�ɹ���ʶ\" value=\"$�ɹ���ʶ\" readonly class=\"SmallStatic\" size=\"25\">&nbsp;&nbsp;\n";
	print "����:<input type=\"text\" name=\"����\" value=\"1\" class=\"SmallInput\" size=\"6\" onkeyup=\"value=value.replace(/[^\d]/g,'');if(this.value>9999){alert('������ֲ��ܳ���9999');value=9999;}if(this.value<1){alert('��С���ֲ���С��1');value=1;}\"  onbeforepaste=\"clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))\"  >\n<BR>(���ݲɹ���ʶ���вɹ�,���ƺͱ���ɱ�ʶ����)";

	print $addtext = FilterFieldAddText($addtext,$fieldname);
	print "</TD></TR>\n";
}

?>