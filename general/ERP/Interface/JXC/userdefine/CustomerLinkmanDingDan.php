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

function CustomerLinkmanDingDan_add($fields, $i )
{
	
global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
$fieldname1=$fields['name'][$i];
$fieldname2=$fields['input'][$i][0];
$fieldname3=$fields['input'][$i][1];

$j = array_search($fieldname2,$fields['name'],true);
$notnull=trim($fields['null'][$j]['inputtype']);
$notnull=='notnull'?$notnulltext1=$common_html['common_html']['mustinput']:$notnulltext1='';


$n = array_search($fieldname3,$fields['name'],true);
$notnull=trim($fields['null'][$n]['inputtype']);
$notnull=='notnull'?$notnulltext2=$common_html['common_html']['mustinput']:$notnulltext2='';

$class = "SmallSelect";


print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>
var $$ = jQuery.noConflict();
var subcat=new Array();
function sendRequest(action,params) {

    $$.ajax({ 
		  type:'GET', 
		  url:'getLinkmanBycustomer.php?action='+action+'&' + params, 
		  dataType: 'xml', 
		  cache:false,
		  success:function(data) 
		  { 
";
		  	
				if($notnulltext1=='')
   		  			print "document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option('','');";
   		  		print "
   		  		var i=0;
	   		  	$$(data).find('linkman').each(function() {
                   
						var rowid=$$(this).find('ROWID').text();
						var name=$$(this).find('linkmanname').text();
						var mobile='';
						if($$(this).find('mobile').text()!=null)
							mobile=$$(this).find('mobile').text();
						 
						var address='';
						if($$(this).find('address').text()!=null)
							address=$$(this).find('address').text();
						subcat[i]=new Array();
						subcat[i][0]=rowid;
						subcat[i][1]=name;
						subcat[i][2]=mobile;
						subcat[i][3]=address;
						 
						document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(name, rowid);
						if(rowid=='".$fields['value'][$fieldname2]."')
							document.form1.$fieldname2.options[document.form1.$fieldname2.length-1].selected=true;
						i++;
                    });	";
   		  		if($notnulltext2=='')
   		  			print "document.form1.$fieldname3.options[document.form1.$fieldname3.length] = new Option('','');";
   		  		print "		
   		  		$$(data).find('xiaoshoudan').each(function() {
                   
						var rowid=$$(this).find('billid').text();
						var zhuti=$$(this).find('zhuti').text();
						
						document.form1.$fieldname3.options[document.form1.$fieldname3.length] = new Option(zhuti, rowid);
						if(rowid=='".$fields['value'][$fieldname3]."')
							document.form1.$fieldname3.options[document.form1.$fieldname3.length-1].selected=true;
                    });		
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('��ȡ����'+errorThrown);
	      }
	});
}

function changelocation(locationid)
{
	
	document.form1.$fieldname2.length = 0;
	document.form1.$fieldname3.length = 0;
	if(locationid!='')
    	sendRequest('linkmanxiaoshoudan','customerid='+locationid);
}

";
if($fields['value'][$fieldname1]!='')
{
	print "window.onload=function(){
	changelocation(".$fields['value'][$fieldname1].");
	}
	";
}
print "
</SCRIPT>\n";
print "<TR><TD class=TableData noWrap>�ͻ�:</TD><TD class=TableData noWrap>\n";
$customername=returntablefield("customer", "rowid", $fields['value'][$fieldname1], "supplyname");
print "<input type='hidden' name='$fieldname1' value='".$fields['value'][$fieldname1]."' onchange=\"changelocation(this.value)\">";
print "<input type='text' name='".$fieldname1."_ID' value='".$customername."' readonly class='SmallStatic' size='25'>";
print "&nbsp;<input type=\"button\" title='' value=\"ѡ��\" class=\"SmallButton\" onClick=\"SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','".$fieldname1."_ID', '$fieldname1');\" >&nbsp;";
print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";

print "<TR><TD class=TableData noWrap>�ͻ���ϵ��:</TD><TD class=TableData noWrap>\n";
print "<SELECT name='$fieldname2' class=\"$class\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\" onchange=setAddressMobile(this.value);>\n";

print "</SELECT>&nbsp;$notnulltext1</TD></TR>\n";


print "<TR><TD class=TableData noWrap>��Ӧ���۵�:</TD><TD class=TableData noWrap>\n";

print "<SELECT id='$fieldname3' name='$fieldname3' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" class=\"$class\"> \n";
print "</SELECT>&nbsp;$notnulltext2</TD></TR>\n";

}


function CustomerLinkmanDingDan_value_PRIV( $fieldvalue, $fields, $i )
{

}

?>
