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

function huikuanjine_add( $fields, $i)
{
	global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';

$fieldname1=$fields['name'][$i];
$fieldname2=$fields['input'][$i][0];
$oper=$fields['input'][$i][1];

$opername="�ؿ�";
if($oper=="1")
	$opername="����";

$class = "SmallSelect";
print "<script language=javascript>	


function shurujine(obj)
{
	var yingshou=parseFloat(delFormat(totalmoney))-parseFloat(delFormat(huikuanjine))-parseFloat(delFormat(quling));
	if(yingshou>0 && parseFloat(form1.$fieldname1.value)+parseFloat(form1.$fieldname2.value)>yingshou)
	{
		obj.focus();
		obj.select();
		alert('����".$opername."��ȥ����ϼƲ��ó���'+yingshou);
	}
	if(yingshou<0 && parseFloat(form1.$fieldname1.value)+parseFloat(form1.$fieldname2.value)<yingshou)
	{
		obj.focus();
		obj.select();
		alert('����".$opername."��ȥ����ϼƲ���С��'+yingshou);
	}
	document.getElementById('shangqian').innerText=Math.round((yingshou-parseFloat(form1.$fieldname1.value)-parseFloat(form1.$fieldname2.value))*100)/100;
}

</SCRIPT>\n";


print "<TR><TD class=TableData noWrap>����".$opername."���:</TD><TD class=TableData noWrap colspan=2>
<INPUT type='text' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' class='SmallInput'  maxLength=10 
			name='$fieldname1' value='".$fields['value'][$i][$fieldname1]."' onkeypress=\"check_input_num('MONEY')\" onchange='this.value=Math.round(this.value*100)/100;shurujine(this);'>&nbsp;
$notnulltext && ����Ϊ���Ҹ�ʽ</TD></TR>\n";

print "<TR><TD class=TableData noWrap>����ȥ��:</TD><TD class=TableData noWrap colspan=2>
<INPUT type='text' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' class='SmallInput'  maxLength=10 
			name='$fieldname2' value='".$fields['value'][$i][$fieldname2]."' onkeypress=\"check_input_num('MONEY')\" onchange='this.value=Math.round(this.value*100)/100;shurujine(this);'>&nbsp;
			����Ϊ���Ҹ�ʽ</TD></TR>\n";

print "<TR><TD class=TableData noWrap>��Ƿ:</TD><TD class=TableData noWrap colspan=2>
<div id='shangqian'></div></TD></TR>\n";
			
}

?>
