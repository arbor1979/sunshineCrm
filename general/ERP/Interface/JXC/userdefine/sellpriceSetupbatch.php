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

function sellpriceSetupbatch_add($fields, $i )
{
$fieldname=$fields['name'][$i];
print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script>

var $$ = jQuery.noConflict();
	
$$(document).ready(function(){
	 

});
function addvalue()
{
	 
	if($$(\"#newvalue1\").val()<=0 || $$(\"#newvalue1\").val()>1)
	{
	 		alert('ֵ����Ϊ����0��С�ڵ���1�ĸ�����');
	 		$$(\"#newvalue1\").val('');
	 		$$(\"#newvalue1\").focus();
	 }
	 else
	 	$$(\"#newvalue\").val('round(sellprice*'+$$(\"#newvalue1\").val()+',2)');
}
</script>";
global $html_etc,$tablename;
print "
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename][$fieldname].":</TD>
<input type=hidden name='newvalue' id='newvalue' value=''>
<TD class=TableData noWrap colspan=\"2\">���ۼ� * <INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='5' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='newvalue1' id='newvalue1' value=\"\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"addvalue();if(this.value!='' && (this.value<=0 || this.value>1)){TEXT_sellprice.innerHTML='<font color=red>�����ֵ�����Ǵ���0��С�ڵ���1�ĸ����� </font>';}else {TEXT_sellprice.innerHTML='';}\" >&nbsp(��������ۼ۵��ۿۣ��������0��С�ڵ���1�ĸ�������;
<br><span id='TEXT_sellprice'></span></TD></TR>";
}
?>
