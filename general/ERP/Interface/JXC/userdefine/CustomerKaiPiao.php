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

function CustomerKaiPiao_add($fields, $i )
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
print "<script language=javascript>
var xmlHttp1;   
function createxmlHttp1_buysellbill() {
    if (window.xmlHttp1Request) {
       xmlHttp1 = new xmlHttpRequest();              
    } else {
       xmlHttp1 = new ActiveXObject(\"Microsoft.xmlHttp\");
    }
}
function sendRequest(action,params) {
    createxmlHttp1_buysellbill();    
    xmlHttp1.onreadystatechange =function() {showCartInfo(action)};                        
    xmlHttp1.open(\"GET\", \"getLinkmanBycustomer.php?action=\"+action+\"&\" + params, false);
    xmlHttp1.send(null);
}
function showCartInfo(action) {
    if (xmlHttp1.readyState == 4) {
    	
        if(xmlHttp1.responseText.indexOf(\"root\")==-1)
        	{
				alert(xmlHttp1.responseText);
				return false;
        	}
    		var doc = new ActiveXObject(\"MSxml2.DOMDocument\");
   		 	doc.loadXML(xmlHttp1.responseText);
			
			var rootnode = doc.getElementsByTagName(\"root\")[0];
   		 	
   		  	if(action=='billinfo')
   		  	{
   		  		//alert(xmlHttp1.responseText);
   		  		var detailnode = doc.getElementsByTagName(\"billinfo\")[0];
   		  		var totalmoney=0;
   		  		var huikuanjine=0;
   		  		var kaipiaojine=0;
   		  		var quling=0;
   		  		
   		  		if(detailnode.childNodes[0].childNodes[0]!=null)
				 	totalmoney=detailnode.childNodes[0].childNodes[0].nodeValue;
				if(detailnode.childNodes[1].childNodes[0]!=null) 
				 	huikuanjine=detailnode.childNodes[1].childNodes[0].nodeValue;
				if(detailnode.childNodes[2].childNodes[0]!=null)
				 	kaipiaojine=detailnode.childNodes[2].childNodes[0].nodeValue;
   		  		if(detailnode.childNodes[3].childNodes[0]!=null)
				 	quling=detailnode.childNodes[3].childNodes[0].nodeValue;
				 	   		  		
   		  		document.getElementById('totalmoney').innerText=totalmoney;
   		  		document.getElementById('quling').innerText=quling;
   		  		document.getElementById('huikuanjine').innerText=huikuanjine;
   		  		document.getElementById('kaipiaojine').innerText=kaipiaojine;
   		  		form1.piaojujine.value=delFormat(totalmoney)-delFormat(kaipiaojine);
   		  	}
   		  	if(action=='kaipiao')
   		  	{
   		  		//alert(xmlHttp1.responseText);
   		  		var yuchuzhi=rootnode.childNodes[0].nodeValue;
   		  		document.getElementById('yuchuzhi').innerText=yuchuzhi+' Ԫ';
   		  		var detailnode = doc.getElementsByTagName(\"sellbuy\")[0];
				var subcat = new Array();
				var i=0;
			
				
				while(detailnode!=null && detailnode.nodeName=='sellbuy')
				{
					
						subcat[i]=new Array();
						var rowid=detailnode.childNodes[0].childNodes[0].nodeValue;
						var zhuti=detailnode.childNodes[1].childNodes[0].nodeValue;
						subcat[i][0]=rowid;
						subcat[i][1]=zhuti;
						document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(zhuti, rowid);
						if(rowid=='".$fields['value'][$fieldname2]."')
							document.form1.$fieldname2.options[document.form1.$fieldname2.length-1].selected=true;
						i++;
						detailnode=detailnode.nextSibling;
				}
			}
			
    }
};
function changelocation(locationid)
{
	document.form1.$fieldname2.length = 0;
	if(locationid!='')
	{
    	sendRequest('kaipiao','customerid='+locationid);
    	getPayType(document.form1.$fieldname2.value);
    	
    }
	
}
function getPayType(billid)
{
   	sendRequest('billinfo','billid='+billid);
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
print "<input type='hidden' name='$fieldname1' value='".$fields['value'][$fieldname1]."' >";
print "<input type='text' name='".$fieldname1."_ID' value='".$customername."' readonly class='SmallStatic' size='30'>";
print "&nbsp;<input type=\"button\" title='' value=\"ѡ��\" class=\"SmallButton\" onClick=\"var oldid=".$fieldname1."_ID.value; SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','".$fieldname1."_ID', '$fieldname1');if(oldid!=".$fieldname1."_ID.value){changelocation(".$fieldname1.".value)};\" >&nbsp;";
print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";
print "<TR><TD class=TableData noWrap>Ԥ��ֵ:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>\n";

print "<TR><TD class=TableData noWrap>��ͬ����:</TD><TD class=TableData noWrap>\n";
print "<SELECT onkeydown=\"if(event.keyCode==13)event.keyCode=9\" class=\"$class\" \n";
print "size=1 name='".$fieldname2."' onchange=\"getPayType(this.value);\"></SELECT>&nbsp;$notnulltext1</TD></TR>\n";


print "<TR><TD class=TableData noWrap>�ܽ��:</TD><TD class=TableData noWrap><div id='totalmoney'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>ȥ��:</TD><TD class=TableData noWrap><div id='quling'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>�ѻؿ���:</TD><TD class=TableData noWrap><div id='huikuanjine'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>�ѿ�Ʊ���:</TD><TD class=TableData noWrap><div id='kaipiaojine'></div></TD></TR>\n";
}



?>
