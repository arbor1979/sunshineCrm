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

function ifkucun_add($fields, $i )
{

print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script>
var $$ = jQuery.noConflict();
$$(document).ready(function(){
	 if($$(\"#ifkucun\").attr('checked')==true)
		 $$(\"#kucunarea\").show();
	 else
		 $$(\"#kucunarea\").hide();
	 
	
		
	 $$(\"#ifkucun\").click(function(){
	  	if($$(this).attr('checked')==true)
	  	{
	    	$$(\"#kucunarea\").slideDown();
	    }
	 	else
	 	{
	  		$$(\"#kucunarea\").slideUp();
	  	}
	 });
	  		

	 $$(\"form\").submit(function(){
	 	if($$(\"#ifkucun\").attr('checked')==false)
	    	$$(\"#ifkucunvalue\").val('��');
	    else
	    	$$(\"#ifkucunvalue\").val('��');
	

	    if($$(\"#ifkucun\").attr('checked')==true)
	 	{
	 		if($$(\"#storemax\").val()!='' && $$(\"#storemin\").val()!='' && $$(\"#storemax\").val()<$$(\"#storemin\").val())
	 		{
	 			alert('������޲���С�ڿ������');
	 			setSubmitBtn(true);
	 			return false;
	 			
	 		}
	 		
	 	}
	 	return true;
	 });
	
	  
});
</script>";
global $html_etc,$tablename;
print "
<TR><TD class=TableContent noWrap>".$html_etc[$tablename]['ifkucun'].":</TD>
<TD class=TableContent colspan=2>
<input type='hidden' name='ifkucun' id='ifkucunvalue' value='".$fields['value']['ifkucun']."'>
<input type='Checkbox' id='ifkucun' ".($fields['value']['ifkucun']!="��"?"checked":"")." value='��'>
</td></TR>
<tr><td colspan=3 class=TableData>
<div id='kucunarea' >
<table class=TableBlock width='100%' >
<TR><TD class=TableData noWrap>".$html_etc[$tablename]['hascolor'].":</TD>
<TD class=TableData colspan='2'>
<p>
<label>
<input type=hidden name='hascolor_ԭʼֵ' value='��'>
<input type='radio' name='hascolor' value='��' ".($fields['value']['hascolor']!="��"?"checked":"")." >��</label>
<input type='radio' name='hascolor' value='��' ".($fields['value']['hascolor']=="��"?"checked":"").">��</label>
</p>
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['storemin'].":</TD>
<input type=hidden name='storemin_ԭʼֵ' value=''>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='13' class='SmallInput'   maxLength=200 size='30'
			name='storemin' id='storemin' value='".$fields['value']['storemin']."' style='ime-mode:disabled' onKeyPress='if (event.keyCode!=46 && event.keyCode!=45 && (event.keyCode<48 || event.keyCode>57)) event.returnValue=false'  onBlur='if (event.keyCode!=46 && event.keyCode!=45 && (event.keyCode<48 || event.keyCode>57)) event.returnValue=false' onpaste='return false' onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_storemin.innerHTML='<font color=red>�����ֵ������-9999999999999- </font>';}else TEXT_storemin.innerHTML='';\" >&nbsp;
 <span id='TEXT_storemin'></span></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['storemax'].":</TD>
<input type=hidden name='storemax_ԭʼֵ' value=''>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='14' class='SmallInput'   maxLength=200 size='30'
			name='storemax' id='storemax' value='".$fields['value']['storemax']."' style='ime-mode:disabled' onKeyPress='if (event.keyCode!=46 && event.keyCode!=45 && (event.keyCode<48 || event.keyCode>57)) event.returnValue=false'  onBlur='if (event.keyCode!=46 && event.keyCode!=45 && (event.keyCode<48 || event.keyCode>57)) event.returnValue=false' onpaste='return false' onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_storemax.innerHTML='<font color=red>�����ֵ������-9999999999999- </font>';}else TEXT_storemax.innerHTML='';\" >&nbsp;
 <span id='TEXT_storemax'></span></TD></TR>";
print "</table></div>";
}
?>
