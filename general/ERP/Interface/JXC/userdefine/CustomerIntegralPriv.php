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

function CustomerIntegralPriv_add($fields, $i )
{
	global $db,$_SESSION,$common_html;
	$notnull=trim($fields['null'][$i]['inputtype']);
	$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
	$fieldname1=$fields['name'][$i];

	$class = "SmallSelect";

	print "<script language=javascript>
var xmlHttp;   
var subcat = new Array();
function createXmlHttp() {
    if (window.XMLHttpRequest) {
       xmlHttp = new XMLHttpRequest();              
    } else {
       xmlHttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
    }
}
function sendRequest(params) {
    createXmlHttp();                        
    xmlHttp.onreadystatechange =function() {showCartInfo()};   
    xmlHttp.open(\"GET\", \"getIntegralBycustomer.php?customerid=\" + params, true);
    xmlHttp.send(null);
}
function changelocation(locationid)
{
	
	document.getElementById('integral').innerText='';	
 	document.getElementById('sum').innerText='';
	if(locationid!='')
    	sendRequest(locationid);
}
function showCartInfo() {
    if (xmlHttp.readyState == 4) 
    {
        	if(xmlHttp.responseText.indexOf(\"root\")==-1)
        	{
				alert(xmlHttp.responseText);
				return false;
        	}
    		//var doc = new ActiveXObject(\"MSxml2.DOMDocument\");
   		 	//doc.loadXML(xmlHttp.responseText);
			doc=xmlHttp.responseXML;
   		 	var rootnode = doc.getElementsByTagName(\"root\")[0];
   		 	//var integral = rootnode.childNodes[0].nodeValue;
  			//var sum = rootnode.childNodes[1].childNodes[0].nodeValue;
			var integral = doc.getElementsByTagName(\"integral\")[0].childNodes[0].nodeValue;
			var sumnod = doc.getElementsByTagName(\"sumnod\")[0].childNodes[0].nodeValue;
   		 	document.getElementById('integral').innerText=integral+' ��';	
   		  	document.getElementById('sum').innerText=sumnod+' ��';
    }
}
";
	if($fields['value'][$fieldname1]!='')
	{
		print "window.onload=function(){
	sendRequest(".$fields['value'][$fieldname1].");
	}
	";
	}
	print "
</SCRIPT>\n";
	print "<TR><TD class=TableData noWrap>�ͻ�:</TD><TD class=TableData noWrap>\n";
	$customername=returntablefield("customer", "rowid", $fields['value'][$fieldname1], "supplyname");
	print "<input type='hidden' name='$fieldname1' value='".$fields['value'][$fieldname1]."' onchange=\"changelocation(this.value)\">";
	print "<input type='text' name='".$fieldname1."_ID' value='".$customername."' readonly class='SmallStatic' size='25' >";
	print "&nbsp;<input type=\"button\" title='' value=\"ѡ��\" class=\"SmallButton\" onClick=\"var oldid=".$fieldname1."_ID.value; SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','".$fieldname1."_ID', '$fieldname1');\" >&nbsp;";
	print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";
	print "<TR><TD class=TableData noWrap>�������:</TD><TD class=TableData noWrap><div id='integral'></div></TD></TR>\n";
	print "<TR><TD class=TableData noWrap>�Ѷһ�����:</TD><TD class=TableData noWrap><div id='sum'></div></TD></TR>\n";
}

function CustomerChancePriv_value_PRIV( $fieldvalue, $fields, $i )
{

}

?>
