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

function SupplyLinkmanPriv_add($fields, $i )
{
	global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';

$fieldname1=$fields['name'][$i];
$fieldname2=$fields['input'][$i][0];

$j = array_search($fieldname2,$fields['name'],true);
$notnull=trim($fields['null'][$j]['inputtype']);
$notnull=='notnull'?$notnulltext1=$common_html['common_html']['mustinput']:$notnulltext1='';

$class = "SmallSelect";

print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>
function changelocation1(locationid)
{

	document.form1.$fieldname2.length = 0;
    sendRequest_supplylinkman('customerid='+locationid);
}
var $$ = jQuery.noConflict();
function sendRequest_supplylinkman(params) 
{

    $$.ajax({ 
		  type:'GET', 
		  url:'getLinkmanBycustomer.php?action=supply&'+params, 
		  dataType: 'xml', 
		  cache:false,
		  success:function(data) 
		  { 
		  	
		  	var yuchuzhi=$$(data).find('chuzhi').text();
		  	$$('#yuchuzhi').html(yuchuzhi+' Ԫ');";
   		  	
				
				if($notnulltext1=='')
   		  			print "document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option('','');";
   		  		print "
   		  		
	   		  	 $$(data).find('supply').each(function() {
      		
						var rowid=$$(this).find('rowid').text();
						var name=$$(this).find('supplyname').text();

						document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(name, rowid);
						if(rowid=='".$fields['value'][$fieldname2]."')
							document.form1.$fieldname2.options[document.form1.$fieldname2.length-1].selected=true;
					
                    });				
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('��ȡ��ϵ�˳���'+errorThrown);
	      }
	});
    
}
";


	
	print "
	function initloadchange()
	{
		";
	if($fields['value'][$fieldname1]!='')
	{
		print "changelocation1(".$fields['value'][$fieldname1].");";
	}
	print "
	}
	if (document.all){

		window.attachEvent('onload',initloadchange)//IE��

		}

	else{

		window.addEventListener('load',initloadchange,false);//firefox

	}
	
	";

print "
</SCRIPT>\n";

$supplyname=returntablefield("supply", "rowid", $fields['value'][$fieldname1], "supplyname");
$fieldnameID = $fieldname1."_ID";
print "<TR><TD class=TableData noWrap>��Ӧ��:</TD><TD class=TableData noWrap>\n";
print "<input type=\"hidden\"  name=\"$fieldname1\" value=\"".$fields['value'][$fieldname1]."\" onchange=\"changelocation1(this.value);\">";
print "<input name=\"".$fieldnameID."\" value=\"".$supplyname."\" class=\"SmallStatic\" readonly size=30>&nbsp;\n";
print "<input type=\"button\" title='' value=\"ѡ��\" class=\"SmallButton\" onClick=\"SelectAllInforSingle('../../Enginee/Module/supply_select_single/index.php','','$fieldnameID', '$fieldname1');\" >&nbsp;$notnulltext";
print "</TD></TR>\n";
print "<TR><TD class=TableData noWrap>Ԥ��ֵ:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>��Ӧ����ϵ��:</TD><TD class=TableData noWrap>\n";
print "<SELECT name=$fieldname2 class=\"$class\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
print "</SELECT>&nbsp;$notnulltext1</TD></TR>\n";

}


function SupplyLinkmanPriv_value_PRIV( $fieldvalue, $fields, $i )
{

}

?>
