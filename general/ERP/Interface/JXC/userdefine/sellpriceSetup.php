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

function sellpriceSetup_add($fields, $i )
{

print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script>

var $$ = jQuery.noConflict();
	function s1()
	{
	  	 s2();
	  	 s3();
	  	 s4();
	  	 s5();
	} 
	function s2(){
	  	 if($$(\"#sellprice2\").val()!=0 && $$(\"#sellprice\").val()!=0)
		 	$$(\"#TEXT_sellprice2\").html('(�൱�����ۼ۵�'+Math.round($$(\"#sellprice2\").val()/$$(\"#sellprice\").val()*100)/10+'��)');
	
	 }
	 function s3(){
	  	 if($$(\"#sellprice3\").val()!=0 && $$(\"#sellprice\").val()!=0)
		 	$$(\"#TEXT_sellprice3\").html('(�൱�����ۼ۵�'+Math.round($$(\"#sellprice3\").val()/$$(\"#sellprice\").val()*100)/10+'��)');
	
	 }
	 function s4(){
	  	 if($$(\"#sellprice4\").val()!=0 && $$(\"#sellprice\").val()!=0)
		 	$$(\"#TEXT_sellprice4\").html('(�൱�����ۼ۵�'+Math.round($$(\"#sellprice4\").val()/$$(\"#sellprice\").val()*100)/10+'��)');
	
	 }
	 function s5(){
	  	 if($$(\"#sellprice5\").val()!=0 && $$(\"#sellprice\").val()!=0)
		 	$$(\"#TEXT_sellprice5\").html('(�൱�����ۼ۵�'+Math.round($$(\"#sellprice5\").val()/$$(\"#sellprice\").val()*100)/10+'��)');
	
	 }
$$(document).ready(function(){

	 $$(\"#sellprice\").change(function(){s1()});
	 $$(\"#sellprice2\").change(function(){s2()});
	 $$(\"#sellprice3\").change(function(){s3()});
	 $$(\"#sellprice4\").change(function(){s4()});
	 $$(\"#sellprice5\").change(function(){s5()});
	 s1();
	 
	 $$(\"form\").submit(function(){
	 	
	 	if($$(\"#sellprice\").val()<0 || $$(\"#sellprice2\").val()<0 || $$(\"#sellprice3\").val()<0 || $$(\"#sellprice4\").val()<0 || $$(\"#sellprice5\").val()<0)
	 	{
	 		alert('���ۼ۸���С��0');
	 		setSubmitBtn(true);
	 		return false;
	 	}
	 	
	 	return true;
	 });
	  
});
</script>";
global $html_etc,$tablename;
print "
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['sellprice'].":</TD>
<input type=hidden name='sellprice_ԭʼֵ' value=''>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='5' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='sellprice' id='sellprice' value=\"".$fields['value']['sellprice']."\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_sellprice.innerHTML='<font color=red>�����ֵ������ -9999999999999 �� 9999999999999 ֮�� </font>';}else TEXT_sellprice.innerHTML='';\" >&nbsp;
���� <span id='TEXT_sellprice'></span></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['sellprice2'].":</TD>
<input type=hidden name='sellprice2_ԭʼֵ' value=''>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='6' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='sellprice2' id='sellprice2' value=\"".$fields['value']['sellprice2']."\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_sellprice2.innerHTML='<font color=red>�����ֵ������ -9999999999999 �� 9999999999999 ֮�� </font>';}else TEXT_sellprice2.innerHTML='';\" >&nbsp;
 <span id='TEXT_sellprice2'></span></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['sellprice3'].":</TD>
<input type=hidden name='sellprice3_ԭʼֵ' value=''>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='7' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='sellprice3' id='sellprice3' value=\"".$fields['value']['sellprice3']."\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_sellprice3.innerHTML='<font color=red>�����ֵ������ -9999999999999 �� 9999999999999 ֮�� </font>';}else TEXT_sellprice3.innerHTML='';\" >&nbsp;
 <span id='TEXT_sellprice3'></span></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['sellprice4'].":</TD>
<input type=hidden name='sellprice4_ԭʼֵ' value=''>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='8' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='sellprice4' id='sellprice4' value=\"".$fields['value']['sellprice4']."\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_sellprice4.innerHTML='<font color=red>�����ֵ������ -9999999999999 �� 9999999999999 ֮�� </font>';}else TEXT_sellprice4.innerHTML='';\" >&nbsp;
 <span id='TEXT_sellprice4'></span></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['sellprice5'].":</TD>
<input type=hidden name='sellprice5_ԭʼֵ' value=''>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='8' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='sellprice5' id='sellprice5' value=\"".$fields['value']['sellprice5']."\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_sellprice5.innerHTML='<font color=red>�����ֵ������ -9999999999999 �� 9999999999999 ֮�� </font>';}else TEXT_sellprice5.innerHTML='';\" >&nbsp;
 <span id='TEXT_sellprice5'></span></TD></TR>";
}
?>
