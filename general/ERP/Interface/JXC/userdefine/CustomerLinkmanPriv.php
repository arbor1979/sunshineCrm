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

function CustomerLinkmanPriv_add($fields, $i )
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

	   		  	 $$(data).find('linkman').each(function(i) {
                   	
						var rowid=$$(this).children('ROWID').text();
						var name=$$(this).children('linkmanname').text();
						
						var mobile='';
						if($$(this).children('mobile').text()!=null)
							mobile=$$(this).children('mobile').text();
						var address='';
						if($$(this).children('address').text()!=null)
							address=$$(this).children('address').text();
						
						document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(name, rowid);
						if(rowid=='".$fields['value'][$fieldname2]."')
							document.form1.$fieldname2.options[document.form1.$fieldname2.length-1].selected=true;
						i++;
                    });				
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('��ȡ��ϵ�˳���'+errorThrown);
	      }
	});

}

function changelocation(locationid)
{
	document.form1.$fieldname2.length = 0;	
	if(locationid!='')
	    sendRequest('linkman','customerid='+locationid);
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
print "<input type='hidden' id='$fieldname1' name='$fieldname1' value='".$fields['value'][$fieldname1]."' onchange=\"changelocation(this.value)\">";
print "<input type='text' id='".$fieldname1."_ID' name='".$fieldname1."_ID' value='".$customername."' readonly class='SmallStatic' size='30' )>&nbsp;\n";
print "<input type=\"button\" title='' value=\"ѡ��\" class=\"SmallButton\" onClick=\"SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','".$fieldname1."_ID', '$fieldname1');\">";
print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";
if($showyuchu)
{
	print "<TR><TD class=TableData noWrap>Ԥ��ֵ:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>\n";
}
print "<TR><TD class=TableData noWrap>�ͻ���ϵ��:</TD><TD class=TableData noWrap>\n";
print "<SELECT name=$fieldname2 class=\"$class\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
print "</SELECT>&nbsp;$notnulltext1</TD></TR>\n";

}


function CustomerLinkPriv_value_PRIV( $fieldvalue, $fields, $i )
{

}

?>
