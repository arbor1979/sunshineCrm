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

function CustomerHetongPriv_add($fields, $i )
{
	
global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
$fieldname1=$fields['name'][$i];
$fieldname2=$fields['input'][$i][0];
$showyuchu=$fields['input'][$i][1];
$j = array_search($fieldname2,$fields['name'],true);
$notnull=trim($fields['null'][$j]['inputtype']);
$notnull=='notnull'?$notnulltext1=$common_html['common_html']['mustinput']:$notnulltext1='';

$class = "SmallSelect";

print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>
var $$ = jQuery.noConflict();
function sendRequest(action,params) {
    
    $$.ajax({ 
		  type:'GET', 
		  url:'getLinkmanBycustomer.php?action='+action+'&'+params, 
		  dataType: 'xml', 
		  cache:false,
		  success:function(data) 
		  { 
		  
		  	";
				if($showyuchu)
				{
					print "var yuchuzhi=$$(data).find('chuzhi').text();
					$$('#yuchuzhi').html(yuchuzhi+' Ԫ');";
   		  			
				}
				if($notnulltext1=='')
   		  			print "document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option('','');";
   		  		print "

	   		  	 $$(data).find('hetong').each(function() {
                   
						var rowid=$$(this).find('rowid').text();
						var zhuti=$$(this).find('zhuti').text();

						document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(zhuti, rowid);
						if(rowid=='".$fields['value'][$fieldname2]."')
							document.form1.$fieldname2.options[document.form1.$fieldname2.length-1].selected=true;
				
                    });				
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  
			  alert('��ȡ��ͬ�б����'+errorThrown);
	      }
	});
}


function changelocation(locationid)
{
	document.form1.$fieldname2.length = 0;
	if(locationid!='')
    	sendRequest('hetong','customerid='+locationid);
}";
if($fields['value'][$fieldname1]!='')
{
	print "window.onload=function(){
	changelocation(".$fields['value'][$fieldname1].");
	}
	";
}
print "</SCRIPT>\n";


print "<TR><TD class=TableData noWrap>�ͻ�:</TD><TD class=TableData noWrap>\n";
$customername=returntablefield("customer", "rowid", $fields['value'][$fieldname1], "supplyname");
print "<input type='hidden' name='$fieldname1' value='".$fields['value'][$fieldname1]."' onchange=\"changelocation(this.value);\">";
print "<input type='text' name='".$fieldname1."_ID' value='".$customername."' readonly class='SmallStatic' size='25'>";
print "&nbsp;<input type=\"button\" title='' value=\"ѡ��\" class=\"SmallButton\" onClick=\"SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','".$fieldname1."_ID', '$fieldname1');\" >&nbsp;";
print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";

print "<TR><TD class=TableData noWrap>��ͬ:</TD><TD class=TableData noWrap>\n";
print "<SELECT id=$fieldname2 onkeydown=\"if(event.keyCode==13)event.keyCode=9\" class=\"$class\" size=1 name=$fieldname2> \n";
print "</SELECT>&nbsp;$notnulltext1</TD></TR>\n";

}



?>
