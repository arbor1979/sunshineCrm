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

function CustomerFuKuan_add($fields, $i )
{
	
global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';

$fieldname1=$fields['name'][$i];
$fieldname2=$fields['input'][$i][0];

$j = array_search($fieldname2,$fields['name'],true);
$notnull=trim($fields['null'][$j]['inputtype']);
$notnull=='notnull'?$notnulltext1=$common_html['common_html']['mustinput']:$notnulltext1='';

$action=$fields['input'][$i][1];
$class = "SmallSelect";
print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>

$(document).ready(function (){	
	
	";
	if($fields['value'][$fieldname1]!='')
	{
	print "changelocation(".$fields['value'][$fieldname1].");
		   getPayType(".$fields['value'][$fieldname2].");";
	}
	print "});
function changelocation(locationid)
{
	document.form1.$fieldname2.length = 0;
	if(locationid!='')
	{
    	sendRequest('$action','customerid='+locationid);
    	getPayType(document.form1.$fieldname2.value);
    	
    }
	
}
function getPayType(billid)
{
   	sendRequest('caigouinfo','billid='+billid);
}
var totalmoney=0;
var huikuanjine=0;
var kaipiaojine=0;
var quling=0; 
function sendRequest(action,params) {
$.ajax({ 
		  type:'GET', 
		  url:'getLinkmanBycustomer.php?action='+action+'&'+params, 
		  dataType: 'xml', 
		  cache:false,
		  async: false,
		  success:function(data) 
		  { 
		  	if(action=='fukuan' || action=='shoupiao')
   		  	{
   		
		  	";
				
				print "var yuchuzhi=$(data).find('chuzhi').text();
   		  			$('#yuchuzhi').text(yuchuzhi+' Ԫ');

   		  		 $(data).find('sellbuy').each(function(i) {
                   	
						var rowid=$(this).children('rowid').text();
						var zhuti=$(this).children('zhuti').text();
						
						
						
						document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(zhuti, rowid);
						if(rowid=='".$fields['value'][$fieldname2]."')
							document.form1.$fieldname2.options[document.form1.$fieldname2.length-1].selected=true;
						i++;
                    });	
   		  	}
   		  	if(action=='caigouinfo')
   		  	{
   		
				$(data).find('caigouinfo').each(function(i) {
					if($(this).children('totalmoney')!=null)
					 	totalmoney=$(this).children('totalmoney').text();
					if($(this).children('paymoney')!=null) 
					 	huikuanjine=$(this).children('paymoney').text();
					if($(this).children('shoupiaomoney')!=null)
					 	kaipiaojine=$(this).children('shoupiaomoney').text();
	   		  		if($(this).children('oddment')!=null)
					 	quling=$(this).children('oddment').text();  	
					  		
	   		  		$('#totalmoney').text(totalmoney);
	   		  		$('#paymoney').text(huikuanjine);
	   		  		$('#shoupiaomoney').text(kaipiaojine);
	   		  		$('#oddment').text(quling);
	   		  		if(form1.jine!=null)
	   		  			form1.jine.value=delFormat(totalmoney)-delFormat(huikuanjine)-delFormat(quling);
	   		  		if(form1.piaojujine!=null)
	   		  			form1.piaojujine.value=delFormat(totalmoney)-delFormat(kaipiaojine);
	   		  		if(form1.oddment!=null)
	   		  			form1.oddment.value=0;
   		  		});	
   		  	}
	   		  				
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('��ȡ�ɹ�������'+errorThrown);
	      }
	});

}

</SCRIPT>
";

print "<TR><TD class=TableData noWrap>��Ӧ��:</TD><TD class=TableData noWrap>\n";
$supplyname=returntablefield("supply", "rowid", $fields['value'][$fieldname1], "supplyname");
$fieldnameID = $fieldname1."_ID";
print "<input type=\"hidden\"  name=\"$fieldname1\" value=\"".$fields['value'][$fieldname1]."\" onchange='changelocation(this.value);'>";
print "<input name=\"".$fieldnameID."\" value=\"".$supplyname."\" class=\"SmallStatic\" readonly size=30>&nbsp;\n";

print "<input type=\"button\" title='' value=\"ѡ��\" class=\"SmallButton\" onClick=\"SelectAllInforSingle('../../Enginee/Module/supply_select_single/index.php','','$fieldnameID', '$fieldname1');\" >&nbsp;$notnulltext";

print "<TR><TD class=TableData noWrap>Ԥ����:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>\n";

print "<TR><TD class=TableData noWrap>�ɹ���:</TD><TD class=TableData noWrap>\n";
print "<SELECT onkeydown=\"if(event.keyCode==13)event.keyCode=9\" class=\"$class\" \n";
print "size=1 name='".$fieldname2."' onchange=\"getPayType(this.value);\"></SELECT>&nbsp;$notnulltext1</TD></TR>\n";

print "<TR><TD class=TableData noWrap>�ܽ��:</TD><TD class=TableData noWrap><div id='totalmoney'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>��ȥ��:</TD><TD class=TableData noWrap><div id='oddment'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>�Ѹ�����:</TD><TD class=TableData noWrap><div id='paymoney'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>����Ʊ���:</TD><TD class=TableData noWrap><div id='shoupiaomoney'></div></TD></TR>\n";
}



?>
