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

function sellonefahuo_add($fields, $i )
{

print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script>
$(document).ready(function(){
	 if($(\"#fahuostate\").attr('checked')==true)
		 $(\"#fahuoarea\").show();
	 else
		 $(\"#fahuoarea\").hide();
	 
	 if($(\"#kaipiaostate\").attr('checked')==true)
		 $(\"#kaipiaoarea\").show();
	 else
		 $(\"#kaipiaoarea\").hide();
		
	 $(\"#fahuostate\").click(function(){
	  	if($(this).attr('checked')==true)
	    	$(\"#fahuoarea\").slideDown('slow');
	 	else
	  		$(\"#fahuoarea\").slideUp('slow');
	 });
	  		
	  $(\"#kaipiaostate\").click(function(){
	  	if($(this).attr('checked')==true)
	    	$(\"#kaipiaoarea\").slideDown('slow');
	 	else
	  		$(\"#kaipiaoarea\").slideUp('slow');
	 });
	 
	 $(\"form\").submit(function(){
	
	    //setSubmitBtn(true);
	 	if($(\"#fahuostate\").attr('checked')==true)
	 	{
	 		if($(\"#address\").val()=='')
	 		{
	 			alert('��ַ����Ϊ��');
	 			return false;
	 		}
	 		if($(\"#mobile\").val()=='')
	 		{
	 			alert('�绰����Ϊ��');
	 			return false;
	 		}
	 	}
	 	if($(\"#kaipiaostate\").attr('checked')==true)
	 	{
	 		if($(\"#fapiaoneirong\").val()=='')
	 		{
	 			alert('��Ʊ���ݲ���Ϊ��');
	 			return false;
	 		}
	 	}
	 	//setSubmitBtn(false);
	 	return true;
	 });
	
	  
});
</script>";
print "
<TR><TD class=TableContent noWrap>����:</TD>
<TD class=TableContent colspan=2>
<input type='Checkbox' name='fahuostate' id='fahuostate' ".($fields['value']['fahuostate']==0?"checked":"")." value='0'>
</td></TR>
<tr><td colspan=3 class=TableData>
<div id='fahuoarea' >
<table class=TableBlock width='100%' >

<TR>
<TD class=TableData noWrap width=20%>��ַ:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='16' class='SmallInput'  maxLength=200 size='30'
			name='address' id='address' value='".$fields['value']['address']."'  >&nbsp;
����</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>�绰:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='17' class='SmallInput'  maxLength=200 size='30'
			name='mobile' id='mobile' value='".$fields['value']['mobile']."'  >&nbsp;
����</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>��������:</TD>
<TD class=TableData noWrap colspan=2><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='10' class='SmallInput'  maxLength=200 size='30'
			name='fahuodan' value=''  >&nbsp;
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>�����˷�:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='11' class='SmallInput'  maxLength=200 size='30'
			name='fahuoyunfei' value='' onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;\">&nbsp;
����Ϊ���Ҹ�ʽ</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>�˷ѽ���:</TD><TD class=TableData noWrap colspan='2'>
";
print_select_single_select2('yunfeitype',$fields['value']['yunfeitype'],'yunfeitype', 'id', 'name');
print "</td></tr>
<TR><TD class=TableData noWrap>������ʽ:</TD>
<TD class=TableData noWrap colspan='2'>";
print_select_single_select2('fahuotype',$fields['value']['fahuotype'],'fahuotype', 'id', 'name');
print "</TD></TR>

<script Language='JavaScript'>
function clear_zuiwanfahuodate()
{
  document.form1.zuiwanfahuodate.value='';
}
</script><TR><TD class=TableData noWrap width=20%>����������:</TD>
<TD class=TableData colspan='2'><INPUT class=SmallInput maxLength=20  name=zuiwanfahuodate value='".date("Y-m-d")."' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' >
<input type='button'  title=''  value='ѡ��' class='SmallButton' onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=zuiwanfahuodate');\" title='ѡ��' name='button'>&nbsp;&nbsp;<input type='button'  title=''  value='���' class='SmallButton' onClick='clear_zuiwanfahuodate()' title='���' name='button'></TD></TR>
</table></div></td></tr>";

print "
<TR><TD class=TableContent noWrap>��Ʊ:</TD>
<TD class=TableContent colspan=2>
<input type='Checkbox' name='kaipiaostate' id='kaipiaostate' ".($fields['value']['kaipiaostate']==0?"checked":"")." value='0'>
</td></TR>
<tr><td colspan=3 class=TableData>
<div id='kaipiaoarea' >
<table class=TableBlock width='100%' >
<TR>
<TD class=TableData noWrap width=20%>��Ʊ����:</TD>
<TD class=TableData noWrap colspan=2><INPUT type='text' title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='6' class=\"SmallInput\"  maxLength=200 size=30
			name='fapiaoneirong' id='fapiaoneirong' value='".$fields['value']['fapiaoneirong']."'  >&nbsp;
����</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>��Ʊ��:</TD>
<TD class=TableData noWrap colspan=2><INPUT type='text' title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='7' class='SmallInput'  maxLength=200 size=30
			name='fapiaono' value='".$fields['value']['fapiaono']."'  >&nbsp;
</TD></TR>
<TR><TD class=TableData noWrap>��Ʊ����:</TD>
<TD class=TableData noWrap colspan=2>";
print_select_single_select2('fapiaotype',$fields['value']['fapiaotype'],'crm_piaoju_type', '���', 'Ʊ������');
print "</TD></TR></table></div></td></tr>";
}

function sellonefahuo_view($fields, $i )
{

	$Text="<TD class=TableContent noWrap>����״̬:</TD><td class=TableData colspan=2 noWrap>".returntablefield("fahuostate", "id", $fields['value']['fahuostate'], "name")."</td>";
	if($fields['value']['fahuostate']>-1)
	{
		
		$Text.="<TD class=TableContent noWrap>�绰:</TD><td class=TableData colspan=2 noWrap>".$fields['value']['mobile']."</td>";
		$Text.="</tr><tr>";
		$Text.="<TD class=TableContent noWrap>��ַ:</TD><td class=TableData colspan=2 noWrap>".$fields['value']['address']."</td>";
		$Text.="<TD class=TableContent noWrap>������ʽ:</TD><td class=TableData colspan=2 noWrap>".returntablefield("fahuotype", "id", $fields['value']['fahuotype'], "name")."</td>";
		$Text.="</tr><tr>";
		$Text.="<TD class=TableContent noWrap>��������:</TD><td class=TableData colspan=2 noWrap>".$fields['value']['fahuodan']."</td>";
		$Text.="<TD class=TableContent noWrap>�����˷�:</TD><td class=TableData colspan=2 noWrap>".$fields['value']['fahuoyunfei']."</td>";
		$Text.="</tr><tr>";
		$Text.="<TD class=TableContent noWrap>�˷ѽ���:</TD><td class=TableData colspan=2 noWrap>".returntablefield("yunfeitype", "id", $fields['value']['yunfeitype'], "name")."</td>";
		
	}

	if($fields['value']['kaipiaostate']>-1)
	{
		$Text.="<TD class=TableContent noWrap>��Ʊ״̬:</TD><td class=TableData colspan=2 noWrap>".returntablefield("kaipiaostate", "id", $fields['value']['kaipiaostate'], "name")."</td>";
		$Text.="</tr><tr>";
		$Text.="<TD class=TableContent noWrap>��Ʊ����:</TD><td class=TableData colspan=2 noWrap>".returntablefield("crm_piaoju_type", "���", $fields['value']['fapiaotype'], "Ʊ������")."</td>";
		$Text.="<TD class=TableContent noWrap>��Ʊ��:</TD><td class=TableData colspan=2 noWrap>".$fields['value']['fapiaono']."</td>";
		$Text.="</tr><tr>";
		$Text.="<TD class=TableContent noWrap>��Ʊ����:</TD><td class=TableData colspan=5 noWrap>".$fields['value']['fapiaoneirong']."</td>";
		
	}
	else
		$Text.="<TD class=TableContent noWrap>��Ʊ״̬:</TD><td class=TableData colspan=5 noWrap>".returntablefield("kaipiaostate", "id", $fields['value']['kaipiaostate'], "name")."</td>";
	return $Text;
}

function sellonefahuo_value_PRIV( $fieldvalue, $fields, $i )
{
	
}

?>
